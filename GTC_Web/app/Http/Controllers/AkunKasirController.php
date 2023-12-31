<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\AkunKasir;

class AkunKasirController extends Controller
{
    public function login(Request $request)
    {
        // $request->validate([
        //     'username_kasir' => 'required',
        //     'password_kasir' => 'required|string',
        // ], [
        //     'username_kasir.required' => 'Silahkan mengisi username terlebih dahulu',
        //     'password_kasir.required' => 'Silahkan mengisi password terlebih dahulu',    
        // ]
        // );

        // $kasir = AkunKasir::where('username_kasir', $request->username_kasir)->first();

        // if (!$kasir || !Hash::check($request->password_kasir, $kasir->password_kasir)) {
        //     return back()->with('error', 'Username or password invalid');
        // }
        
        // $request->session()->regenerate();
        // return redirect()->route('kasir.confirm');
        $credentials = $request->validate([
            'username_kasir' => 'required',
            'password_kasir' => 'required',
        ]);

        if (Auth::guard('kasir')->attempt(
            ['username_kasir' => $credentials['username_kasir'], 'password' => $credentials['password_kasir']]
        )) {
            $request->session()->regenerate();
    
            return redirect()->intended('/menuKasir');  
        }      

        return back()->with('error', 'Invalid username or password');
    }

    public function logout(Request $request)
        {
            Auth::guard('kasir')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/');
        }

    public function showLoginForm()
    {
        return view('login_kasir'); 
    }

    public function showConfirmPage()
    {
        return view('Confirm');
    }


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
        //
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
