<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\PitchRepository;
use App\Repositories\Interfaces\PitchRepositoryInterface;
use App\Repositories\SetPitchRepository;
use App\Repositories\Interfaces\SetPitchRepositoryInterface;
use App\Repositories\TicketRepository;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Repositories\TeamRepository;
use App\Repositories\Interfaces\TeamRepositoryInterface;
use App\Repositories\NotificationRepository;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
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
         $this->app->bind(
            SetPitchRepositoryInterface::class, 
            SetPitchRepository::class
         );
         $this->app->bind(
            TicketRepositoryInterface::class, 
            TicketRepository::class
         );
         $this->app->bind(
            TeamRepositoryInterface::class, 
            TeamRepository::class
         );
         $this->app->bind(
            NotificationRepositoryInterface::class, 
            NotificationRepository::class
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