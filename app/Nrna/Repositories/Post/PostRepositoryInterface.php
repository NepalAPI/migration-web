<?php
namespace App\Nrna\Repositories\Post;


/**
 * Class PostRepositoryInterface
 * @package App\Nrna\Repository\Post
 */
interface PostRepositoryInterface
{

    /**
     * Save Post
     * @param $data
     * @return Post
     */
    public function save($data);

    /**
     * @param $limit
     * @return Collection
     */
    public function getAll($limit = null);

    /**
     * @param $id
     * @return Post
     */
    public function find($id);

    /**
     * @param $data
     * @return bool|int
     */
    public function update($data);

    /**
     *
     * @param $filter
     * @return Collection
     */
    public function latest($filter);

    /**
     * @param $id
     * @return int
     */
    public function delete($id);
}