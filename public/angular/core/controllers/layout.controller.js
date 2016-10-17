'use strict';

angular.module('index').controller('LayoutController', ['$scope', '$state', 'Authentication',
  function($scope, $state, Authentication) {
    $scope.Authentication = Authentication;
    
    $scope.openSidebar = function () {
      $scope.collapse = !$scope.collapse;
    };
    
    $scope.logout = function () {
      Authentication.logout();
      $state.go('home', {});
    };
  }
]);