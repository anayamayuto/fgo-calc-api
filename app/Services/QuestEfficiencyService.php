<?php

namespace App\Services;

class QuestEfficiencyService
{
    public function apPerDrop(int $staminaCost, float $dropRate): float
    {
        return $staminaCost / $dropRate;
    }

    public function bestQuest(array $quests): string
    {
        $bestName = null;
        $bestAp = null;

        foreach ($quests as $quest) {
            // このクエストの「1個あたりAP」を計算(apPerDropを再利用)
            $ap = $this->apPerDrop($quest['stamina'], $quest['dropRate']);

            // まだ何も選んでいない、または今回の方が効率がいい(APが小さい)なら更新
            if ($bestAp === null || $ap < $bestAp) {
                $bestAp = $ap;
                $bestName = $quest['name'];
            }
        }

        return $bestName;
    }
}