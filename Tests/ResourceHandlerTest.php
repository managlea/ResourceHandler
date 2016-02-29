<?php


namespace Managlea\Tests;

use Managlea\Component\EntityManagerFactory;
use Managlea\Component\ResourceHandler;
use Managlea\Component\ResourceHandlerInterface;
use Managlea\Component\ResourceMapper;
use Managlea\Tests\Model\Product;

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

    /**
     * @test
     */
    public function postSingle()
    {
        $resourceHandler = $this->provideResourceHandler('create');

        $resource = $resourceHandler->postSingle('product', $this->data);
        $this->assertEquals($this->data['name'], $resource->getName());
    }

    /**
     * @test
     */
    public function putSingle()
    {
        $resourceHandler = $this->provideResourceHandler('update');
        $resource = $resourceHandler->putSingle('product', 1, $this->data);
        $this->assertEquals($this->data['name'], $resource->getName());
    }

    /**
     * @test
     */
    public function deleteSingle()
    {
        $entityManager = $this->getMockBuilder('Managlea\Component\EntityManager\DoctrineEntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->method('delete')
            ->willReturn(true);

        $entityManagerFactory = $this->getMockBuilder('Managlea\Component\EntityManagerFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManagerFactory->method('create')
            ->willReturn($entityManager);
        $resourceMapper = new ResourceMapper;

        $resourceHandler = ResourceHandler::initialize($entityManagerFactory, $resourceMapper);

        $resource = $resourceHandler->deleteSingle('product', 1);
        $this->assertEquals(true, $resource);
    }

    private $data = array('name' => 'Random Joe', 'dateOfBirth' => '1970-01-01');

    private function provideResourceHandler($action)
    {
        $data = $this->data;

        $product = new Product();
        $product->setName($data['name']);
        $product->setDateOfBirth($data['dateOfBirth']);

        $entityManager = $this->getMockBuilder('Managlea\Component\EntityManager\DoctrineEntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager->method($action)
            ->willReturn($product);

        $entityManagerFactory = $this->getMockBuilder('Managlea\Component\EntityManagerFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManagerFactory->method('create')
            ->willReturn($entityManager);
        $resourceMapper = new ResourceMapper;

        $resourceHandler = ResourceHandler::initialize($entityManagerFactory, $resourceMapper);

        return $resourceHandler;
    }
}
