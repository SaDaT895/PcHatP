<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateMessagesTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $messages = $this->table('messages');
        $messages
            ->addColumn('content', 'string')
            ->addTimestamps('sent_at')
            ->addColumn('sender_id', 'integer')
            ->addColumn('room_id', 'integer')
            ->addForeignKeyWithName('sender', 'sender_id', 'users', 'id')
            ->addForeignKeyWithName('room', 'room_id', 'rooms', 'id')
            ->create();
    }
}
