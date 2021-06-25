<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
//        DB::listen(function ($exect) {
//            echo $exect->sql . PHP_EOL;
//            echo json_encode($exect->bindings) . PHP_EOL;
//        });
    }
}
