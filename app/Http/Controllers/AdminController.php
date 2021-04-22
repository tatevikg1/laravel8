<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * All users(id, name, email, profile photo) or filtered by name.
     * */ 
    public function index(Request $request)
    {    
        return Inertia::render('Admin/Index', [
            'user'  => Auth::user('id', 'name', 'email', 'profile_photo_path'),
            'parameter'  => $request->term,
            'users' => User::where( 'id', '!=', auth()->id() )
                ->where([['profile_photo_path', '!=', null], ['avatar_approved', false]])
                ->select('id', 'name', 'email', 'profile_photo_path', 'avatar_approved')
                ->paginate(5)
        ]);
    }

    public function approvePhoto(User $user)
    {
        $user->avatar_approved = true;
        $user->save();
        return;
    }


    public function deletePhoto(User $user)
    {
        $user->deleteProfilePhoto();
        return;
    }

}
