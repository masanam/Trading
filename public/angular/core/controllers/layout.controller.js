'use strict';

angular.module('index').controller('LayoutController', ['$scope', '$state', 'Authentication',
  function($scope, $state, Authentication) {
    $scope.Authentication = Authentication;
    
    $scope.init = function(){
      $scope.style=[];
      for(var n=1;n<=3;n++){
        $scope.style[n]=false;
      }
    };
    
    $scope.openSidebar = function () {
      $scope.collapse = !$scope.collapse;
    };

    $scope.openCollapse = function($i){
      for(var n=1;n<=5;n++){
        if(n===$i){
          if ($scope.style[n]===false) {
            $scope.style[n]='block';
          }else{
            $scope.style[n]=false;
          }
        }else{
          $scope.style[n]=false;
        }
      }
    };
    
    $scope.logout = function () {
      Authentication.logout();
      $state.go('home', {});
    };
  }
]);