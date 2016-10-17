module.exports = {
  vendorJSFiles: [ 
    'bower_components/angular/angular.js',
    'bower_components/angular-ui-router/release/angular-ui-router.js',
    'bower_components/ngstorage/ngStorage.js',
    'bower_components/angular-animate/angular-animate.js',
    'bower_components/angular-aria/angular-aria.js',
    'bower_components/angular-messages/angular-messages.js',
    'bower_components/lodash/lodash.js',
    'bower_components/satellizer/satellizer.js',
    'bower_components/angular-resource/angular-resource.js',
    'bower_components/ngmap/build/scripts/ng-map.js',
    'bower_components/chart.js/dist/Chart.js',
    'bower_components/tv4/tv4.js',
    'bower_components/angular-sanitize/angular-sanitize.js',
    'bower_components/objectpath/lib/ObjectPath.js',
    'bower_components/angular-bootstrap/ui-bootstrap-tpls.js',
    'bower_components/restangular/dist/restangular.js',
    'bower_components/angular-chart.js/dist/angular-chart.js',
    'bower_components/pusher-angular/lib/pusher-angular.min.js',
    'bower_components/angular-smart-table/dist/smart-table.js',
    'bower_components/ng-validate/src/ng-validate.js',
    'bower_components/angular-smart-table/dist/smart-table.min.js',
    'bower_components/angular-pusher/angular-pusher.min.js',
    'bower_components/ng-file-upload/ng-file-upload-all.js',
    'bower_components/firebase/firebase.js',
    'bower_components/angularfire/dist/angularfire.js'
  ],
  vendorCSSFiles: [
    'bower_components/bootstrap/dist/css/bootstrap-theme.css',
    'bower_components/bootstrap/dist/css/bootstrap.css',
    'bower_components/angular-bootstrap/ui-bootstrap-csp.css',
    'bower_components/angular-chart.js/dist/angular-chart.css',
    'bower_components/angular-smart-table/dist/smart-table.css',
    'bower_components/angular-smart-table/smartCss.css',
    'bower_components/admin-lte/dist/css/AdminLTE.min.css',
    'bower_components/admin-lte/dist/css/skins/skin-blue.min.css',
    'bower_components/admin-lte/plugins/iCheck/square/blue.css',
    'bower_components/angular-smart-table/dist/smart-table.css',
  ],
  vendorFontFiles: [
    'bower_components/bootstrap/fonts/glyphicons-halflings-regular.ttf',
    'bower_components/bootstrap/fonts/glyphicons-halflings-regular.woff',
    'bower_components/bootstrap/fonts/glyphicons-halflings-regular.woff2'
  ],
  appJSFiles: [
    'public/angular/core/config/app.js',
    'public/angular/core/config/init.js',
    'public/angular/*/**/*.*.js'
  ],
  appSCSSFiles: [
    'public/angular/*.scss',
    'public/angular/**/*.scss'
  ],
  serveOptions: {
    base: 'public',
    port: 8000,
    watch: true
  },
  onError: function (err) {
    notify.onError({
      title: "Laravel Elixir",
      subtitle: "Bower Files Compilation Failed!",
      message: "Error: <%= error.message %>",
      icon: __dirname + '/../node_modules/laravel-elixir/icons/fail.png'
    })(err);
    this.emit('end');
  }
};