<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductivityRanking extends Model
{
    protected $fillable = ['tasks_completed', 'total_time_spent', 'productivity_score', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
