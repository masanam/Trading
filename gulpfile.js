var elixir = require('laravel-elixir');
var gulp = require('gulp');

require('./tasks/serve.task.js');
require('./tasks/angular.task.js');
require('./tasks/bower.task.js');

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

elixir(function(mix) {
  var assets = [
    'public/js/vendor.js',
    'public/js/app.js',
    'public/css/vendor.css',
    'public/css/app.css'
  ];

  mix
    .bower()
    .angular('./public/angular/')
    .version(assets)
    .serve();
});

