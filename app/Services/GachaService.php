<?php

namespace App\Services;

class GachaService
{
    public function pullResult(float $roll): string
    {
        if ($roll < 0.008) {
            return 'pickup';
        }

        if ($roll < 0.01) {
            return 'star5';
        }

        return 'other';
    }

    public function drawWithCeiling(float $roll, int $pullNumber): string
    {
        // 天井: 330連目以降なら、乱数に関係なく確定ピックアップ
        if ($pullNumber >= 330) {
            return 'pickup';
        }

        // それ以外は通常抽選(pullResultを再利用)
        return $this->pullResult($roll);
    }

    public function countPickups(array $rolls): int
    {
        $count = 0;

        foreach ($rolls as $roll) {
            if ($this->pullResult($roll) === 'pickup') {
                $count++;
            }
        }

        return $count;
    }
}