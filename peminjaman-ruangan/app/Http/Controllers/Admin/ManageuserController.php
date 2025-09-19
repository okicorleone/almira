<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class ManageUserController extends Controller
{
    /**
     * Tampilkan daftar user
     */
    
    public function index()
    {
    $users = User::all();

    // Ambil tipe kolom 'role' langsung pakai string, tanpa DB::raw()
    $column = DB::select("SHOW COLUMNS FROM users WHERE Field = 'role'")[0]->Type;

    // Ekstrak semua opsi ENUM
    preg_match("/^enum\('(.*)'\)$/", $column, $matches);
    $roles = explode("','", $matches[1]);

    return view('admin.manageuser', compact('users', 'roles'));

    }

    public function store(Request $request,User $manageuser)
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
            'password' => Hash::make($request->password),
            'role' => $request->role,
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
            'role'  => 'nullable|string|max:255' . $manageuser->id,
            'email' => 'nullable|email|unique:users,email,' . $manageuser->id,
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
