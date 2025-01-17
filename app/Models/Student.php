<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $fillable = [
        'programme',
        'attachment_county',
        'address',

    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function assessor(){
        return $this->belongsToMany(Assessor::class, 'assessor_student')
            ->withTimestamps();
    }

    public function assessment(){
        return $this->hasMany(Assessment::class);
    }
}
