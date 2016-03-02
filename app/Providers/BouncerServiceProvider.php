<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Bouncer;

class BouncerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Generates Roles and Abilities for Users
         * See: https://packagist.org/packages/silber/bouncer
         * Run as: php artisan bouncer:seed
         * Can update roles and abilities and seed as much as you'd like.
         * Note that any information that has previously been seeded will not be automatically reverted.
         */ 
        
        Bouncer::seeder(function () {
            Bouncer::allow('admin')->to(
                ['manage-users', 
                'manage-tags',
                'manage-categories',
                'manage-templates',
                'view-reports'
                ]
            );
            Bouncer::allow('author')->to(
                ['write-content', 
                'collaborative-review'
                ]
            );
            Bouncer::allow('online facilitator')->to(
                ['collaborative-review',
                'facilitate-collaborative-review'
                ]
            );
            Bouncer::allow('peer reviewer')->to(
                ['peer-review']
            );           
            Bouncer::allow('expert reviewer')->to(
                ['expert-review']
            );
        });
    }
}
