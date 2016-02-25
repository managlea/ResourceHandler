<?php

declare(strict_types=1);

namespace Managlea\Component;

/**
 * Interface ResourceHandlerInterface
 * @package Managlea\Component
 */
interface ResourceHandlerInterface
{
    /**
     * @param EntityManagerFactoryInterface $entityManagerFactory
     * @param ResourceMapperInterface $resourceMapper
     * @return ResourceHandlerInterface
     */
    public static function initialize(EntityManagerFactoryInterface $entityManagerFactory, ResourceMapperInterface $resourceMapper);

    /**
     * @param string $resourceName resource name
     * @param int $id resource id
     * @param array|null $filters
     * @return mixed
     */
    public function getSingle(string $resourceName, int $id, array $filters = array());

    /**
     * @param string $resourceName
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function getCollection(string $resourceName, array $filters = array(), int $limit = 20, int $offset = 0);

    /**
     * @param string $resourceName
     * @param array $data
     * @return mixed
     */
    public function postSingle(string $resourceName, array $data);

    /**
     * @param string $resourceName
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function putSingle(string $resourceName, int $id, array $data);

    /**
     * @param string $resourceName
     * @param int $id
     * @return mixed
     */
    public function deleteSingle(string $resourceName, int $id);
}
