<?php

namespace App\Repositories\Interfaces;

interface RepositoryInterface
{
    /**
     * Get all resources
     * 
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * Get paginated resources
     * 
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = ['*']);

    /**
     * Create new resource
     * 
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update resource
     * 
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * Delete resource
     * 
     * @param int $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find resource by id
     * 
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * Find resource by field
     * 
     * @param string $field
     * @param mixed $value
     * @param array $columns
     * @return mixed
     */
    public function findByField($field, $value, $columns = ['*']);

    /**
     * Find resource by multiple fields
     * 
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*']);
} 