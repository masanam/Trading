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
        else $state.go('dashboard.main', {});
      }, function(response){
        console.log(response);
        $scope.err = response;
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
        Authentication.signup(registration, function(res){
          // if(err) $scope.err = err.message.data.message;
          // else $state.go('home', {});
          Authentication.login(credentials, function(res){
            $state.go('home', {});
          }, function(err) {
            $scope.err = err.message;
          });
        }, function(err) {
          $scope.err = err.message;
        });
      } else {
        $scope.err = 'Password(s) does not match!';
      }
    };

    $scope.forgot = function() {
      $scope.err = '';
      $scope.success = '';
    
      $scope.loading = true;
      var email= $scope.forgot.email;

      Authentication.forgot(email, function(res) {
        $scope.loading = false;
        if(res.message !== 'Not Found') $scope.success = res.message + ' to ' + email;
        else $scope.success = res.message;
        // $state.go('home', {});
      });
    };
  }
]);