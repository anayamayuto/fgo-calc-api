<?php

namespace App\Services;

class QuestEfficiencyService
{
    public function apPerDrop(int $staminaCost, float $dropRate): float
    {
        return $staminaCost / $dropRate;
    }
}