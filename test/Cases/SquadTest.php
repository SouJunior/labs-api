<?php

declare(strict_types=1);

namespace HyperfTest\Cases;

use HyperfTest\HttpTestCase;
use Hyperf\Testing\TestCase;
use Hyperf\Testing\Client;

use function Hyperf\Support\make;

class SquadTest extends HttpTestCase
{
    public function testIndex()
    {
        $res = $this->request('get', '/api/squads');
        $this->assertSame(200, $res->getStatusCode());
    }
}
