<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\EmployeeRepository;

use App\Repositories\PositionRepository;
use App\Repositories\Interfaces\PositionRepositoryInterface;

use App\Repositories\EmployeeDepartmentPositionRepository;
use App\Repositories\Interfaces\EmployeeDepartmentPositionRepositoryInterface;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     *@author HZ
     * @return void
     * @create date 02/09/2020
     */
    public function register()
    {
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(PositionRepositoryInterface::class,PositionRepository::class);
        $this->app->bind(EmployeeDepartmentPositionRepositoryInterface::class,EmployeeDepartmentPositionRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
