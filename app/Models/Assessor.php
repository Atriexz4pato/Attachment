<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessor extends Model
{
    //
    //
    protected $fillable = [

    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function student(){
        return $this->belongsToMany(Assessor::class, 'assessor_student')
            ->withTimestamps();
    }

    public function assessment(){
        return $this->hasMany(Assessment::class);
    }
}
