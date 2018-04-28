<?php
namespace Overxue\Slug;

use Illuminate\Support\ServiceProvider;

class SlugServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->singleton('slug', function () {
            return new Slug(config('services.baidu'));
        });
    }
}