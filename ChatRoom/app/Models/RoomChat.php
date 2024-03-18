<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, string $string2)
 */
class RoomChat extends Model
{
    use HasFactory;
    protected $table = 'room_chats';
    protected $fillable = [
      'name',
        'icon',
        'owner_id',
    ];
    protected $with = 'owner';
    public function owner(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class,'id','owner_id');
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class,'room_user','room_id','user_id');
    }
}
