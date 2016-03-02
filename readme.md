## VIF Process Lab

 Installing Laravel Homestead (recommended):[https://laravel.com/docs/5.2/homestead](https://laravel.com/docs/5.2/homestead)
 
.yaml file ~/.homestead

start vm: 
homestead up
homestead ssh

php artisan migrate - generates MySQL DB tables
php artisan bouncer:seed - adds roles to DB. For roles see: App\Providers\BouncerServiceProvider.php

start server: 
serve processlab.dev /home/vagrant/Projects/processlab/public

localhost: http://processlab.dev:8000