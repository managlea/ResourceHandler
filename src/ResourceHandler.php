<?php

namespace Managlea\Component;


class ResourceHandler implements ResourceHandlerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private static $entityManager;
    /**
     * @var string
     */
    private static $objectName;

    /**
     * @param $resourceName
     * @return EntityManagerInterface
     * @throws \Exception
     */
    private static function getEntityManagerForResource($resourceName)
    {
        $entityManagerName = ResourceMapper::getEntityManager($resourceName);
        $entityManager = EntityManagerFactory::create($entityManagerName);

        if (!$entityManager instanceof EntityManagerInterface) {
            throw new \Exception('Entity manager not instance of EntityManagerInterface');
        }

        return $entityManager;
    }

    /**
     * @param string $resourceName
     * @return string
     */
    private static function getObjectNameForResource($resourceName)
    {
        return ResourceMapper::getObjectName($resourceName);
    }

    /**
     * @param string $resourceName
     * @throws \Exception
     */
    private static function initialize($resourceName)
    {
        self::$entityManager = self::getEntityManagerForResource($resourceName);
        self::$objectName = self::getObjectNameForResource($resourceName);
    }

    /**
     * @param string $resourceName
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public static function getSingle($resourceName, $id)
    {
        self::initialize($resourceName);

        $resource = self::$entityManager->get(self::$objectName, $id);

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
        $entityManager = self::getEntityManagerForResource($resourceName);
        $objectName = self::getObjectNameForResource($resourceName);

        $collection = $entityManager->getCollection($objectName, $filters, $limit, $offset);

        return $collection;
    }

    /**
     * @param string $resourceName
     * @param array $data
     * @return mixed
     */
    public static function postSingle($resourceName, array $data)
    {
        $entityManager = self::getEntityManagerForResource($resourceName);
        $objectName = self::getObjectNameForResource($resourceName);

        $res = $entityManager->create($objectName, $data);

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
        $entityManager = self::getEntityManagerForResource($resourceName);
        $objectName = self::getObjectNameForResource($resourceName);

        $res = $entityManager->update($objectName, $id, $data);

        return $res;
    }

    /**
     * @param string $resourceName
     * @param int $id
     * @return mixed
     */
    public static function deleteSingle($resourceName, $id)
    {
        $entityManager = self::getEntityManagerForResource($resourceName);
        $objectName = self::getObjectNameForResource($resourceName);

        $res = $entityManager->delete($objectName, $id);

        return $res;
    }
}
