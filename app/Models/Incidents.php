<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidents extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function preventionAdvisor(){
        return $this->belongsTo(PreventionAdvisor::class);
    }

    public function kit(){
        return $this->belongsTo(Kits::class);
    }
    
    public function questionAnswers(){
        return $this->hasMany(QuestionsAnswers::class, 'incident_id')->with('question');
    }
}
