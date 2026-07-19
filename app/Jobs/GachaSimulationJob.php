<?php

namespace App\Jobs;

use App\Models\SimulationResult;
use App\Services\GachaService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GachaSimulationJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $pulls)
    {
    }

    public function handle(): void
    {
        $service = new GachaService();

        // pulls回ぶんの乱数を生成
        $rolls = [];
        for ($i = 0; $i < $this->pulls; $i++) {
            $rolls[] = mt_rand() / mt_getrandmax();
        }

        // pickupの回数を数える(countPickupsを再利用)
        $pickups = $service->countPickups($rolls);

        // 結果をDBに保存
        SimulationResult::create([
            'pulls' => $this->pulls,
            'pickups' => $pickups,
        ]);
    }
}
