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

    /**
     * @test
     * @expectedException \Exception
     */
    public function getSingleWrongEntityManager()
    {
        $entityManagerFactory = $this->getMockBuilder('Managlea\Component\EntityManagerFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManagerFactory->method('create')
            ->willReturn('foo');

        $resourceHandler = ResourceHandler::initialize($entityManagerFactory, ResourceMapper::getInstance());
        $resourceHandler->getSingle('product', 1);
    }

    /**
     * @test
     */
    public function getSingle()
    {
        $entityManager = $this->getMockBuilder('Managlea\Component\EntityManager\DoctrineEntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->method('get')
            ->willReturn('bar');

        $entityManagerFactory = $this->getMockBuilder('Managlea\Component\EntityManagerFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManagerFactory->method('create')
            ->willReturn($entityManager);

        $resourceHandler = ResourceHandler::initialize($entityManagerFactory, ResourceMapper::getInstance());
        $this->assertTrue($resourceHandler instanceof ResourceHandlerInterface);

        $single = $resourceHandler->getSingle('product', 1);
        $this->assertEquals('bar', $single);
    }
}
