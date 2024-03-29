<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function games(){
        return $this->belongsToMany(Game::class);
    }

    public function standings(){
        return $this->hasMany(Standing::class);
    }

    protected $fillable = [
        'name',
        'slag',
        'country',
        'city',
        'stadium',
        'image_url'
    ];

    public static function ourTeam(){
        $credentials = [
            'name' => 'Olympic Club Youssoufia',
            'slag' => 'OCY',
            'city' => 'YOUSSOUFIA',
            'country' => 'MOROCCO',
            'stadium' => 'DAKHLA STADIUM',
        ];

        return Team::where($credentials)->first();
    }
}
