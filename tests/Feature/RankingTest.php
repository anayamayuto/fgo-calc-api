<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Quest;
use App\Models\QuestDrop;
use App\Services\QuestEfficiencyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RankingTest extends TestCase
{
    use RefreshDatabase;

    public function test_素材別にAP効率順でランキングを返す(): void
    {
        // 素材: 凶骨
        $bone = Item::create(['name' => '凶骨']);

        // クエスト2つ (drop_rateは旧機能用のダミー値。ランキングはquest_dropsを使う)
        $questA = Quest::create(['name' => 'クエストA', 'stamina' => 7, 'drop_rate' => 0.1]);
        $questB = Quest::create(['name' => 'クエストB', 'stamina' => 5, 'drop_rate' => 0.1]);

        // 凶骨のドロップ: A=7AP/0.6≒11.7, B=5AP/0.3≒16.7 → Aの方が効率いい
        QuestDrop::create(['quest_id' => $questA->id, 'item_id' => $bone->id, 'drop_rate' => 0.6]);
        QuestDrop::create(['quest_id' => $questB->id, 'item_id' => $bone->id, 'drop_rate' => 0.3]);

        $service = new QuestEfficiencyService();
        $ranking = $service->rankQuestsForItem($bone->id);

        // 効率のいい順(APが小さい順)に並ぶはず: 1位A, 2位B
        $this->assertSame('クエストA', $ranking[0]['name']);
        $this->assertSame('クエストB', $ranking[1]['name']);
    }

    public function test_ランキングをAPIで取得できる(): void
    {
        $bone = Item::create(['name' => '凶骨']);
        $questA = Quest::create(['name' => 'クエストA', 'stamina' => 7, 'drop_rate' => 0.1]);
        $questB = Quest::create(['name' => 'クエストB', 'stamina' => 5, 'drop_rate' => 0.1]);
        QuestDrop::create(['quest_id' => $questA->id, 'item_id' => $bone->id, 'drop_rate' => 0.6]);
        QuestDrop::create(['quest_id' => $questB->id, 'item_id' => $bone->id, 'drop_rate' => 0.3]);

        $response = $this->getJson("/api/materials/{$bone->id}/quests");

        $response->assertOk();
        // 1位がクエストAであること
        $response->assertJsonPath('ranking.0.name', 'クエストA');
    }

    public function test_素材一覧をAPIで取得できる(): void
    {
        Item::create(['name' => '凶骨']);
        Item::create(['name' => '虚影の塵']);

        $response = $this->getJson('/api/materials');

        $response->assertOk();
        $response->assertJsonCount(2, 'materials');
    }
}