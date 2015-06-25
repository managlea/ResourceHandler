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
        return $resourceName;;
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
     * @param array $filters
     */
    public function getCollection(array $filters = array())
    {
        // TODO: Implement getCollection() method.
    }

    /**
     * @param array $data
     */
    public function postSingle(array $data)
    {
        // TODO: Implement postSingle() method.
    }

    /**
     * @param int $resourceId
     * @param array $data
     */
    public function putSingle($resourceId, array $data)
    {
        // TODO: Implement putSingle() method.
    }

    /**
     * @param int $resourceId
     */
    public function deleteSingle($resourceId)
    {
        // TODO: Implement deleteSingle() method.
    }
}
