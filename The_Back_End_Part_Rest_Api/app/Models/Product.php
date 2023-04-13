<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function review(){
        return $this->hasMany(Review::class);
    }

    protected $fillable = [
        'title',
        'short_description',
        'description',
        'price',
        'quantity',
        'available',
        'user_id',
    ];
    
}
