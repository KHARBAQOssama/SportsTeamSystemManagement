<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Standing extends Model
{
    use HasFactory;

    public function tournament(){
       return $this->belongsTo(Tournament::class);
    }

    public function team(){
       return $this->belongsTo(Team::class);
    }
}
