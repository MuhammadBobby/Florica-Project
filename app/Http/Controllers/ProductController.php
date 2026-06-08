<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()
            ->with([
                'category',
                'primaryImage',
                'images',
            ])
            ->latest()
            ->paginate(10);

        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],

            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'weight' => ['nullable', 'integer', 'min:0'],

            'is_active' => ['required', 'boolean'],

            'primary_image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048'
            ],

            'gallery_images' => ['nullable', 'array'],

            'gallery_images.*' => [
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048'
            ],
            [
                'primary_image.required' => 'Gambar utama produk wajib diisi.',
                'gallery_images.*.required' => 'Gambar galeri produk wajib diisi.',
                'gallery_images.*.image' => 'File harus berupa gambar.',
                'gallery_images.*.mimes' => 'Format file harus jpeg, jpg, png, webp.',
                'gallery_images.*.max' => 'Ukuran file maksimal 2 MB.',
                'primary_image.max' => 'Ukuran file maksimal 2 MB.',
            ]
        ]);

        DB::transaction(function () use ($request, $validated) {

            $product = Product::create([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'weight' => $validated['weight'],
                'is_active' => $validated['is_active'],
            ]);

            // Primary Image
            $primaryPath = $request
                ->file('primary_image')
                ->store('products', 'public');

            ProductImage::create([
                'product_id' => $product->id,
                'image_url' => $primaryPath,
                'is_primary' => true,
            ]);

            // Gallery Images
            if ($request->hasFile('gallery_images')) {

                foreach ($request->file('gallery_images') as $image) {

                    $path = $image->store('products', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => $path,
                        'is_primary' => false,
                    ]);
                }
            }
        });

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load([
            'category',
            'images',
            'primaryImage',
            'reviews.user',
        ]);

        return view('admin.products.show', compact(
            'product',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        $products = Product::query()
            ->with([
                'category',
                'primaryImage',
                'images',
            ])
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('product', 'categories', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'weight' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],

            'primary_image' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:2048',
            ],

            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => [
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:2048',
            ],
            [
                'primary_image.required' => 'Gambar utama produk wajib diisi.',
                'gallery_images.*.required' => 'Gambar galeri produk wajib diisi.',
                'gallery_images.*.image' => 'File harus berupa gambar.',
                'gallery_images.*.mimes' => 'Format file harus jpeg, jpg, png, webp.',
                'gallery_images.*.max' => 'Ukuran file maksimal 2 MB.',
                'primary_image.max' => 'Ukuran file maksimal 2 MB.',
            ]
        ]);

        DB::transaction(function () use ($request, $product, $validated) {
            // Update Product
            $product->update([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'weight' => $validated['weight'],
                'is_active' => $validated['is_active'],
            ]);

            /* Primary Image */
            if ($request->hasFile('primary_image')) {

                $oldPrimary = $product->primaryImage;

                if ($oldPrimary) {

                    Storage::disk('public')
                        ->delete($oldPrimary->image_url);

                    $oldPrimary->delete();
                }

                $path = $request
                    ->file('primary_image')
                    ->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path,
                    'is_primary' => true,
                ]);
            }


            // Gallery Images
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {

                    $path = $image
                        ->store('products', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => $path,
                        'is_primary' => false,
                    ]);
                }
            }
        });

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {

            foreach ($product->images as $image) {

                if ($image->image_url) {
                    Storage::disk('public')->delete($image->image_url);
                }

                $image->delete();
            }

            $product->delete();
        });

        return back()->with(
            'success',
            'Produk berhasil dihapus'
        );
    }
}
