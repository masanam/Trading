'use strict';

// Init the application configuration module for AngularJS application
var ApplicationConfiguration = (function () {
  // Init module configuration options
  var applicationModuleName = 'coaltrade';
  var applicationModuleVendorDependencies = [
    'ngResource', 'ui.router', 'satellizer', 'ngMap', 'chart.js', 'ui.bootstrap', 'datatables', 'as.sortable'
  ];

  // Add a new vertical module
  var registerModule = function (moduleName, dependencies) {
    // Create angular module
    angular.module(moduleName, dependencies || []);

    // Add the module to the AngularJS configuration file
    angular.module(applicationModuleName).requires.push(moduleName);
  };

  return {
    applicationModuleName: applicationModuleName,
    applicationModuleVendorDependencies: applicationModuleVendorDependencies,
    registerModule: registerModule
  };
})();

//Start by defining the main module and adding the module dependencies
angular.module(ApplicationConfiguration.applicationModuleName, ApplicationConfiguration.applicationModuleVendorDependencies);

// Setting HTML5 Location Mode
angular.module(ApplicationConfiguration.applicationModuleName).config(['$locationProvider', '$httpProvider',
  function ($locationProvider, $httpProvider) {
    $locationProvider.html5Mode(true).hashPrefix('!');

    //$httpProvider.interceptors.push('authInterceptor');
  }
]);

angular.module(ApplicationConfiguration.applicationModuleName).config(['$urlRouterProvider', '$authProvider',
  function($urlRouterProvider, $authProvider) {
    // Satellizer configuration that specifies which API
    // route the JWT should be retrieved from
    $authProvider.loginUrl = '/api/authenticate';
    $authProvider.signupUrl = '/api/authenticate/signup';

    // Redirect to the auth state if any other states
    // are requested other than users 
    $urlRouterProvider.otherwise('/auth/signin');
  }
]);

angular.module(ApplicationConfiguration.applicationModuleName).run(function ($rootScope, $state, $uibModalStack) {

  // Check authentication before changing state
  // $rootScope.$on('$stateChangeStart', function (event, toState, toParams, fromState, fromParams) {
  //   if (toState.data && toState.data.roles && toState.data.roles.length > 0) {
  //     var allowed = false;
  //     toState.data.roles.forEach(function (role) {
  //       if (Authentication.user.roles !== undefined && Authentication.user.roles.indexOf(role) !== -1) {
  //         allowed = true;
  //         return true;
  //       }
  //     });

  //     if (!allowed) {
  //       event.preventDefault();
  //       if (Authentication.user !== undefined && typeof Authentication.user === 'object') {
  //         $state.go('forbidden');
  //       } else {
  //         $state.go('home').then(function () {
  //           storePreviousState(toState, toParams);
  //         });
  //       }
  //     }
  //   }
  // });
  
  // $rootScope.dialogFullScreen = $mdMedia('sm') || $mdMedia('xs');

  // Record previous state
  $rootScope.$on('$stateChangeSuccess', function (event, toState, toParams, fromState, fromParams) {
    storePreviousState(fromState, fromParams);
    $uibModalStack.dismissAll();
  });

  // Store previous state
  function storePreviousState(state, params) {
    // only store this state if it shouldn't be ignored 
    if (!state.data || !state.data.ignoreState) {
      $state.previous = {
        state: state,
        params: params,
        href: $state.href(state, params)
      };
    }
  }
});

//Then define the init function for starting up the application
// angular.element(document).ready(function () {
//   //Fixing facebook bug with redirect
//   if (window.location.hash && window.location.hash === '#_=_') {
//     if (window.history && history.pushState) {
//       window.history.pushState('', document.title, window.location.pathname);
//     } else {
//       // Prevent scrolling by storing the page's current scroll offset
//       var scroll = {
//         top: document.body.scrollTop,
//         left: document.body.scrollLeft
//       };
//       window.location.hash = '';
//       // Restore the scroll offset, should be flicker free
//       document.body.scrollTop = scroll.top;
//       document.body.scrollLeft = scroll.left;
//     }
//   }

//   //Then init the app
//   angular.bootstrap(document, [ApplicationConfiguration.applicationModuleName]);
// });
