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
        'description',
    ];

    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'owner_id','id');
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class,'room_user','room_id','user_id');
    }

    public function messages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class,'chatroom_id','id');
    }
    public function allUsers(){
        $users = $this->users();
        if ($users){
            return $users->merge([$this->owner()]);
        }
        return [$this->owner()];
    }
}
