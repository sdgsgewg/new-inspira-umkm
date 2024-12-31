<?php

namespace App\Http\Controllers;

use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Profile Page';

        return view('users.profile', [
            'title' => $title,
            'user' => Auth::user()
        ]);
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'title' => 'Edit Profile',
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'image' => 'image|file|max:1024',
            'name' => 'required|max:255|regex:/^[^0-9]*$/',
            'username' => 'required|max:255|regex:/^[a-z0-9_]+$/',
            'email' => 'required|email:dns|max:255',
            'address' => 'required|string|max:500',
            'phoneNumber' => 'required|numeric|digits_between:10,15',
        ];

        // if( $request->slug != $design->slug )
        // {
        //     $rules['slug'] = 'required|unique:designs';
        // }

        $validatedData = $request->validate($rules);

        // if($request->file('image')) {
        //     if($request->oldImage) {
        //         Storage::delete($request->oldImage);
        //     }
        //     $validatedData['image'] = $request->file('image')->store('user-images');
        // }

        if ($request->file('image')) {
            // Hapus gambar lama dari Cloudinary jika ada
            if ($user->image) {
                try {
                    // Ekstrak public ID dari URL gambar lama
                    $publicId = basename($user->image, '.' . pathinfo($user->image, PATHINFO_EXTENSION));
                    Cloudinary::destroy("user-images/{$publicId}");
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Failed to delete old image: ' . $e->getMessage());
                }
            }
    
            // Upload gambar baru ke Cloudinary
            try {
                $upload = Cloudinary::upload($request->file('image')->getRealPath(), [
                    'folder' => 'user-images'
                ]);
    
                $validatedData['image'] = $upload->getSecurePath();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
            }
        }

        User::where('id', $user->id)->update($validatedData);

        return redirect('/users')->with('success', 'User profile has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
