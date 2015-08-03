<?php


namespace Managlea\Component\Tests;

use Managlea\Component\EntityManagerFactory;
use Managlea\Component\ResourceHandler;
use Managlea\Component\ResourceMapper;

class ResourceHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @eexpectedException \Exception
     */
    public function getSingle()
    {
        ResourceHandler::initialize(new EntityManagerFactory(), ResourceMapper::getInstance());
    }
}
