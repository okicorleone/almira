<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManageUserController extends Controller
{
    /**
     * Tampilkan daftar user
     */
    public function index()
    {
        $users = User::all();
        return view('admin.manageuser', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'nullable|string|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.manageuser.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit user
     */
    public function update(Request $request, User $manageuser)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $manageuser->id,
            'role' => 'nullable|string|unique:users,role,' . $manageuser->id,
        ]);

        $manageuser->update($request->only('name', 'email', 'role'));

        return redirect()->route('admin.manageuser.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Hapus user
     */
    public function destroy(User $manageuser)
    {
        $manageuser->delete();
        return redirect()->route('admin.manageuser.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
