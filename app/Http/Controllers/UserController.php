<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
    public function register(Request $request)
    {
        $incomingFields = $request->validate([
            'name' => ['required','min:2'],
            'email' => ['required','min:5','email','max:50','unique:users'],
            'password' => ['required','min:6','confirmed'] // password is encrypted automatically // 'confirmed' will automatically check for password_confirmation and check if they match
        ]);

        $user = User::create($incomingFields);

        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function login(Request $request)
    {
        $incomingFields = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);

        if(Auth::attempt($incomingFields, $request->remember))
        {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
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
