<?php

namespace App\Http\Model;

use App\Core\Model;
use App\Core\ORM\Collection;

class User extends Model
{
    protected string $tableName = 'users';
    protected string $primaryKey = 'id';

    public $id;
    public $username;
    public $email;
    public $password;

    public function sessions(): Collection
    {
        return $this->oneToMany(Session::class, 'user_id', 'id');
    }
}
