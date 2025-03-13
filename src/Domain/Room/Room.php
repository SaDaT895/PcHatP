<?php

declare(strict_types=1);

namespace App\Domain\Room;

use App\Domain\Message\Message;
use App\Domain\User\User;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'room';
    protected string $name;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
