<?php

namespace App\Providers;

use App\Contracts\VinDecoderInterface;
use App\NHTSAVinDecoder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(VinDecoderInterface::class, NHTSAVinDecoder::class);
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
