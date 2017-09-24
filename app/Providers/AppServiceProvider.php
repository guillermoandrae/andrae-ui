<?php

namespace App\Providers;

use App\Http\Client\ClientInterface;
use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use App\Http\Client\Client;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GuzzleClient::class, function () {
            return new GuzzleClient([
                'base_uri' => env('ANDRAE_API_URL'),
                'timeout' => 15
            ]);
        });
        $this->app->bind(ClientInterface::class, Client::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
    }
}
