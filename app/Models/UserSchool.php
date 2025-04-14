<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSchool extends Model
{
    protected $table = 'users_schools';

    protected $fillable = [
        'user_id',
        'school_id',
        'role',
        'active',
        'cohort_id',  
    ];

    /**
     * Relation avec la cohorte (cohort).
     */
    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }

    /**
     * Relation avec l'utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'école.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
        
    }
}

