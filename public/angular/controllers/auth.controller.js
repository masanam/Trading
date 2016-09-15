'use strict';

angular.module('auth').controller('AuthController', ['$scope', '$auth', '$state', '$urlRouter', 'Authentication',
  function AuthController($scope, $auth, $state, $urlRouter, Authentication) {
    // Satellizer configuration that specifies which API
    // route the JWT should be retrieved from
    $auth.loginUrl = '/api/authenticate';  
    $scope.Authentication = Authentication;

    $scope.login = function() {
      var credentials = {
        email: $scope.auth.email,
        password: $scope.auth.password
      }
      
      // Use Satellizer's $auth service to login
      $auth.login(credentials).then(function(data) {
        // If login is successful, redirect to the users state
        Authentication.login();
        $state.go('home', {});
      });
    };

    $scope.signup = function () {
      if($scope.registration.password === $scope.registration.confirmPassword){
        var registration = {
          name: $scope.registration.name,
          email: $scope.registration.email,
          phone: $scope.registration.phone,
          password: $scope.registration.password
        }
        var credentials = {
          email: registration.email,
          password: registration.password
        }
        
        // Use Satellizer's $auth service to login
        $auth.signup(registration).then(function(data) {
          $auth.login(credentials).then(function(data) {
            // If login is successful, redirect to the users state
            Authentication.login();
            $state.go('home', {});
          });
        });
      } else {
        alert('Confirm Password did not match!');
      }
    };

    $scope.logout = function () {
      Authentication.user = undefined;
      $auth.logout();
    };
}]);