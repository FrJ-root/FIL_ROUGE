<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\ExampleRepositoryInterface;
use App\Repositories\ExampleRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ExampleRepositoryInterface::class,
            ExampleRepository::class
        );
        
        // Register other repositories
    }
}
