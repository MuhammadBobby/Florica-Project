<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // =========== CATEGORY INDEX =============
    public function index()
    {
        $categories = Category::query()
            ->withCount('products')
            ->latest()
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate
        $validated = $this->validateCategory($request);

        // Balekkan session error kalo validasi gagal
        if (!$validated) {
            return back()->withErrors($validated)->withInput();
        }

        Category::create([
            ...$validated,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori Baru Berhasil Ditambahkan!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::query()
            ->withCount('products')
            ->latest()
            ->paginate(10);

        return view('admin.categories.index', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Validate
        $validated = $this->validateCategory($request);

        $category->update([
            ...$validated,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Kategori Berhasil Dihapus!');
    }

    // ========== VALIDATION RULES & MESSAGES =============
    private function validateCategory(Request $request): array
    {
        return $request->validate(
            [
                'name' => 'required|string|max:255|min:3',
                'description' => 'nullable|string|max:500',
            ],
            [
                'name.required' => 'Nama kategori wajib diisi.',
                'name.min' => 'Nama kategori minimal 3 karakter.',
                'name.max' => 'Nama kategori maksimal 255 karakter.',

                'description.max' => 'Deskripsi maksimal 500 karakter.',
            ]
        );
    }
}
