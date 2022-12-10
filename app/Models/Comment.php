<?php

namespace App\Models;

use App\Models\User;
use App\Models\Story;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = true;
    protected $fillable = ['user_id', 'story_id', 'content'];
    public function story()
    {
        return $this->belongsTo(Story::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
