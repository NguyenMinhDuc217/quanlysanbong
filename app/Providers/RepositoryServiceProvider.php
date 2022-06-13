<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\PitchRepository;
use App\Repositories\Interfaces\PitchRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class RepositoryServiceProvider extends ServiceProvider
{
    public $_USER = null;
    public function register()
    {
        $this->app->bind(
           UserRepositoryInterface::class, 
           UserRepository::class
        );
        $this->app->bind(
            PitchRepositoryInterface::class, 
            PitchRepository::class
         );
    
    }
     /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}