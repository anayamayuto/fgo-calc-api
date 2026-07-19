<?php

namespace App\Http\Controllers;

use App\Services\QuestEfficiencyService;
use Illuminate\Http\JsonResponse;

class QuestController extends Controller
{
    public function best(): JsonResponse
    {
        $service = new QuestEfficiencyService();
        $bestQuest = $service->BestStoredQuest();

        return response()->json(
            ['best_quest' => $bestQuest],
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}