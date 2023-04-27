<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function standings(){
        return $this->hasMany(Standing::class);
    }
    
    public function games(){
        return $this->hasMany(Game::class);
    }

    protected $fillable = [
        'name',
        'image_url',
        'branch_id',
        'start_date',
        'created_by',
        'updated_by',
    ];
}
