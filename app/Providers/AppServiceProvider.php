<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Exceptions\Renderer\Renderer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Giữ mặc định cho MySQL cũ
        Schema::defaultStringLength(191);

        // Tắt code highlighting khi hiển thị Exception
        
    }
}
