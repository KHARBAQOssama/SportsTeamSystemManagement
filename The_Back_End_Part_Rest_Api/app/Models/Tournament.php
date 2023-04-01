<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    public function sport(){
        return $this->belongsTo(Sport::class);
    }

    public function games(){
        return $this->hasMany(Game::class);
    }

    protected $fillable = [
        'name',
        'image_url',
        'sport_id',
        'win_points',
        'loss_points',
        'draw_points',
        'start_date',
        'created_by',
        'updated_by',
    ];
}
