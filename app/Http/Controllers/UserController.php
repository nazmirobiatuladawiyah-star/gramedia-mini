<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
// hasing : mengubah plain text menjadi karakter acak
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            //name, email, password validasi
            //required untuk memastikan bahwa field tidak boleh kosong
            'name' => ['required', 'max:255'],
            //email unique:users,email memastikan bahwa email yang dimasukkan tidak
            //boleh sama dengan email yang sudah ada di tabel users
            'email' => ['required', 'email','unique:users,email'],
            'password' => ['required', 'min:8', 'max:10'],
        ]);

        User::create([
            //'nama field => $isiandata'
            'name' => $validateData['name'],
            'email' => $validateData['email'],
            //hasing password agar tidak tersimpan dalam bentuk plain text
            'password' => Hash::make($validateData['password']),
            'role' => 'user'
        ]);
        //setalah berhasil menyimpan data, halaman akan di arakahkan ke mana
        // width('nama,'pesan') : mengirim pesan notifikasi 1x

        return redirect()->route('login')-> with('success','Akun berhasil di buat. Silahkan login!');
    }

    public function login(request $request)
    {
        $validateData = $request ->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

    // Auth::atempt() : memerlukan data username/email dan pw yg udah di hashing yang di lakukannya:
    //1. cek pewe yang di hashing apakah sama kaya pw yang di input
    //2. mencocokan username/email dan pw tsb
    //3. kalau cocok data penggunannya di simpan di session/cookies web

    $data = [
        "email" => $validateData['email'],
        "password" => $validateData['password'],
    ];
    if(Auth::attempt($data)) {
        $request -> session() -> regenerate();

        if(Auth::user()->role == 'admin') {
        return redirect()->route('admin.dashboard')->with('success','Login Berhasil');
        } else {
            //jika gagal login, di arahkan kmn
        return redirect()->route('home')->with('success', 'Log in berhasil');
        }
    } else {
        return redirect()->route('login')->with('error', 'Email dan Password tidak sesuai, Silahkan coba lagi!');
    }
}

    public function logout()
    {
        //hapus sesi login
        Auth::logout();
        //setelah logout, di arakan kemana
        return redirect()->route('home')->with('success', 'Anda telah logout!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
