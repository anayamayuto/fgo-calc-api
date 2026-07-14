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
}