<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Intervention\Image\Facades\Image as Intervention;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:1024',
        ]);

        $imagePath = request('photo')->store('uploads', 'public');
        $image = Intervention::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();

        $request->user()->images()->create([
            'path' => $imagePath,
        ]);
        
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $image = Image::find($request->image);
        $image->delete();
        return redirect()->back();
    }

    public function togglePublic(Request $request)
    {
        $image = Image::find($request->image);
        $image->public = !$image->public;
        $image->save();
        
        return redirect()->back();
    }
}
