<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::with('roles')
            ->paginate(10);

        return view('dashboard.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $roles = Role::all();
        $admin = new Admin();
        $restaurants = $user->restaurant();

        return view('dashboard.admins.create', compact('roles', 'admin', 'restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
        $validated = $request->validated();

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'restaurant_id' => $validated['restaurant_id'],
            'phone_number' => $validated['phone_number'],
        ]);

        $roles = Role::whereIn('id', $validated['roles'])->get();

        $admin->syncRoles($roles);

        return redirect()
            ->route('dashboard.admins.index')
            ->with('success', 'Admin created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $user = Auth::user();
        $roles = Role::all();
        $restaurants = $user->restaurant();
        $admin_roles = $admin->roles()->pluck('id')->toArray();

        return view('dashboard.admins.edit', compact('admin', 'roles', 'admin_roles', 'restaurants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        $validated = $request->validated();

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'restaurant_id' => $validated['restaurant_id'],
            'phone_number' => $validated['phone_number'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $admin->update($data);

        $roles = Role::whereIn('id', $validated['roles'])->get();

        $admin->syncRoles($roles);

        return redirect()
            ->route('dashboard.admins.index')
            ->with('info', 'Admin updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect()
            ->route('dashboard.admins.index')
            ->with('delete', 'Admin deleted successfully');
    }
}
