<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Message\Message;
use App\Domain\Room\Room;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected string $username;

    protected $fillable = ['username'];
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_users', 'user_id', 'room_id')->distinct();
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
}
