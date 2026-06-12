<?php

namespace App\Http\Controllers;

use App\Models\StoreProfile;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends Controller
{
    // ============ USER ADDRESS ROUTES ============
    public function index()
    {
        $addresses = UserAddress::where('user_id', Auth::user()->id)
            ->latest()
            ->get();

        $storeProfile = StoreProfile::first();

        return view('front.user-addresses.index', compact(
            'addresses',
            'storeProfile'
        ));
    }

    // ============ STORE ADDRESS ============
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
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

        UserAddress::create([
            ...$validated,
            'distanceKm' => $distanceKm,
            // 'is_default' => UserAddress::where('user_id', Auth::user()->id)->count() === 0
        ]);

        return back()->with(
            'success',
            'Alamat anda berhasil ditambahkan'
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
