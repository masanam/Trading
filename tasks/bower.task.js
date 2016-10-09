/*Elixir Task for bower
* Upgraded from https://github.com/ansata-biz/laravel-elixir-bower
*/
var gulp = require('gulp');
var mainBowerFiles = require('main-bower-files');
var filter = require('gulp-filter');
var notify = require('gulp-notify');
var cssnano = require('gulp-cssnano');
var uglify = require('gulp-uglify');
var concat_sm = require('gulp-concat-sourcemap');
var concat = require('gulp-concat');
var gulpIf = require('gulp-if');
var gulpFilter = require('gulp-filter');
var less = require('gulp-less');
var merge = require('merge-stream');


var Elixir = require('laravel-elixir');

var Task = Elixir.Task;

Elixir.extend('bower', function(jsOutputFile, jsOutputFolder, ttfOutputFolder, cssOutputFile, cssOutputFolder) {

  var cssFile = cssOutputFile || 'vendor.css';
  var jsFile = jsOutputFile || 'vendor.js';
  
  var mainJSFiles = [ 
    // 'bower_components/jquery/dist/jquery.js',
    'bower_components/angular/angular.js',
    'bower_components/angular-ui-router/release/angular-ui-router.js',
    'bower_components/ngstorage/ngStorage.js',
    'bower_components/angular-animate/angular-animate.js',
    'bower_components/angular-aria/angular-aria.js',
    'bower_components/angular-messages/angular-messages.js',
    'bower_components/lodash/lodash.js',
    'bower_components/angular-loading-bar/build/loading-bar.js',
    'bower_components/angular-loading-bar/build/loading-bar.css',
    'bower_components/satellizer/satellizer.js',
    'bower_components/angular-resource/angular-resource.js',
    'bower_components/ngmap/build/scripts/ng-map.js',
    'bower_components/Chart.js/Chart.js',
    'bower_components/tv4/tv4.js',
    'bower_components/angular-sanitize/angular-sanitize.js',
    'bower_components/objectpath/lib/ObjectPath.js',
    'bower_components/bootstrap/dist/css/bootstrap-theme.css',
    'bower_components/bootstrap/dist/css/bootstrap.css',
    'bower_components/angular-bootstrap/ui-bootstrap-tpls.js',
    'bower_components/angular-bootstrap/ui-bootstrap-csp.css',
    'bower_components/restangular/dist/restangular.js',
    'bower_components/angular-chart.js/dist/angular-chart.js',
    'bower_components/angular-chart.js/dist/angular-chart.css',
    // 'bower_components/datatables.net/js/jquery.dataTables.js',
    'bower_components/pusher-angular/lib/pusher-angular.min.js',
    'bower_components/angular-smart-table/dist/smart-table.js',
    'bower_components/angular-smart-table/smartCss.css',
    // 'bower_components/angular-datatables/dist/angular-datatables.js',
    // 'bower_components/angular-datatables/dist/css/angular-datatables.css',
    // 'bower_components/angular-datatables/dist/plugins/bootstrap/angular-datatables.bootstrap.js',
    // 'bower_components/angular-datatables/dist/plugins/colreorder/angular-datatables.colreorder.js',
    // 'bower_components/angular-datatables/dist/plugins/columnfilter/angular-datatables.columnfilter.js',
    // 'bower_components/angular-datatables/dist/plugins/light-columnfilter/angular-datatables.light-columnfilter.js',
    // 'bower_components/angular-datatables/dist/plugins/colvis/angular-datatables.colvis.js',
    // 'bower_components/angular-datatables/dist/plugins/fixedcolumns/angular-datatables.fixedcolumns.js',
    // 'bower_components/angular-datatables/dist/plugins/fixedheader/angular-datatables.fixedheader.js',
    // 'bower_components/angular-datatables/dist/plugins/scroller/angular-datatables.scroller.js',
    // 'bower_components/angular-datatables/dist/plugins/tabletools/angular-datatables.tabletools.js',
    // 'bower_components/angular-datatables/dist/plugins/buttons/angular-datatables.buttons.js',
    // 'bower_components/angular-datatables/dist/plugins/select/angular-datatables.select.js',
    // 'bower_components/ng-sortable/dist/ng-sortable.css',
    // 'bower_components/ng-sortable/dist/ng-sortable.js',
    // 'bower_components/jquery-validation/dist/jquery.validate.min.js',
    // 'bower_components/jpkleemans-angular-validate/dist/angular-validate.min.js',
    // 'bower_components/admin-lte/dist/js/app.min.js',
    // 'bower_components/admin-lte/plugins/jQueryUI/jquery-ui.min.js',
    'bower_components/admin-lte/dist/css/AdminLTE.min.css',
    'bower_components/admin-lte/dist/css/skins/skin-blue.min.css',
    'bower_components/admin-lte/plugins/iCheck/square/blue.css',
    // 'bower_components/admin-lte/plugins/iCheck/icheck.min.js',
    // 'bower_components/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js'
  ];
  
  var mainCSSFiles = [];
  
  //mainJSFiles = mainBowerFiles();
  
  mainCSSFiles = mainBowerFiles();

  if (!Elixir.config.production){
    concat = concat_sm;
  }

  var onError = function (err) {
    notify.onError({
      title: "Laravel Elixir",
      subtitle: "Bower Files Compilation Failed!",
      message: "Error: <%= error.message %>",
      icon: __dirname + '/../node_modules/laravel-elixir/icons/fail.png'
    })(err);
    this.emit('end');
  };

  new Task('bower-js', function() {
    return gulp.src(mainJSFiles)
      .on('error', onError)
      .pipe(filter('**/*.js'))
      .pipe(concat(jsFile, {sourcesContent: true}))
      .pipe(gulpIf(Elixir.config.production, uglify()))
      // .pipe(gulp.dest(jsOutputFolder || Elixir.config.js.outputFolder))
      .pipe(gulp.dest('public/js'))
      .pipe(notify({
        title: 'Bower JS',
        subtitle: 'Javascript Bower Files Imported!',
        icon: __dirname + '/../node_modules/laravel-elixir/icons/laravel.png',
        message: ' '
      }));
  }).watch('bower.json');

  // new Task('bower-fonts', function() {
  //  return gulp.src('bower_components/bootstrap/fonts/glyphicons-halflings-regular.ttf')
  //    .on('error', onError)
  //    .pipe(filter('**/*.ttf'))
  //    .pipe(gulp.dest(ttfOutputFolder || Elixir.config.fonts.outputFolder))
  //    .pipe(notify({
  //      title: 'Laravel Elixir',
  //      subtitle: 'Font Bower Files Imported!',
  //      icon: __dirname + '/../node_modules/laravel-elixir/icons/laravel.png',
  //      message: ' '
  //    }));
  // }).watch('bower.json');

  new Task('bower-css', function(){
    return gulp.src(mainJSFiles)
      .on('error', onError)
      .pipe(filter('**/*.css'))
      .pipe(concat(cssFile))
      .pipe(gulpIf(Elixir.config.production, cssnano({safe: true})))
      //.pipe(gulp.dest(cssOutputFolder || Elixir.config.css.outputFolder))
      .pipe(gulp.dest('public/css'))
      .pipe(notify({
        title: 'Bower CSS',
        subtitle: 'CSS Bower Files Imported!',
        icon: __dirname + '/../node_modules/laravel-elixir/icons/laravel.png',
        message: ' '
      }));
  }).watch('bower.json');

});
