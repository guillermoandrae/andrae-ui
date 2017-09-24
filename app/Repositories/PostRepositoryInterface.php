<?php

namespace App\Repositories;

interface PostRepositoryInterface
{
    /**
     * @return array
     */
    public function findLatest(): array;

    /**
     * @param mixed $id
     *
     * @return array
     */
    public function findById($id): array;
}
