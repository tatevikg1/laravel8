<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'sender',
    'receiver',
    'text',
  ];

  public function sender()
  {
    return $this->hasOne(User::class, 'id', 'sender');
  }

  public function receiver()
  {
    return $this->hasOne(User::class, 'id', 'receiver');
  }
    
}
