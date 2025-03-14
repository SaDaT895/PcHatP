<?php

declare(strict_types=1);

namespace App\Domain\Message;

use App\Domain\Room\Room;
use Illuminate\Database\Eloquent\Model;
use App\Domain\User\User;

class Message extends Model
{
    const CREATED_AT = 'sent_at';
    protected string $content;

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class);
    }
}
