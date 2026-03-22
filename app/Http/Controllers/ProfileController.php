<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile and addresses.
     */
    public function index()
    {
        $user = Auth::user();
        $addresses = $user->addresses()->get();
        return view('profile.index', compact('user', 'addresses'));
    }

    /**
     * Update the user's name and email.
     */
    public function updateDetails(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Profile details updated successfully.');
    }

    /**
     * Store a new address for the user.
     */
    public function storeAddress(Request $request)
    {
        $request->validate([
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'postcode' => ['required', 'string', 'max:20'],
            'is_shipping' => ['nullable', 'boolean'],
            'is_billing' => ['nullable', 'boolean'],
        ]);

        $user = Auth::user();

        $user->addresses()->create([
            'street' => $request->street,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'is_shipping' => $request->has('is_shipping'),
            'is_billing' => $request->has('is_billing'),
        ]);

        return redirect()->back()->with('success', 'Address added successfully.');
    }

    /**
     * Update an existing address.
     */
    public function updateAddress(Request $request, $id)
    {
        $request->validate([
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'postcode' => ['required', 'string', 'max:20'],
            'is_shipping' => ['nullable', 'boolean'],
            'is_billing' => ['nullable', 'boolean'],
        ]);

        $user = Auth::user();
        $address = $user->addresses()->findOrFail($id);

        $address->update([
            'street' => $request->street,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'is_shipping' => $request->has('is_shipping'),
            'is_billing' => $request->has('is_billing'),
        ]);

        return redirect()->back()->with('success', 'Address updated successfully.');
    }

    /**
     * Delete an address.
     */
    public function destroyAddress($id)
    {
        $user = Auth::user();
        $address = $user->addresses()->findOrFail($id);
        $address->delete();

        return redirect()->back()->with('success', 'Address removed successfully.');
    }
}
