<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    //

    protected $fillable = [

    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function assessor(){
        return $this->belongsTo(Assessor::class);
    }
}
