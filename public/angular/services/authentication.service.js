'use strict';

// Authentication service for user variables
angular.module('user').factory('Authentication', ['$http', '$auth',
  function ($http, $auth) {
  	var auth = {};

    auth.authenticate = function (callback){
      if($auth.isAuthenticated() && !auth.user) {
        $http.get('/api/authenticate/user').success(function(res){
          Authentication.user = res.user;

          return callback(auth.user);
        }).error(function(err){
          console.log(err);

          return callback();
        });
      } else callback();
    }

    return auth;
  }
]);