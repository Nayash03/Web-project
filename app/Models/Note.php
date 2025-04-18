<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
     * Defines an inverse one-to-many relationship.
     * Each note belongs to one user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Defines an inverse one-to-many relationship.
     * Each note belongs to one competence.
     */
    public function competence()
    {
        return $this->belongsTo(Competence::class);
    }
}
