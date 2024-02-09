<?php

declare(strict_types=1);

namespace HyperfTest\Cases;

use HyperfTest\HttpTestCase;
use Hyperf\Testing\TestCase;
use Hyperf\Testing\Client;

use function Hyperf\Support\make;

class ProductTest extends HttpTestCase
{
    public function testIndex()
    {
        $res = $this->request('get', '/api/products');
        $this->assertSame(200, $res->getStatusCode());
    }
}
