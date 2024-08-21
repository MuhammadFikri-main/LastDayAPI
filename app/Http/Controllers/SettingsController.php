<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function updateClock(Request $request)
    {
        $validated = $request->validate([
            'wake_up_time' => 'required|date_format:H:i',
            'sleep_time' => 'required|date_format:H:i',
        ]);

        $user = auth()->user();
        $user->wake_up_time = $validated['wake_up_time'];
        $user->sleep_time = $validated['sleep_time'];
        $user->save();

        $remainingTime = $this->calculateRemainingTime($user->wake_up_time, $user->sleep_time);

        return response()->json(['remaining_time' => $remainingTime]);
    }

    private function calculateRemainingTime($wakeUpTime, $sleepTime)
    {
        $wakeUp = new \DateTime($wakeUpTime);
        $sleep = new \DateTime($sleepTime);

        $now = new \DateTime();
        $remainingTime = $sleep->diff($now)->format('%H:%I:%S');

        return $remainingTime;
    }
}

