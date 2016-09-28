## Process Lab

Planned and developed with leadership from [VIF International Education](https://www.vifprogram.com/), in partnership with [Little Bird Games](http://littlebirdgames.com/) and the Digital Media and Learning Competition, supported by the John D. and Catherine T. MacArthur Foundation through a grant to the University of California, Irvine and administered by HASTAC.

This project recommends the use of Laravel Homestead 5.2 for development.

### Installation Instructions
1. Install Laravel Homestead 5.2, official instructions can be found [here](https://laravel.com/docs/5.2/homestead).  
   * Although not required, it is recommended that you install [Vagrant](https://www.vagrantup.com/downloads.html) and a hypervisor, either [VirtualBox](https://www.virtualbox.org/wiki/Downloads) or [VMWare](http://www.vmware.com/), to run the virtual machine.

   * Setup up the homestead vagrant box: 
   ```
   $    vagrant box add laravel/homestead
   ```

   * In your home directory, install Homestead by running the following command
   (this will create a folder called Homestead and install it within): 
   ```
   $    git clone https://github.com/laravel/homestead.git Homestead
   ```  
   * To initialize Homestead, navigate to the Homestead folder and run: 
   ```
   $    bash init.sh
   ```  
   This will create the homestead.yaml file into ~/.homestead 

2. Clone the process labs repository 
   * In your home directory, create a folder to house your homestead projects.
   * Clone the process labs into its own folder within this 'projects' folder.

3. Set up the homestead.yaml file.  
   * Ensure that `keys` and `authorize` in the .yaml file point to the correct locations.  
   If you don't have a ssh key setup, set one up by running the following command: 
   ```
   $    ssh-keygen -t rsa -C "youremail@here.com"
   ```
   This will create a `.ssh` folder in your home directory.
   * Set up your homestead projects folder to sync with the virtual machine by adding it under `folders`:
   ```
   folders:
       - map: ~/projects
         to: /home/vagrant/projects
   ```
   * Add the process labs as one of your `sites`:
   ```
   sites:
       - ...
         ...
       - map: processlabs.app
         to: /home/vagrant/projects/process_labs/public
   ```
   * To map this site to your localhost, append the following line to your systems hosts file:
   ```
   127.0.0.1	processlabs.app
   ```
   This will allow us to view the process labs locally by going to this domain.
4. Set up the process labs repository.  
   * We will need to start running our commands in the virtual machine. To do this we must start up the vagrant box and then ssh into it
   , which is done by running the following from our Homestead directory:
   ```
   $    vagrant up
   $    vagrant ssh
   ```
   * Navigate to your process labs directory within the virtual machine.
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

   * Install bower dependencies:
   ```
   $    bower install
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

   $    gulp watch is also available

5. You're done, open `http://processlabs.app:8000` in your browser to view your local process labs site!

