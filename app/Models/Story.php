<?php

namespace App\Models;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Story extends Model
{
    use HasFactory;
    protected $casts = [
        'pages' => 'array'
    ];
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
