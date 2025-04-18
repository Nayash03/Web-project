<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    protected $table = 'groupes'; 

    protected $fillable = [
        'cohort_id',
        'name',
    ];

    /**
     * Defines a many-to-many relationship with the User model.
     * A group can have many users, and users can belong to many groups.
     * The pivot table used is 'users_groups' with foreign keys 'group_id' and 'user_id'.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_groups', 'group_id', 'user_id');
    }
}
