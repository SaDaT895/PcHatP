<?php

declare(strict_types=1);

namespace App\Domain\Room;

use App\Domain\Message\Message;
use App\Domain\User\User;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected string $name;

    protected $fillable = ['name'];
    public function users()
    {
        return $this->belongsToMany(User::class, 'room_users', 'room_id', 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
