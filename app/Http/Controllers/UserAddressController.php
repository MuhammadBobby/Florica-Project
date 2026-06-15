<?php

namespace App\Http\Controllers;

use App\Models\StoreProfile;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends Controller
{
    // ============ USER ADDRESS ROUTES ============
    public function index(Request $request)
    {
        // ambil addrss utaama duluan
        $addresses = UserAddress::where('user_id', Auth::user()->id)
            ->orderBy('is_default', 'desc')
            ->get();

        $storeProfile = StoreProfile::first();

        // Khusus edit
        $editingAddress = null;

        if ($request->filled('edit')) {
            $editingAddress = UserAddress::find($request->edit);
        }

        return view('front.user-addresses.index', compact(
            'addresses',
            'storeProfile',
            'editingAddress'
        ));
    }

    // ============ STORE ADDRESS ============
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'is_default' => 'nullable|boolean',
            'district' => 'nullable|string',
            'city' => 'nullable|string',
            'province' => 'nullable|string',
            'postal_code' => 'nullable|numeric',
        ]);

        $distanceKm = null;

        $store = StoreProfile::first();

        if (
            $store &&
            $store->latitude &&
            $store->longitude
        ) {

            $distanceKm = $this->calculateDistance(
                $store->latitude,
                $store->longitude,
                $validated['latitude'],
                $validated['longitude']
            );
        }

        $isDefault = $request->boolean('is_default');

        if ($isDefault) {
            UserAddress::where('user_id', Auth::user()->id)
                ->update([
                    'is_default' => false,
                ]);
        }

        UserAddress::create([
            ...$validated,
            'is_default' => $isDefault,
            'user_id' => Auth::user()->id,
            'distanceKm' => $distanceKm,
        ]);

        return back()->with(
            'success',
            'Alamat anda berhasil ditambahkan'
        );
    }


    // ============ UPDATE ADDRESS ============
    public function update(Request $request, UserAddress $my_address)
    {
        abort_if(
            $my_address->user_id !== Auth::id(),
            403
        );

        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'is_default' => 'nullable|boolean',
            'district' => 'nullable|string',
            'city' => 'nullable|string',
            'province' => 'nullable|string',
            'postal_code' => 'nullable|numeric',
        ]);

        $distanceKm = null;

        $store = StoreProfile::first();

        if (
            $store &&
            $store->latitude &&
            $store->longitude
        ) {
            $distanceKm = $this->calculateDistance(
                $store->latitude,
                $store->longitude,
                $validated['latitude'],
                $validated['longitude']
            );
        }

        $isDefault = $request->boolean('is_default');

        // update yg lain kecuali request
        if ($isDefault) {
            UserAddress::where('user_id', Auth::user()->id)
                ->where('id', '!=', $my_address->id)
                ->update([
                    'is_default' => false,
                ]);
        }

        $my_address->update([
            ...$validated,
            'is_default' => $isDefault,
            'distanceKm' => $distanceKm,
        ]);

        return redirect()
            ->route('my-addresses.index')
            ->with(
                'success',
                'Alamat berhasil diperbarui.'
            );
    }


    // =========== DELETE ADDRESS ============
    public function destroy(UserAddress $my_address)
    {
        abort_if(
            $my_address->user_id !== Auth::id(),
            403
        );

        $wasDefault = $my_address->is_default;

        $my_address->delete();

        // jika alamat utama dihapus,
        // jadikan alamat pertama sebagai default
        if ($wasDefault) {
            UserAddress::where(
                'user_id',
                Auth::id()
            )
                ->first()
                ?->update([
                    'is_default' => true,
                ]);
        }

        return back()->with(
            'success',
            'Alamat berhasil dihapus.'
        );
    }


    // ============ FUNC CALCULATE DISTANCE =========
    private function calculateDistance(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): float {

        $earthRadius = 6371;

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);

        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle =
            2 * asin(
                sqrt(
                    pow(sin($latDelta / 2), 2)
                        +
                        cos($latFrom)
                        * cos($latTo)
                        * pow(sin($lonDelta / 2), 2)
                )
            );

        return round(
            $earthRadius * $angle,
            2
        );
    }
}
