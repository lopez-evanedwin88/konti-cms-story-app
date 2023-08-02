<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Story extends Models {

    use HasFactory;

    protected $fillable = [
        'title', 'content', 'status'   
    ]
}