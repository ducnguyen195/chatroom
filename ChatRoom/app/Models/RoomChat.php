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
    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'owner_id','id');
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(User::class,'roomable');
    }
}
