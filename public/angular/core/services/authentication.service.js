'use strict';

// Authentication service for user variables
angular.module('user').factory('Authentication', ['$http', '$auth',
  function ($http, $auth) {
    var auth = {};

    $auth.loginUrl = '/api/authenticate';

    auth.authenticate = function (callback){
      if($auth.isAuthenticated() && !auth.user) {
        $http.get('/api/authenticate/user').success(function(res){
          console.log(res);
          auth.user = res.user;
          auth.subordinates = res.subordinates;
          auth.managers = res.managers;

          return callback(undefined, auth.user);
        }).error(function(err){
          if(callback) return callback(err, undefined);
        });
      } else callback({ message: 'No user logged in!' }, undefined);
    };

    auth.login = function (credentials, callback){
      // Use Satellizer's $auth service to login
      $auth.login(credentials).then(function(data) {
        // If login is successful, redirect to the users state
        auth.authenticate(callback);
      }).catch(function(err){
        return callback({ message: 'Wrong username/password combination!' }, undefined);
      });
    };

    auth.signup = function (registration, callback){
      $auth.signup(registration).then(function(data) {
        // If signup is successful, redirect to the users state
        auth.authenticate();
        callback();
      }).catch(function(err){
        return callback({ message: err }, undefined);
      });
    };

    auth.logout = function () {
      auth.user = undefined;
      $auth.logout();
    };

    return auth;
  }
]);