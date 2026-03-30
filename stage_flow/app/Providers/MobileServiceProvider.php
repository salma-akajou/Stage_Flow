<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class MobileServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $userAgent = request()->header('User-Agent');
        $isNative = str_contains($userAgent, 'NativePHP');

        View::share('isNative', $isNative);
    }
}
