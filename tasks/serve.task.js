'use strict';

var gulp = require('gulp'),
  Elixir = require('laravel-elixir'),
  Task = Elixir.Task,
  connectPhp = require('gulp-connect-php'),
  notify = require('gulp-notify'),
  config = require('./config');

gulp.task('serve', function () {
  notify({
    title: 'Laravel',
    subtitle: 'Server Started!',
    icon: __dirname + '/../node_modules/laravel-elixir/icons/laravel.png',
    message: ' '
  });

  return connectPhp.server(config.serveOptions);
});