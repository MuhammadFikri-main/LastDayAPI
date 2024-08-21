<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = ['name', 'tasks', 'user_id'];

    protected $casts = [
        'tasks' => 'array', // Cast the JSON to an array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
