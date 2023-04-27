<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    
    public function users(){
        return $this->hasMany(User::class);
    }

    public function tournaments(){
        return $this->hasMany(Tournament::class);
    }

    public function sport(){
        return $this->belongsTo(Sport::class);
    }
    
    public function games(){
        return $this->hasMany(Game::class);
    }

    protected $fillable = [
        'name',
        'icon',
        'sport_id'
    ];
}
