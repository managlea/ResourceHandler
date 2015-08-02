<?php

namespace Managlea\Component;

/**
 * Interface ResourceHandlerInterface
 * @package Managlea\Component
 */
interface ResourceHandlerInterface
{
    /**
     * @param string $resourceName resource name
     * @param int $id resource id
     * @return mixed
     */
    public static function getSingle($resourceName, $id);

    /**
     * @param string $resourceName
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function getCollection($resourceName, array $filters = array(), $limit = 20, $offset = 0);

    /**
     * @param string $resourceName
     * @param array $data
     * @return mixed
     */
    public function postSingle($resourceName, array $data);

    /**
     * @param string $resourceName
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function putSingle($resourceName, $id, array $data);

    /**
     * @param string $resourceName
     * @param int $id
     * @return mixed
     */
    public function deleteSingle($resourceName, $id);
}
