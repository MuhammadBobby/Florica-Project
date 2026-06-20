<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductReview;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orderCount = Order::where(
            'user_id',
            $user->id
        )->count();

        $reviewCount = ProductReview::where(
            'user_id',
            $user->id
        )->count();

        $addressCount = UserAddress::where(
            'user_id',
            $user->id
        )->count();

        return view(
            'front.profile.index',
            compact(
                'user',
                'orderCount',
                'reviewCount',
                'addressCount'
            )
        );
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'full_name' => [
                'required',
                'string',
                'max:255'
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30'
            ],

            'avatar' => [
                'nullable',
                'image',
                'max:2048'
            ]
        ]);

        if ($request->hasFile('avatar')) {

            if (
                $user->avatar &&
                Storage::disk('public')->exists(
                    $user->avatar
                )
            ) {

                Storage::disk('public')
                    ->delete(
                        $user->avatar
                    );
            }

            $validated['avatar'] =
                $request
                ->file('avatar')
                ->store(
                    'avatars',
                    'public'
                );
        }

        User::where('id', $user->id)->update($validated);

        return back()->with(
            'success',
            'Profil berhasil diperbarui'
        );
    }
}
