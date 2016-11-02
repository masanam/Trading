'use strict';

angular.module('factory').controller('UpdateFactoryController', ['$scope', '$stateParams', '$location', 'Factory', 'Port', '$window', '$state',
  function($scope, $stateParams, $location, Factory, Port, $window, $state) {

    $scope.init = function () {
      $scope.factory = Factory.get({ id : $stateParams.id }, function(response){
        $scope.factory = response;
        $scope.factory.latitude = parseFloat($scope.factory.latitude);
        $scope.factory.longitude = parseFloat($scope.factory.longitude);
        $scope.factory.port_distance = parseFloat($scope.factory.port_distance);
      });

      $scope.ports = Port.query();
    };
    
    $scope.update = function() {
      $scope.factory = new Factory($scope.factory);
      $scope.factory.$update({ id: $scope.factory.id }, function(response) {
        //$scope.factory = Factory.get({ id: $scope.factoryId });
        $scope.error = 'Success updating factory data!';
      }, function(err){
        $scope.error = err;
      });
    };
    
    $scope.goBackToDetail = function(){
      $state.go('factory.view', { id: $scope.factory.id });
    };
  }
]);
