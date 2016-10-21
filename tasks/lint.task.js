var gulp = require('gulp'),
  config = require('./config'),
  gulpLoadPlugins = require('gulp-load-plugins'),
  runSequence = require('run-sequence'),
  plugins = gulpLoadPlugins({
    rename: {
      'gulp-angular-templatecache': 'templateCache'
    }
  });

// ESLint JS linting task
gulp.task('eslint', function () {
  return gulp.src(config.appJSFiles)
    .pipe(plugins.eslint())
    .pipe(plugins.eslint.format());
});

// JS linting task
gulp.task('jshint', function () {
  return gulp.src(config.appJSFiles)
    .pipe(plugins.jshint())
    .pipe(plugins.jshint.reporter('default'))
    .pipe(plugins.jshint.reporter('fail'));
});


// Lint CSS and JavaScript files.
gulp.task('lint', function (done) {
  runSequence(['eslint', 'jshint'], done);
});