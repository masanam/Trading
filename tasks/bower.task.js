var gulp = require('gulp'),
  filter = require('gulp-filter'),
  notify = require('gulp-notify'),
  cssnano = require('gulp-cssnano'),
  uglify = require('gulp-uglify'),
  concat_sm = require('gulp-concat-sourcemap'),
  concat = require('gulp-concat'),
  gulpIf = require('gulp-if'),
  gulpFilter = require('gulp-filter'),
  less = require('gulp-less'),
  merge = require('merge-stream'),
  runSequence = require('run-sequence'),
  Elixir = require('laravel-elixir'),
  Task = Elixir.Task,
  config = require('./config');

var cssFile = 'vendor.css',
  jsFile = 'vendor.js';

if (!Elixir.config.production){
  concat = concat_sm;
}

// JS bower tasks
gulp.task('bower-js', function () {
  return gulp.src(config.vendorJSFiles)
    .on('error', config.onError)
    .pipe(concat(jsFile, {sourcesContent: true}))
    .pipe(gulpIf(Elixir.config.production, uglify()))
    .pipe(gulp.dest('public/js'))
    .pipe(notify({
      title: 'Bower JS',
      subtitle: 'Javascript Bower Files Imported!',
      icon: __dirname + '/../node_modules/laravel-elixir/icons/laravel.png',
      message: ' '
    }));
});

// CSS bower tasks
gulp.task('bower-css', function () {
  return gulp.src(config.vendorCSSFiles)
    .on('error', config.onError)
    .pipe(concat(cssFile))
    .pipe(gulpIf(Elixir.config.production, cssnano({safe: true})))
    .pipe(gulp.dest('public/css'))
    .pipe(notify({
      title: 'Bower CSS',
      subtitle: 'CSS Bower Files Imported!',
      icon: __dirname + '/../node_modules/laravel-elixir/icons/laravel.png',
      message: ' '
    }));
});

// JS bower tasks
gulp.task('bower-fonts', function () {
  return gulp.src(config.vendorFontFiles)
   .on('error', config.onError)
   .pipe(gulp.dest('public/fonts'))
   .pipe(notify({
     title: 'Laravel Elixir',
     subtitle: 'Font Bower Files Imported!',
     icon: __dirname + '/../node_modules/laravel-elixir/icons/laravel.png',
     message: ' '
   }));
});

// Lint CSS and JavaScript files.
gulp.task('bower', function (done) {
  runSequence(['bower-js', 'bower-css', 'bower-fonts'], done);
});