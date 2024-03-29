<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreventionAdvisor extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function kits(){
        return $this->hasMany(Kits::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }
}
