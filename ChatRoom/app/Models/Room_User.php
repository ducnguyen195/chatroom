<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room_User extends Model
{
    protected $table = 'room_user';
    protected $fillable = [
        'room_id',
        'user_id',
    ];
}
