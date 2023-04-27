<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    public function publisher(){
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    protected $fillable = [
        'title',
        'content',
        'image_url',
        'user_id'
    ];
}
