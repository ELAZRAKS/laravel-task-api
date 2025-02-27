<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
