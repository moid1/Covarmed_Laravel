<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kits extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function preventionAdvisor(){
        return $this->belongsTo(PreventionAdvisor::class);
    }
}
