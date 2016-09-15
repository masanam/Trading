'use strict';

// Authentication service for user variables
angular.module('user').factory('Authentication', ['$http', '$auth',
  function ($http, $auth) {
  	var auth = {};

    $auth.loginUrl = '/api/authenticate';

    auth.authenticate = function (callback){
      if($auth.isAuthenticated() && !auth.user) {
        $http.get('/api/authenticate/user').success(function(res){
          auth.user = res.user;

          return callback(auth.user);
        }).error(function(err){
          return callback();
        });
      } else callback();
    };

    auth.login = function (credentials, callback){
      // Use Satellizer's $auth service to login
      $auth.login(credentials).then(function(data) {
        // If login is successful, redirect to the users state
        auth.authenticate();
        callback();
      });
    };

    auth.signup = function (registration, callback){
      $auth.signup(registration).then(function(data) {
        // If signup is successful, redirect to the users state
        auth.authenticate();
        callback()
      });
    };

    auth.logout = function () {
      auth.user = undefined;
      $auth.logout();
    };

    return auth;
  }
]);