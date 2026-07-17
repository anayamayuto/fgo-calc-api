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
}