<?php

namespace Tests\Unit;

use App\Status;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    public function testNaoDeveTerPendente()
    {
        $exceto_pendente = Status::excetoPendente();

        $this->assertNotContains(Status::PENDENTE, $exceto_pendente);
    }
}
