<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    /**
     * Defines a one-to-many relationship with the Note model.
     * A competence can have many notes associated with it.
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
