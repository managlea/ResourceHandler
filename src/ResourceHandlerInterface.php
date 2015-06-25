<?php

namespace Managlea\Component;


interface ResourceHandlerInterface
{
    /**
     * @param string $name resource name
     * @param int $id resource id
     * @return mixed
     */
    public static function getSingle($name, $id);

    /**
     * @param array $filters
     */
    public function getCollection(array $filters = array());

    /**
     * @param array $data
     */
    public function postSingle(array $data);

    /**
     * @param int $resourceId
     * @param array $data
     */
    public function putSingle($resourceId, array $data);

    /**
     * @param int $resourceId
     */
    public function deleteSingle($resourceId);
}