<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Retrospective;

class Cohort extends Model
{
    protected $fillable = ['name']; 

    /**
     * Defines a one-to-one relationship with the Retrospective model.
     * A cohort can have one retrospective.
     */
    public function retrospective()
    {
        return $this->hasOne(Retrospective::class, 'cohort_id');
    }
}
