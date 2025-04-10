<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function competence()
    {
        return $this->belongsTo(Competence::class);
    }

}
