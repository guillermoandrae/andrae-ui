<?php

namespace App\Providers;

use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use GuzzleHttp\Client;
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
        $this->app->singleton(Client::class, function () {
            return new Client([
                'base_uri' => env('ANDRAE_API_URL'),
                'timeout' => 10
            ]);
        });
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
    }
}
