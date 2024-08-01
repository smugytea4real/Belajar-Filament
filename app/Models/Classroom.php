<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subjects(){
        return $this->belongsToMany(Subject::class, 'classroom_subjects')->withPivot('description');
    }
}
