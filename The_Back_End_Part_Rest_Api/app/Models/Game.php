<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public function homeTeam(){
        return $this->belongsTo(Team::class, 'home');
    }

    public function awayTeam(){
        return $this->belongsTo(Team::class, 'away');
    }
    
    public function tournament(){
        return $this->belongsTo(Tournament::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

    public function sport(){
        return $this->belongsTo(Sport::class);
    }

    protected $fillable = [
        'home',
        'home_score',
        'away',
        'away_score',
        'played',
        'round',
        'fans',
        'date',
        'start_time',
        'referee',
        'referee1',
        'referee2',
        'referee3',
        'tournament_id',
        'seats_number',
        'seats_available',
        'ticket_price',
        'sport_id',
        'game_place',
        'created_by',
        'updated_by',
    ];
}
