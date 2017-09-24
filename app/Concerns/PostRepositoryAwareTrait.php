<?php

namespace App\Concerns;

use App\Repositories\PostRepositoryInterface;

trait PostRepositoryAwareTrait
{
    /**
     * @var PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * IndexController constructor.
     *
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }
}
