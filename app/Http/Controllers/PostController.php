<?php

namespace App\Http\Controllers;

use App\Concerns\PostRepositoryAwareTrait;
use Illuminate\View\View;
use Laravel\Lumen\Routing\Controller;

class PostController extends Controller
{
    use PostRepositoryAwareTrait;

    /**
     * @param integer $id
     * @return View
     */
    public function index($id)
    {
        $post = $this->postRepository->findById($id);
        if (!isset($post['id']) || is_null($post['id'])) {
            abort(404);
        }
        return view('post', ['post' => $post]);
    }
}
