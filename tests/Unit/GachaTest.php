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

    public function test_330連目は天井で確定ピックアップ(): void
    {
        $service = new GachaService();

        // 乱数0.5は本来other。でも330連目なら天井で強制ピックアップになるはず
        $result = $service->drawWithCeiling(0.5, 330);

        $this->assertSame('pickup', $result);
    }

    public function test_329連目までは通常抽選(): void
    {
        $service = new GachaService();

        // 100連目・乱数0.5なら、天井は効かず通常のother
        $result = $service->drawWithCeiling(0.5, 100);

        $this->assertSame('other', $result);
    }

    public function test_pickupの回数を数えられる(): void
    {
        $service = new GachaService();

        // 0.005=pickup, 0.9=other, 0.007=pickup, 0.5=other
        $rolls = [0.005, 0.9, 0.007, 0.5];

        $result = $service->countPickups($rolls);

        // pickupは2回のはず
        $this->assertSame(2, $result);
    }
}