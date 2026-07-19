<?php

namespace App\Services;
use App\Models\Quest;
use App\Models\QuestDrop;

class QuestEfficiencyService
{
    public function apPerDrop(int $staminaCost, float $dropRate): float
    {
        if ($dropRate <= 0) {
            throw new \InvalidArgumentException('ドロップ率は0より大きい必要があります');
        }
        
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

    public function bestStoredQuest(): string
    {
        $quests = Quest::all()->map(function ($quest) {
            return [
                'name' => $quest->name,
                'stamina' => (int) $quest->stamina,
                'dropRate' => (float) $quest->drop_rate,
            ];
        })->all();

        return $this->bestQuest($quests);
    }

    public function rankQuestsForItem(int $itemId): array
    {
        // その素材が落ちるドロップ情報を、繋がったクエストごと取得
        $drops = QuestDrop::with('quest')
            ->where('item_id', $itemId)
            ->get();

        // 各クエストのAP効率を計算して配列にする
        $ranking = $drops->map(function ($drop) {
            return [
                'name' => $drop->quest->name,
                'ap_per_drop' => $this->apPerDrop((int) $drop->quest->stamina, (float) $drop->drop_rate),
            ];
        })->all();

        // AP効率が良い順(APが小さい順)に並べ替え
        usort($ranking, fn ($a, $b) => $a['ap_per_drop'] <=> $b['ap_per_drop']);

        return $ranking;
    }
}