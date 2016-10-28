<?php


namespace Managlea\Tests;

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
        $resourceHandler = $this->getResourceHandler();
        $this->assertTrue($resourceHandler instanceof ResourceHandlerInterface);
    }

    /**
     * @test
     */
    public function getSingle()
    {
        $resourceHandler = $this->getResourceHandler('get', 'bar');
        $this->assertTrue($resourceHandler instanceof ResourceHandlerInterface);

        $single = $resourceHandler->getSingle('product', 1);
        $this->assertEquals('bar', $single);
    }

    /**
     * @test
     */
    public function getCollection()
    {
        $resourceHandler = $this->getResourceHandler('getCollection', array('foo', 'bar'));
        $this->assertTrue($resourceHandler instanceof ResourceHandlerInterface);

        $collection = $resourceHandler->getCollection('product');
        $this->assertTrue(count($collection) == 2 && is_array($collection));
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function postSingle($data)
    {
        $resourceHandler = $this->provideResourceHandler('create');
        $resource = $resourceHandler->postSingle('product', $data);
        $this->assertEquals($data['name'], $resource->getName());
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function putSingle($data)
    {
        $resourceHandler = $this->provideResourceHandler('update');
        $resource = $resourceHandler->putSingle('product', 1, $data);
        $this->assertEquals($data['name'], $resource->getName());
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

        $resourceHandler = new ResourceHandler($entityManagerFactory, $resourceMapper);

        $resource = $resourceHandler->deleteSingle('product', 1);
        $this->assertEquals(true, $resource);
    }

    private function provideResourceHandler($action)
    {
        $data = current(current($this->dataProvider()));

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

        $resourceHandler = new ResourceHandler($entityManagerFactory, $resourceMapper);

        return $resourceHandler;
    }

    /**
     * @param $method
     * @param $returnData
     * @return ResourceHandlerInterface
     */
    public function getResourceHandler($method = null, $returnData = null)
    {
        $entityManager = $this->getMockBuilder('Managlea\Component\EntityManager\DoctrineEntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        if (!is_null($method)) {
            $entityManager->method($method)
                ->willReturn($returnData);
        }

        $entityManagerFactory = $this->getMockBuilder('Managlea\Component\EntityManagerFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManagerFactory->method('create')
            ->willReturn($entityManager);

        $resourceMapper = new ResourceMapper;
        $resourceHandler = new ResourceHandler($entityManagerFactory, $resourceMapper);

        return $resourceHandler;
    }

    public function dataProvider()
    {
        return array(
            array(array('name' => 'Random Joe', 'dateOfBirth' => '1970-01-01'))
        );
    }
}
