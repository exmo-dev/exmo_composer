<?php
namespace Exmo\Api\Tests;

use Exmo\Api\Request;

/**
 * Class ExmoApiTest
 * @package Exmo\Api\Tests
 */
class ExmoApiTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {

    }

    public function testRequestUserInfo()
    {
        $request = $this->createExmoApiRequest();
        $result = $request->query('user_info');
        $this->assertArrayNotHasKey('error', $result);
        $this->assertArrayHasKey('server_date', $result);
        $this->assertArrayHasKey('uid', $result);
        $this->assertArrayHasKey('balances', $result);
        $this->assertNotEmpty($result['balances']);
    }

    public function testRequestUserCancelledOrders()
    {
        $request = $this->createExmoApiRequest();
        $result = $request->query('user_cancelled_orders', ['limit' => 1, 'offset' => 0]);
        $this->assertArrayNotHasKey('error', $result);
    }

    /**
     * @return Request
     */
    private function createExmoApiRequest()
    {
        return new Request('your_key', 'your_secret');
    }
}