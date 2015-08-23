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
        $resourceMapper = new ResourceMapper;
        $resourceHandler = ResourceHandler::initialize(new EntityManagerFactory(), $resourceMapper);
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

        $resourceMapper = new ResourceMapper;
        $resourceHandler = ResourceHandler::initialize($entityManagerFactory, $resourceMapper);
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

        $resourceMapper = new ResourceMapper;
        $resourceHandler = ResourceHandler::initialize($entityManagerFactory, $resourceMapper);
        $this->assertTrue($resourceHandler instanceof ResourceHandlerInterface);

        $single = $resourceHandler->getSingle('product', 1);
        $this->assertEquals('bar', $single);
    }

    /**
     * @test
     */
    public function getCollection()
    {
        $entityManager = $this->getMockBuilder('Managlea\Component\EntityManager\DoctrineEntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->method('getCollection')
            ->willReturn(array('foo', 'bar'));

        $entityManagerFactory = $this->getMockBuilder('Managlea\Component\EntityManagerFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManagerFactory->method('create')
            ->willReturn($entityManager);

        $resourceMapper = new ResourceMapper;
        $resourceHandler = ResourceHandler::initialize($entityManagerFactory, $resourceMapper);
        $this->assertTrue($resourceHandler instanceof ResourceHandlerInterface);

        $collection = $resourceHandler->getCollection('product');
        $this->assertTrue(count($collection) == 2 && is_array($collection));
    }
}
