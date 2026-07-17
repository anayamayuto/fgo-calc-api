<?php

namespace Tests\Feature;

use App\Models\Quest;
use App\Services\QuestEfficiencyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_DBのクエストから最効率を返す(): void
    {
        // 準備: テスト用のクエストを2件DBに保存
        Quest::create(['name' => '未確認座標X-C', 'stamina' => 7, 'drop_rate' => 0.6]);
        Quest::create(['name' => '未確認座標X-D', 'stamina' => 5, 'drop_rate' => 0.3]);

        // 実行: DBから読んで最効率を計算
        $service = new QuestEfficiencyService();
        $result = $service->bestStoredQuest();

        // 検証: 効率のいいX-Cが返るはず
        $this->assertSame('未確認座標X-C', $result);
    }
}