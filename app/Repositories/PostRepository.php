<?php

namespace App\Repositories;

use App\Http\Client\ClientInterface;
use Illuminate\Support\Facades\Cache;

class PostRepository implements PostRepositoryInterface
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function findLatest(): array
    {
        $client = $this->getClient();
        $posts = Cache::remember(
            'posts-find-latest',
            60,
            function () use ($client) {
                return $client->get('/posts', [
                    'query' => [
                        'limit' => 1
                    ]
                ]);
            }
        );
        return $this->translate(array_pop($posts));
    }

    public function findById($id): array
    {
        $client = $this->getClient();
        $post = Cache::rememberForever(
            'posts-find-by-id',
            function () use ($client, $id) {
                return $client->get(sprintf('/posts/%s', $id));
            }
        );
        return $this->translate($post);
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    private function translate(array $post)
    {
        $postData = [];
        foreach ($post as $field => $value) {
            switch ($field) {
                case 'htmlUrl':
                    $postData['uri'] = sprintf('post/%s/%s', $post['id'], $post['slug']);
                    break;
                case 'thumbnailUrl':
                    $postData['image'] = explode(',', $post['thumbnailUrl'])[0];
                    break;
                case 'createdAt':
                    $createdAt = new \DateTime($post['createdAt']);
                    $postData['datetime'] = $createdAt->format(DATE_ATOM);
                    $postData['time'] = $createdAt->format(DATE_RSS);
                    break;
                case 'source':
                    $postData['source'] = strtolower($post['source']);
                    break;
                default:
                    $postData[$field] = $value;
                    break;
            }
        }
        return $postData;
    }
}
