<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Peminjaman;
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


public function boot()
{
    View::composer('*', function ($view) {
        $peminjamanTerbaru = Peminjaman::with(['user', 'barang'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $view->with('peminjamanTerbaru', $peminjamanTerbaru);
    });
}

}
