<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model {

    use HasFactory;

    protected $fillable = [
        'title', 'content', 'status', 'created_by', 'published_by'
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'users_stories', 'story_id', 'user_id');
    }
}