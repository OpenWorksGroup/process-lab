## VIF Process Lab
This project recommends the use of Laravel Homestead 5.2 for development, which includes the following software:
* Ubuntu 14.04
* Git			- version control system
* PHP 7.0
* HHVM			- virtual machine designed for executing programs written in Hack and PHP
* Nginx			- web server
* MySQL			- relational database management system
* MariaDB			- database server
* Sqlite3			- relational database management system contained in a C programming library. embedded in end programs, NOT CLIENT-SERVER
* Postgres		- object-relational database management system
* Composer		- Dependency Management for PHP
* Node (With PM2, Bower, Grunt, and Gulp)	-
 *	Bower		- package manager
 *	Grunt		- javascript task runner
 *	Gulp		- build system
* Redis			- in-memory data structure store
* Memcached		- distributed memory caching system
* Beanstalkd		- fast work queue

### Installation Instructions
1. Install Laravel Homestead 5.2 by following the [official instructions](https://laravel.com/docs/5.2/homestead).  
   * You will need to install [Vagrant](https://www.vagrantup.com/downloads.html) and a hypervisor, either [VirtualBox](https://www.virtualbox.org/wiki/Downloads) or [VMWare](http://www.vmware.com/), to run the virtual machine.

   * Setup up the homestead vagrant box: 
   ```
   $    vagrant box add laravel/homestead
   ```

   * In your home directory, install Homestead by running the following command
   (this will create a folder called Homestead and install it within): 
   ```
   $    git clone https://github.com/laravel/homestead.git Homestead
   ```  
   * Initialize Homestead by running: 
   ```
   $    bash init.sh
   ```  
   This will create the homestead.yaml file into ~/.homestead 

2. Cloning the process labs repository 
   * In your home directory, create a folder to house your homestead projects.
   * Clone the process labs into its own folder within this 'projects' folder.

3. Set up the homestead.yaml file.  
   * Ensure that `keys` and `authorize` in the .yaml file point to the correct locations.  
   If you don't have a ssh key setup, set one up by running the following command: 
   ```
   $    ssh-keygen -t rsa -C "youremail@here.com"
   ```
   * Set up your homestead projects folder to sync with the virtual machine by adding it under `folders`:
   ```
   folders:
       - map: ~/sites
         to: /home/vagrant/sites
   ```
   * Add the process labs as one of your `sites`:
   ```
   sites:
       - ...
         ...
       - map: dml.app
         to: /home/vagrant/<homestead-projects>/<process-labs>/public
   ```
4. Set up the process labs repository.  
   * Clone the repo into your projects folder.
   * SSH into vagrant.
   
   * Install the composer dependencies:
   ```
   $    composer install
   ```

   * Install the npm dependencies:
   ```
   $    npm install
   ```
   If this results in errors and you are on a Windows machine you may have to run `npm install --no-bin-links`. 
   This command may result in error `npm ERR! Maximum call stack size exceeded`.
   If this happens, run `npm install --no-bin-links` again and it should finish installing the dependencies.

   * Install bower packages:
   ```
   $    bower install bootstrap-sass-official --save
   $    bower install jquery --save
   ```

   * Generate MySQL DB tables and roles:
   ```
   $    php artisan migrate         # generates MySQL DB tables
   $    php artisan bouncer:seed    # adds roles to DB. For roles see: App\Providers\BouncerServiceProvider.php
   ```

   * Run Gulp to compile sass into a css file and to build/ compile ReactJS:
   ```
   $    gulp
   ```
   If this results in an error related to one of the npm dependencies,
   try reinstalling it by running `npm install <package-name>` and then try again.  
   (For error `Error: ENOENT: no such file or directory, scandir '/home/vagrant/sites/DMLmh/node_modules/node-sass/vendor'`
   run `npm install node-sass`)

.yaml file ~/.homestead

start vm: 
homestead up
homestead ssh

php artisan migrate - generates MySQL DB tables
php artisan bouncer:seed - adds roles to DB. For roles see: App\Providers\BouncerServiceProvider.php

start server: 
serve processlab.dev /home/vagrant/Projects/processlab/public

localhost: http://processlab.dev:8000