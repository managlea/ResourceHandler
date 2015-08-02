<?php


namespace Managlea\Component\Tests;

use Managlea\Component\ResourceHandler;

class ResourceHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \Exception
     */
    public function getSingle()
    {
        ResourceHandler::getSingle('product', 1);
    }
}
