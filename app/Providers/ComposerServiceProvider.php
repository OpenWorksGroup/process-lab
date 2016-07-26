<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      view()->composer('partials.artifactLinksNav','App\Http\ViewComposers\ArtifactLinksNavComposer');
      view()->composer('partials.artifactButtonsNav','App\Http\ViewComposers\ArtifactButtonsNavComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
