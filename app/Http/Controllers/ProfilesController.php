<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * All users(id, name, email, profile photo) or filtered by name.
     * */ 
    public function index(Request $request)
    {    
        return Inertia::render('Profile/Index', [
            'user'  => Auth::user('id', 'name', 'email', 'profile_photo_path'), 
            'parameter'  => $request->term,
            'users' => User::where( 'id', '!=', auth()->id() )
                ->when($request->term, function($query, $term){
                    $query->where('name', 'LIKE', '%' . $term . '%');
                })
                ->select('id', 'name', 'email', 'profile_photo_path')
                ->paginate(3)
        ]);
    }

}
