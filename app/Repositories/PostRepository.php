<?php

namespace App\Repositories;

use App\Concerns\GuzzleClientAwareTrait;
use Psr\Http\Message\ResponseInterface;

class PostRepository implements PostRepositoryInterface
{
    use GuzzleClientAwareTrait;

    public function findLatest(): array
    {
        $posts = $this->parseResponse($this->getClient()->get('/posts', [
            'query' => [
                'limit' => 1
            ]
        ]));
        return $this->translate(array_pop($posts));
    }

    public function findById($id): array
    {
        return $this->translate($this->parseResponse($this->getClient()->get(sprintf('/posts/%s', $id))));
    }

    private function parseResponse(ResponseInterface $response): array
    {
        $body = json_decode($response->getBody()->getContents(), true);
        if (isset($body['data'])) {
            return $body['data'];
        }
        return [];
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
