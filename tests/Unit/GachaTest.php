<?php

namespace Tests\Unit;

use App\Services\GachaService;
use PHPUnit\Framework\TestCase;

class GachaTest extends TestCase
{
    public function test_乱数0008未満はピックアップ星5(): void
    {
        $service = new GachaService();

        $result = $service->pullResult(0.005);

        $this->assertSame('pickup', $result);
    }

    public function test_乱数0009は星5(): void
    {
        $service = new GachaService();

        $result = $service->pullResult(0.009);

        $this->assertSame('star5', $result);
    }

    public function test_乱数05は星4以下(): void
    {
        $service = new GachaService();

        $result = $service->pullResult(0.5);

        $this->assertSame('other', $result);
    }
}