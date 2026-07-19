<?php

namespace Tests\Feature;

use App\Models\Quest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_最効率クエストをAPIで取得できる(): void
    {
        // 準備: クエストを2件DBに保存
        Quest::create(['name' => '未確認座標X-C', 'stamina' => 7, 'drop_rate' => 0.6]);
        Quest::create(['name' => '未確認座標X-D', 'stamina' => 5, 'drop_rate' => 0.3]);

        // 実行: APIを叩く
        $response = $this->getJson('/api/quests/best');

        // 検証: 200 OK かつ 正しいJSONが返る
        $response->assertOk();
        $response->assertJson(['best_quest' => '未確認座標X-C']);
    }
}