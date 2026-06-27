<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use App\Models\Wishlist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Query Product
        $query = Product::query()
            ->with([
                'category',
                'primaryImage',
                'images',
            ]);

        // Search
        if ($search = request('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        // category filter
        if ($category = request('category')) {
            $query->whereHas(
                'category',
                fn($q) =>
                $q->where('slug', $category)
            );
        }

        // Status
        if ($status = request('status')) {
            $query->where('is_active', $status === 'active');
        }


        $products = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

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
        $validated = $this->validateProduct($request);

        $slug = Str::slug($validated['name']);

        if (Product::where('slug', $slug)->exists()) {
            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'Nama produk sudah terdaftar. Silahkan masukkan produk lain.',
                ]);
        }

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
        $validated = $this->validateProduct($request);

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

            Wishlist::where(
                'product_id',
                $product->id
            )->delete();

            CartItem::where(
                'product_id',
                $product->id
            )->delete();

            $product->delete();
        });

        return back()->with(
            'success',
            'Produk berhasil dihapus'
        );
    }

    // ========== VALIDATION RULES & MESSAGES =============
    private function validateProduct(Request $request): array
    {
        return $request->validate(
            [
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
            ],
            [
                // Category
                'category_id.required' => 'Kategori produk wajib dipilih.',
                'category_id.exists' => 'Kategori yang dipilih tidak valid.',

                // Name
                'name.required' => 'Nama produk wajib diisi.',
                'name.max' => 'Nama produk maksimal 255 karakter.',

                // Description
                'description.required' => 'Deskripsi produk wajib diisi.',

                // Price
                'price.required' => 'Harga produk wajib diisi.',
                'price.numeric' => 'Harga produk harus berupa angka.',
                'price.min' => 'Harga produk tidak boleh kurang dari 0.',

                // Stock
                'stock.required' => 'Stok produk wajib diisi.',
                'stock.integer' => 'Stok produk harus berupa angka bulat.',
                'stock.min' => 'Stok produk tidak boleh kurang dari 0.',

                // Weight
                'weight.integer' => 'Berat produk harus berupa angka bulat.',
                'weight.min' => 'Berat produk tidak boleh kurang dari 0.',

                // Status
                'is_active.required' => 'Status produk wajib dipilih.',
                'is_active.boolean' => 'Status produk tidak valid.',

                // Primary Image
                'primary_image.required' => 'Gambar utama wajib diupload.',
                'primary_image.image' => 'File gambar utama harus berupa gambar.',
                'primary_image.mimes' => 'Gambar utama harus berformat JPG, JPEG, PNG, atau WEBP.',
                'primary_image.max' => 'Ukuran gambar utama maksimal 2 MB.',

                // Gallery Images
                'gallery_images.array' => 'Galeri gambar tidak valid.',

                'gallery_images.*.image' => 'Semua file galeri harus berupa gambar.',
                'gallery_images.*.mimes' => 'Format gambar galeri harus JPG, JPEG, PNG, atau WEBP.',
                'gallery_images.*.max' => 'Ukuran setiap gambar galeri maksimal 2 MB.',
            ]
        );
    }
}
