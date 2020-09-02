<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\EmployeeRepository;

use App\Repositories\Interfaces\EmployeeDepartmentPositionsRepositoryInterface;
use App\Repositories\EmployeeDepartmentPositionRepository;
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
        $this->app->bind(EmployeeRepositoryInterface::class,EmployeeRepository::class);
        $this->app->bind(EmployeeDepartmentPositionsRepositoryInterface::class,EmployeeDepartmentPositionRepository::class);
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
