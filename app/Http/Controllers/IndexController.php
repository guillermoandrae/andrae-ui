<?php

namespace App\Http\Controllers;

use App\Concerns\PostRepositoryAwareTrait;
use Laravel\Lumen\Routing\Controller;

class IndexController extends Controller
{
    use PostRepositoryAwareTrait;

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $post = $this->postRepository->findLatest();
        return view('index', ['post' => $post]);
    }
}
