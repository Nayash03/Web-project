<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    protected $table = 'groupes'; 

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_groups');
    }
}

