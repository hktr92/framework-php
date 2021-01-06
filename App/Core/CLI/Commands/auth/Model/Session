<?php

namespace App\Http\Model;

use App\Core\Model;

class Session extends Model
{
    protected string $tableName = 'sessions';
    protected string $primaryKey = 'session_id';

    public $session_id;
    public $user_id;
    public $login_time;

    public function user(): ?Model
    {
        return $this->oneToOne(User::class, 'user_id');
    }
}
