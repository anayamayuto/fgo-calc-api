<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Quest;
use App\Models\QuestDrop;
use Illuminate\Database\Seeder;

class FgoSampleSeeder extends Seeder
{
    public function run(): void
    {
        // 素材
        $bone = Item::create(['name' => '凶骨']);
        $dust = Item::create(['name' => '虚影の塵']);

        // クエスト
        $fuyuki   = Quest::create(['name' => '冬木・現界の森', 'stamina' => 5, 'drop_rate' => 0.1]);
        $orleans  = Quest::create(['name' => 'オルレアン・ティーニュの村', 'stamina' => 10, 'drop_rate' => 0.1]);
        $septem   = Quest::create(['name' => 'セプテム・辺境の街', 'stamina' => 8, 'drop_rate' => 0.1]);

        // ドロップ情報 (どのクエストで何が何%落ちるか)
        QuestDrop::create(['quest_id' => $fuyuki->id,  'item_id' => $bone->id, 'drop_rate' => 0.30]);
        QuestDrop::create(['quest_id' => $orleans->id, 'item_id' => $bone->id, 'drop_rate' => 0.75]);
        QuestDrop::create(['quest_id' => $septem->id,  'item_id' => $dust->id, 'drop_rate' => 0.40]);
        QuestDrop::create(['quest_id' => $fuyuki->id,  'item_id' => $dust->id, 'drop_rate' => 0.20]);
    }
}
