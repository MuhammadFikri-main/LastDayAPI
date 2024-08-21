<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    public function testSchema()
    {
        $user = User::create(['name' => 'John Doe', 'email' => 'john@example.com', 'password' => Hash::make('password')]);

        $task = $user->tasks()->create([
            'title' => 'Finish LastDay Project',
            'description' => 'Complete the to-do list application',
            'priority' => 'urgent-important',
            'status' => 'pending',
            'due_date' => '2024-08-31'
        ]);

        $template = $user->templates()->create([
            'name' => 'Daily Routine',
            'tasks' => [
                ['title' => 'Morning Prayer', 'priority' => 'urgent-important'],
                ['title' => 'Check Emails', 'priority' => 'not-urgent-important'],
            ]
        ]);

        $ranking = $user->productivityRankings()->create([
            'tasks_completed' => 10,
            'total_time_spent' => 120,
            'productivity_score' => 85.5
        ]);

        return response()->json([
            'user' => $user,
            'tasks' => $user->tasks,
            'templates' => $user->templates,
            'productivityRanking' => $user->productivityRankings,
        ]);
    }
}
