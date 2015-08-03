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
     * @var string
     */
    private $objectName;

    /**
     * @param EntityManagerFactoryInterface $entityManagerFactory
     * @param ResourceMapperInterface $resourceMapper
     * @return ResourceHandler
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
        $entityManagerName = $this->resourceMapper->getEntityManager($resourceName);
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
     * @return mixed
     * @throws \Exception
     */
    public function getSingle($resourceName, $id)
    {
        $this->setup($resourceName);

        $resource = $this->entityManager->get($this->objectName, $id);

        return $resource;
    }

    /**
     * @param string $resourceName
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public static function getCollection($resourceName, array $filters = array(), $limit = 20, $offset = 0)
    {
        self::initialize($resourceName);

        $collection = self::$entityManager->getCollection(self::$objectName, $filters, $limit, $offset);

        return $collection;
    }

    /**
     * @param string $resourceName
     * @param array $data
     * @return mixed
     */
    public static function postSingle($resourceName, array $data)
    {
        self::initialize($resourceName);

        $res = self::$entityManager->create(self::$objectName, $data);

        return $res;
    }

    /**
     * @param string $resourceName
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public static function putSingle($resourceName, $id, array $data)
    {
        self::initialize($resourceName);

        $res = self::$entityManager->update(self::$objectName, $id, $data);

        return $res;
    }

    /**
     * @param string $resourceName
     * @param int $id
     * @return mixed
     */
    public static function deleteSingle($resourceName, $id)
    {
        self::initialize($resourceName);

        $res = self::$entityManager->delete(self::$objectName, $id);

        return $res;
    }
}
