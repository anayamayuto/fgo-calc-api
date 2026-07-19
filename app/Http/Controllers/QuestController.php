<?php

namespace App\Http\Controllers;

use App\Services\QuestEfficiencyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class QuestController extends Controller
{
    public function best(): JsonResponse
    {
        $bestQuest = Cache::remember('quests.best', 60, function () {
            $service = new QuestEfficiencyService();
            return $service->BestStoredQuest();
        });

        return response()->json(
            ['best_quest' => $bestQuest],
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }

    public function ranking(int $item): JsonResponse
    {
        $service = new QuestEfficiencyService();
        $ranking = $service->rankQuestsForItem($item);

        return response()->json(
            ['ranking' => $ranking],
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}