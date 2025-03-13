<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Room\Room;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected string $username;

    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }
}
