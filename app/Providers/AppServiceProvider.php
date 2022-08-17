<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // agar paginator pake punyanya bootstrap
        Paginator::useBootstrapFive();

        // Gate biar bisa beda user sama admin fiturnya
        Gate::define('admin', function(User $user) { // mendefinisikan aturan seorang admin
            return $user->is_admin; // cuman bisa diakses sama kolom is_admin yang true di table user
        });
    }
}
