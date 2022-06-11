<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
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