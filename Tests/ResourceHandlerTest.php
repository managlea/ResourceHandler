<?php


namespace Managlea\Component\Tests;

use Managlea\Component\EntityManagerFactory;
use Managlea\Component\ResourceHandler;
use Managlea\Component\ResourceHandlerInterface;
use Managlea\Component\ResourceMapper;

class ResourceHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function initialize()
    {
        $resourceHandler = ResourceHandler::initialize(new EntityManagerFactory(), ResourceMapper::getInstance());
        $this->assertTrue($resourceHandler instanceof ResourceHandlerInterface);
    }
}
