<?php

namespace App\Http\Model;

use App\Core\Model;

class Session extends Model
{
    protected string $tableName = 'sessions';
    protected string $primaryKey = 'session_id';

    public function user(): Model
    {
        return $this->oneToOne(User::class, 'user_id');
    }
}
