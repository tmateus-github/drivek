<?php

namespace App\Providers;

use App\Utilities\PayloadRequest\PayloadRequest;
use App\Utilities\PayloadRequest\PayloadRequestInterface;
use Illuminate\Support\ServiceProvider;

class UtilitiesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PayloadRequestInterface::class, PayloadRequest::class);
    }
}
