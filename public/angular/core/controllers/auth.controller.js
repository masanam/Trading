'use strict';

angular.module('auth').controller('AuthController', ['$scope', '$state', '$urlRouter', 'Authentication',
  function AuthController($scope, $state, $urlRouter, Authentication) {
    // route the JWT should be retrieved from
    $scope.Authentication = Authentication;

    $scope.login = function() {
      var credentials = {
        email: $scope.auth.email,
        password: $scope.auth.password
      };

      Authentication.login(credentials, function(err, res){
        if(err) $scope.err = err;
        else $state.go('lead.index', {});
      });
    };

    $scope.signup = function () {
      if($scope.registration.password === $scope.registration.confirmPassword){
        var registration = {
          name: $scope.registration.name,
          email: $scope.registration.email,
          phone: $scope.registration.phone,
          password: $scope.registration.password
        };
        var credentials = {
          email: registration.email,
          password: registration.password
        };
        
        // Use Satellizer's $auth service to login
        Authentication.signup(registration, function(){
          $state.go('home', {});
        });
      } else {
        alert('Confirm Password did not match!');
      }
    };

    $scope.logout = function () {
      Authentication.logout();
      $state.go('home', {});
    };
  }
]);