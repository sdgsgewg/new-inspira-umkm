<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index', [
            'title' => 'Register',
            'active' => 'register'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255|regex:/^[^0-9]*$/',
            'username' => 'required|max:255|regex:/^[a-z0-9_]+$/|unique:users',
            'email' => 'required|email:dns|max:255|unique:users',
            'password' => 'required|min:8|max:255',
            'password_confirmation' => 'required|min:8|max:255|same:password',
            'dob' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female',
            'address' => 'required|string|max:500',
            'phoneNumber' => 'required|numeric|digits_between:10,15',
        ]);

        // $validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect()->route('login')->with('success', __('register.registration_success'));
    }
}
