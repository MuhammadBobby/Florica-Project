<?php

namespace App\Http\Controllers;

use App\Enums\RoleUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = User::query()
            ->with('addresses')
            ->where('role', RoleUser::Customer)
            ->latest()
            ->paginate(10);

        return view('admin.customers.index', [
            'customers' => $customers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(User $customer)
    {
        abort_if(!$customer->isCustomer(), 404);

        $customer->load([
            'addresses',
            'orders' => fn($q) => $q->latest()->limit(5),
            'reviews.product',
            'wishlists.product',
        ]);

        $stats = [
            'orders' => $customer->orders()->count(),
            'addresses' => $customer->addresses()->count(),
            'reviews' => $customer->reviews()->count(),
            'wishlists' => $customer->wishlists()->count(),
        ];

        return view(
            'admin.customers.show',
            compact(
                'customer',
                'stats'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $customer)
    {
        try {

            DB::transaction(function () use ($customer) {

                // Cegah hapus customer yang sudah pernah order
                if ($customer->orders()->exists()) {

                    throw new \Exception(
                        'Customer tidak dapat dihapus karena memiliki riwayat pesanan.'
                    );
                }

                // Hapus avatar
                if ($customer->avatar) {

                    Storage::disk('public')
                        ->delete('avatar/' . $customer->avatar);
                }

                // Hapus wishlist
                $customer->wishlists()->delete();

                // Hapus cart dan item cart
                if ($customer->cart) {

                    $customer->cart->items()->delete();
                    $customer->cart()->delete();
                }

                // Hapus alamat
                $customer->addresses()->delete();

                // Hapus review (opsional)
                $customer->reviews()->delete();

                // Hapus user
                $customer->delete();
            });

            return back()->with(
                'success',
                'Customer berhasil dihapus.'
            );
        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
}
