/*Elixir Task
 *copyrights to https://github.com/HRcc/laravel-elixir-angular
 */
var gulp = require('gulp');
var concat = require('gulp-concat');
var sourcemaps = require('gulp-sourcemaps');
var concat_sm = require('gulp-concat-sourcemap');
var eslint = require('gulp-eslint');
var uglify = require('gulp-uglify');
var sass = require('gulp-sass');
var ngAnnotate = require('gulp-ng-annotate');
var notify = require('gulp-notify');
var gulpif = require('gulp-if');

var webpack = require('webpack-stream');
var webpackConfig = require('../webpack.config.js')

var Elixir = require('laravel-elixir');

var Task = Elixir.Task;

// Add elixir word behind evey config

Elixir.extend('angular', function(src, output, outputFilename) {

  if (!Elixir.config.production){
    concat = concat_sm;
  }

  var onError = function (err) {
    notify.onError({
      title: "Laravel Elixir",
      subtitle: "Angular Files Compilation Failed!",
      message: "Error: <%= error.message %>",
      icon: __dirname + '/../node_modules/laravel-elixir/icons/fail.png'
    })(err);
    this.emit('end');
  };

  var baseDir = src || Elixir.config.assetsPath + '/angular/';

  new Task('app-js', function() {
    // Admin file has to be included first.
    return gulp.src([
        baseDir + 'core/config/app.config.js',
        baseDir + 'core/config/init.config.js',
        baseDir + '*/**/*.js'
      ])
      .pipe(eslint())
      .pipe(eslint.format())
      .pipe(ngAnnotate())
      .pipe(gulpif(Elixir.config.production, uglify()))
      .pipe(concat('app.js'))
      .pipe(gulp.dest('public/js'))
      .pipe(notify({
        title: 'Angular JS',
        subtitle: 'Angular Compiled!',
        icon: __dirname + '/../node_modules/laravel-elixir/icons/laravel.png',
        message: ' '
      }));
  }).watch(baseDir + '/**/*.js');


  new Task('app-sass', function(){
    return gulp.src([baseDir + '*.scss', baseDir + '**/*.scss'])
      .on('error', onError)
      .pipe(sass({sourcemap: true, style: 'compact'}))
      .pipe(concat('app.css'))
      .pipe(gulp.dest('public/css'))
      .pipe(notify({
        title: 'SASS',
        subtitle: 'SCSS Files Imported!',
        icon: __dirname + '/../node_modules/laravel-elixir/icons/laravel.png',
        message: ' '
      }));
  }).watch([baseDir + '*.scss', baseDir + '**/*.scss']);

});
