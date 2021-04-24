<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function url()
    {
        $imagePath = ($this->path) ? $this->path : '/storage/Cmh94I30gcVAlbmMzJC4GLeAuDCa6Of2XCu1e3EO.jpeg';

        return '/storage/' . $imagePath;
    }


}
