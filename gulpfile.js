'use strict';

var gulp = require('gulp'),
  runSequence = require('run-sequence'),
  config = require('./tasks/config');

require('./tasks/serve.task.js');
require('./tasks/lint.task.js');
require('./tasks/angular.task.js');
require('./tasks/bower.task.js');

// Watch Files For Changes
gulp.task('watch', function () {
  gulp.watch(config.vendorJSFiles, ['bower-js']);
  gulp.watch(config.vendorCSSFiles, ['bower-css']);
  gulp.watch(config.vendorFontFiles, ['bower-fonts']);
  gulp.watch(config.appJSFiles, ['jshint', 'app-js']);
  gulp.watch(config.appSCSSFiles, ['csslint', 'app-sass']);
});


// Run the project in development mode
gulp.task('default', function (done) {
  runSequence('lint', ['bower', 'angular'], ['serve', 'watch'], done);
});