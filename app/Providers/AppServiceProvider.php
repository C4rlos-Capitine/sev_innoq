<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\provincia;
use Illuminate\Support\Facades\View;

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
        Schema::defaultStringLength(191);
        // Share provinces with all views when the table exists (avoids errors during migrations)
        try {
            if (Schema::hasTable('provincias')) {
                $provincias = provincia::orderBy('nome_provincia')->get();
            } else {
                $provincias = collect();
            }
        } catch (\Exception $e) {
            $provincias = collect();
        }

        View::share('provincias', $provincias);
    }
}
