<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace HyperfTest\Cases;

use HyperfTest\HttpTestCase;
use Hyperf\Testing\TestCase;
use Hyperf\Testing\Client;

use function Hyperf\Support\make;

/**
 * @internal
 * @coversNothing
 */
class ExampleTest extends HttpTestCase
{
    public function testExample()
    {
        $res = $this->client->get('/');
        $this->assertSame('GET', $res['method']);

        $res = $this->client->request('get', '/products');
        $this->assertSame(200, $res->getStatusCode());
    }
}
