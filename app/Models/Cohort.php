<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Retrospective;

class Cohort extends Model
{
    protected $fillable = ['name']; 

    public function retrospective()
    {
        return $this->hasOne(Retrospective::class, 'cohort_id');
    }

}
