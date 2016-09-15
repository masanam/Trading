'use strict';

var gulp = require('gulp');
var Elixir = require('laravel-elixir');
var Task = Elixir.Task;
var connectPhp = require('gulp-connect-php');
var notify = require('gulp-notify');

Elixir.extend('serve', function (options) {

  options = {
    base: 'public',
    port: 8000,
    watch: true
  };

  new Task('serve', function() {
  	notify({
      title: 'Laravel',
      subtitle: 'Server Started!',
      icon: __dirname + '/../node_modules/laravel-elixir/icons/laravel.png',
      message: ' '
    });

    return connectPhp.server(options);
  });
});