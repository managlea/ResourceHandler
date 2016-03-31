<?php

declare(strict_types=1);

namespace Managlea\Component;


class ResourceHandler implements ResourceHandlerInterface
{
    /**
     * @var EntityManagerFactoryInterface
     */
    private $entityManagerFactory;
    /**
     * @var ResourceMapperInterface
     */
    private $resourceMapper;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var string mapped object name for resource
     */
    private $objectName;

    /**
     * @param EntityManagerFactoryInterface $entityManagerFactory
     * @param ResourceMapperInterface $resourceMapper
     * @return ResourceHandlerInterface
     */
    public static function initialize(EntityManagerFactoryInterface $entityManagerFactory, ResourceMapperInterface $resourceMapper)
    {
        $resourceHandler = new self();

        $resourceHandler->entityManagerFactory = $entityManagerFactory;
        $resourceHandler->resourceMapper = $resourceMapper;

        return $resourceHandler;
    }

    /**
     * @param string $resourceName
     * @return EntityManagerInterface
     * @throws \Exception
     */
    private function getEntityManagerForResource(string $resourceName) : EntityManagerInterface
    {
        $entityManagerName = $this->resourceMapper->getEntityManagerName($resourceName);
        $entityManager = $this->entityManagerFactory->create($entityManagerName);

        return $entityManager;
    }

    /**
     * @param string $resourceName
     * @return string
     */
    private function getObjectNameForResource(string $resourceName) : string
    {
        return $this->resourceMapper->getObjectName($resourceName);
    }

    /**
     * @param string $resourceName
     * @throws \Exception
     */
    private function setup(string $resourceName)
    {
        $this->entityManager = $this->getEntityManagerForResource($resourceName);
        $this->objectName = $this->getObjectNameForResource($resourceName);
    }

    /**
     * @param string $resourceName
     * @param int $id
     * @param array|null $filters
     * @return mixed
     * @throws \Exception
     */
    public function getSingle(string $resourceName, int $id, array $filters = array())
    {
        $this->setup($resourceName);

        $resource = $this->entityManager->get($this->objectName, $id, $filters);

        return $resource;
    }

    /**
     * @param string $resourceName
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getCollection(string $resourceName, array $filters = array(), int $limit = 20, int $offset = 0) : array
    {
        $this->setup($resourceName);

        $collection = $this->entityManager->getCollection($this->objectName, $filters, $limit, $offset);

        return $collection;
    }

    /**
     * @param string $resourceName
     * @param array $data
     * @return mixed
     */
    public function postSingle(string $resourceName, array $data)
    {
        $this->setup($resourceName);

        $res = $this->entityManager->create($this->objectName, $data);

        return $res;
    }

    /**
     * @param string $resourceName
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function putSingle(string $resourceName, int $id, array $data)
    {
        $this->setup($resourceName);

        $res = $this->entityManager->update($this->objectName, $id, $data);

        return $res;
    }

    /**
     * @param string $resourceName
     * @param int $id
     * @return bool
     */
    public function deleteSingle(string $resourceName, int $id) : bool
    {
        $this->setup($resourceName);

        $res = $this->entityManager->delete($this->objectName, $id);

        return $res;
    }
}
