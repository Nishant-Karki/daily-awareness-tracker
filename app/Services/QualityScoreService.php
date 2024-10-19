<?php

namespace App\Services;

use App\Models\QualityScore;
use Illuminate\Support\Facades\Auth;

class QualityScoreService
{
    public static $qualityLabels = [
        2 => 'Excellent',
        1 => 'Good',
        0 => 'Average',
        -1 => 'Fair',
        -2 => 'Poor',
    ];

    public function getWeeklyMood()
    {
        $weeklyQualityScores = $this->getLastWeekData();

        //if empty
        if ($weeklyQualityScores->isEmpty()) {
            return 'No data';
        }

        $weeklyMoodScore = $weeklyQualityScores->avg('score');


        return self::$qualityLabels[round($weeklyMoodScore)] ?? 'Unknown';
    }

    private function getLastWeekData()
    {
        //getting score of last 7 days
        return QualityScore::where('user_id', Auth::id())
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->get();
    }

    public function getLastWeekSameDayData()
    {
        $lastWeekSameDay = now()->subWeek()->format('Y-m-d');

        $weeklyQualityScores = QualityScore::where('user_id', Auth::id())
            ->whereDate('created_at', $lastWeekSameDay)
            ->get();

        if ($weeklyQualityScores->isEmpty()) {
            return 'No data';
        }
        $weeklyMoodScore = $weeklyQualityScores->avg('score');
        return self::$qualityLabels[round($weeklyMoodScore)] ?? 'Unknown';
    }
}
