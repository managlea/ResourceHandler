<?php

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
     * @param $resourceName
     * @return EntityManagerInterface
     * @throws \Exception
     */
    private function getEntityManagerForResource($resourceName)
    {
        $entityManagerName = $this->resourceMapper->getEntityManagerName($resourceName);
        $entityManager = $this->entityManagerFactory->create($entityManagerName);

        if (!$entityManager instanceof EntityManagerInterface) {
            throw new \Exception('Entity manager not instance of EntityManagerInterface');
        }

        return $entityManager;
    }

    /**
     * @param string $resourceName
     * @return string
     */
    private function getObjectNameForResource($resourceName)
    {
        return $this->resourceMapper->getObjectName($resourceName);
    }

    /**
     * @param string $resourceName
     * @throws \Exception
     */
    private function setup($resourceName)
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
    public function getSingle($resourceName, $id, array $filters = array())
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
     * @return mixed
     */
    public function getCollection($resourceName, array $filters = array(), $limit = 20, $offset = 0)
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
    public function postSingle($resourceName, array $data)
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
    public function putSingle($resourceName, $id, array $data)
    {
        $this->setup($resourceName);

        $res = $this->entityManager->update($this->objectName, $id, $data);

        return $res;
    }

    /**
     * @param string $resourceName
     * @param int $id
     * @return mixed
     */
    public function deleteSingle($resourceName, $id)
    {
        $this->setup($resourceName);

        $res = $this->entityManager->delete($this->objectName, $id);

        return $res;
    }
}
