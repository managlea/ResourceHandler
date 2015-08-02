<?php

namespace Managlea\Component;


class ResourceHandler implements ResourceHandlerInterface
{
    /**
     * @param string $resourceName
     * @return EntityManagerInterface
     */
    private static function getEntityManagerForResource($resourceName)
    {
        return EntityManagerFactory::createForResource($resourceName);
    }

    /**
     * @param string $name
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public static function getSingle($name, $id)
    {
        $entityManager = self::getEntityManagerForResource($name);

        if (!$entityManager instanceof EntityManagerInterface) {
            throw new \Exception('Entity manager not instance of EntityManagerInterface');
        }

        $resource = $entityManager->get($name, $id);

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
        // TODO: Implement getCollection() method.
    }

    /**
     * @param string $resourceName
     * @param array $data
     * @return mixed
     */
    public function postSingle($resourceName, array $data)
    {
        // TODO: Implement postSingle() method.
    }

    /**
     * @param string $resourceName
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function putSingle($resourceName, $id, array $data)
    {
        // TODO: Implement putSingle() method.
    }

    /**
     * @param string $resourceName
     * @param int $id
     * @return mixed
     */
    public function deleteSingle($resourceName, $id)
    {
        // TODO: Implement deleteSingle() method.
    }
}
