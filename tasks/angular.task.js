/*Elixir Task
 *copyrights to https://github.com/HRcc/laravel-elixir-angular
 */
var gulp = require('gulp'),
  concat = require('gulp-concat'),
  sourcemaps = require('gulp-sourcemaps'),
  concat_sm = require('gulp-concat-sourcemap'),
  eslint = require('gulp-eslint'),
  uglify = require('gulp-uglify'),
  sass = require('gulp-sass'),
  ngAnnotate = require('gulp-ng-annotate'),
  notify = require('gulp-notify'),
  gulpif = require('gulp-if'),
  runSequence = require('run-sequence'),
  Elixir = require('laravel-elixir'),
  Task = Elixir.Task,
  config = require('./config');


if (!Elixir.config.production){
  concat = concat_sm;
}

gulp.task('app-js', function () {
  return gulp.src(config.appJSFiles)
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
});

gulp.task('app-sass', function () {
  return gulp.src(config.appSCSSFiles)
    .on('error', config.onError)
    .pipe(sass({sourcemap: true, style: 'compact'}))
    .pipe(concat('app.css'))
    .pipe(gulp.dest('public/css'))
    .pipe(notify({
      title: 'SASS',
      subtitle: 'SCSS Files Imported!',
      icon: __dirname + '/../node_modules/laravel-elixir/icons/laravel.png',
      message: ' '
    }));
});

// Lint CSS and JavaScript files.
gulp.task('angular', function (done) {
  runSequence(['app-js', 'app-sass'], done);
});