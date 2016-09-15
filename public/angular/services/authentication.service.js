'use strict';

// Authentication service for user variables
angular.module('user').factory('Authentication', ['$http', '$auth',
  function ($http, $auth) {
  	var auth = {};

  	auth.login = function(){
	  	if($auth.isAuthenticated()) 
        $http.get('/api/authenticate/user').success(function(res){
  	  		auth.user = res.user;
  	  	}).error(function(err){
          console.log(err);
        });
  	};

  	auth.login();

    return auth;
  }
]);