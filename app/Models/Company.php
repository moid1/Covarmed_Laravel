<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function preventionalAdvisors(){
        return $this->hasMany(PreventionAdvisor::class);
    }

    public function question(){
        return $this->belongsTo(Question::class, 'questions');
    }
}
