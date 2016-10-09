'use strict';

// Init the application configuration module for AngularJS application
var ApplicationConfiguration = (function () {
  // Init module configuration options
  var applicationModuleName = 'coaltrade';
  var applicationModuleVendorDependencies = [
    'ngResource', 'ui.router', 'satellizer', 'ngMap', 'chart.js', 'ui.bootstrap', 'smart-table', 'pusher-angular', 
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
    // $urlRouterProvider.otherwise('/auth/signin');
  }
]);

angular.module(ApplicationConfiguration.applicationModuleName).config(['PusherServiceProvider',
  function(PusherServiceProvider) {
    PusherServiceProvider
    .setToken('6d2905ad0e57d83c218e')
    .setOptions({
      host: 'api-ap1.pusher.com',
      cluster: 'ap1'
    });
  }
]);


//initialize application authentication & authorization before starting
angular.module(ApplicationConfiguration.applicationModuleName).run(function ($rootScope, $state, $http, $uibModalStack, Authentication) {
  //Load authorization event listener once all authentication done 
  Authentication.authenticate(function(user){
    // Always check authentication before changing state
    $rootScope.$on('$stateChangeStart', function (event, toState, toParams, fromState, fromParams) {
      if (toState.roles && toState.roles.length > 0) {
        var allowed = false;

        toState.roles.forEach(function (role) {
          if (role === 'guest' || (Authentication.user !== undefined && Authentication.user.role === role)){
            allowed = true;
            return true;
          }
        });

        if (!allowed) {
          event.preventDefault();
          if (Authentication.user !== undefined && typeof Authentication.user === 'object') {
            $state.go('forbidden');
          } else {
            $state.go('auth.signin').then(function () {
              storePreviousState(toState, toParams);
            });
          }
        }
      }
    });

    // Always record previous state
    $rootScope.$on('$stateChangeSuccess', function (event, toState, toParams, fromState, fromParams) {
      storePreviousState(fromState, fromParams);
      $uibModalStack.dismissAll();
    });
  });

  // Store previous state
  function storePreviousState(state, params) {
    // only store this state if it shouldn't be ignored 
    if (!state || !state.ignoreState) {
      $state.previous = {
        state: state,
        params: params,
        href: $state.href(state, params)
      };
    }
  }
});