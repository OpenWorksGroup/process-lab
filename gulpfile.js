var elixir = require('laravel-elixir'),
    path    = require('path'),
    gulp    = require('gulp'),
    webpack = require('webpack'),
    shell   = require('gulp-shell');
    require('laravel-elixir-webpack');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
    
var PATHS = {
  app: path.join(__dirname, 'resources/assets/js'),
  build: path.join(__dirname, 'build')
};

elixir.config.js.browserify.watchify = {
    enabled: true,
    options: {
        poll: true
    }
}

elixir(function(mix) {
  mix.phpUnit()
  .sass('app.scss')
  .browserSync({
    proxy: 'processlab.dev'
  })
  .scripts([
    '../bower/jquery/dist/jquery.js',
    '../bower/bootstrap-sass/assets/javascripts/bootstrap.min.js'
  ], 'public/js/vendor.js')
  .webpack('index.jsx', {
    outputDir: 'public/js',
    entry: PATHS.app + '/index.jsx',
    output: {
      filename: 'components.js'
    },
    module: {
      loaders: [
        {
          test: /\.jsx?$/,
          loaders: ['babel?cacheDirectory,presets[]=react,presets[]=es2015'],
          include: PATHS.app
        }
      ]
    },
    plugins: [
      new webpack.ProvidePlugin({
        'fetch': 'imports?this=>global!exports?global.fetch!whatwg-fetch'
      })
    ]
  });
});
