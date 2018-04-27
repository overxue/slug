<?php
namespace Overxue\Slug;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class SlugServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->singleton('slug', function () {
            return new Slug(new Client(), config('services.baidu'));
        });
    }
}