<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Menampilkan halaman login web
    public function showLogin()
{
    return view('auth.login'); // pastikan nama view-nya sesuai
}


public function loginWeb(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Buat token untuk web
            $token = $user->createToken('admin-token')->plainTextToken;

            return response()->json([
                'message' => 'Login berhasil.',
                'token' => $token,
                'user' => $user,
                'redirect' => route('dashboard'), // frontend bisa redirect ke dashboard
            ]);
        }

        // Bukan admin
        Auth::logout();
        return response()->json(['message' => 'Akses ditolak, bukan admin.'], 403);
    }

    return response()->json(['message' => 'Email atau password salah.'], 401);
}



    // Login untuk Mobile (User)
    public function loginApi(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Email atau password salah.'], 401);
        }

        $user = Auth::user();

        if ($user->role !== 'user') {
            return response()->json(['message' => 'Hanya user yang boleh login di mobile.'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'token' => $token,
            'user' => $user,
        ]);
    }

    //  Logout (untuk Web dan API)
    public function logout(Request $request)
    {
        if ($request->user()) {
            // Hapus semua token milik user (termasuk token web dan mobile)
            $request->user()->tokens()->delete();
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
