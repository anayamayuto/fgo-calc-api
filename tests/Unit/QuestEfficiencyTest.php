<?php

namespace Tests\Unit;

use App\Services\QuestEfficiencyService;
use PHPUnit\Framework\TestCase;

class QuestEfficiencyTest extends TestCase
{
    public function test_ap効率を計算できる(): void
    {
        $service = new QuestEfficiencyService();

        // 消費AP20・ドロップ率0.5(50%)なら、1個あたり40APのはず
        $result = $service->apPerDrop(20, 0.5);

        $this->assertSame(40.0, $result);
    }

    public function test_一番効率のいいクエストを選べる(): void
    {
        $service = new QuestEfficiencyService();

        $quests = [
            ['name' => '未確認座標X-C', 'stamina' => 7, 'dropRate' => 0.6],
            ['name' => '未確認座標X-D', 'stamina' => 5, 'dropRate' => 0.3],
        ];

        $result = $service->bestQuest($quests);

        $this->assertSame('未確認座標X-C', $result);
    }

    public function test_ドロップ率が0なら例外を投げる(): void
    {
        $service = new QuestEfficiencyService();

        // このあと例外(InvalidArgumentException)が投げられることを期待する宣言
        $this->expectException(\InvalidArgumentException::class);

        // ドロップ率0で呼ぶ → 例外が飛ぶはず
        $service->apPerDrop(20, 0);
    }
}