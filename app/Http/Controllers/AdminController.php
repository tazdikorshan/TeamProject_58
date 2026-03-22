<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller {
    private function requireAdmin() {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized'); }
             }

    public function customersIndex() {
        $this->requireAdmin();

        $customers = User::where('is_admin', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.customers.index', compact('customers')); }

    public function customersStore(Request $request) {
       
    $this->requireAdmin();

        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8','confirmed'], ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => 0,
            'must_change_password' => 0, ]);

        return redirect('/admin/customers')->with('success', 'Customer created successfully.'); }

    public function customersUpdate(Request $request, $id) {
        $this->requireAdmin();

        $customer = User::where('is_admin', 0)->findOrFail($id);

        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,' . $customer->id],
            'password' => ['nullable','string','min:8','confirmed'], ]);

        $customer->name = $request->name;
        $customer->email = $request->email;

        if ($request->filled('password')) {
            $customer->password = Hash::make($request->password); }

        $customer->save();

        return redirect('/admin/customers')->with('success', 'Customer has been updated.'); }

       public function customersDelete($id) {
           
       $this->requireAdmin();
       
       $customer = User::where('is_admin', 0)->findOrFail($id);
       $customer->delete();

    return redirect('/admin/customers')->with('success', 'Customer has been deleted.'); }
    }
