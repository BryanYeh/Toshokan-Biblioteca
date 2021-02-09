<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        Str::macro('randomAlpha', function (int $length) {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

            $input_length = strlen($permitted_chars);
            $random_string = '';
            for($i = 0; $i < $length; $i++) {
                $random_string .= $permitted_chars[random_int(0, $input_length - 1)];
            }
            return $random_string;
        });
    }
}
