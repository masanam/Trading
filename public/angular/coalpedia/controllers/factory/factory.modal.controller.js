'use strict';

angular.module('coalpedia').controller('FactoryModalController', ['$scope', '$uibModalInstance', '$timeout', '$interval', 'Factory', 'factory', 'company',
  function($scope, $uibModalInstance, $timeout, $interval, Factory, factory, company) {
    $scope.factory = factory;
    $scope.selected = {};

    $scope.find = function (keyword) {
      Factory.query({ q: keyword }, function(res){
        if(res.length > 0) $scope.factories = res;
      });
    };

    $scope.changePosition = function(e) {
      $scope.factory.latitude = e.latLng.lat();
      $scope.factory.longitude = e.latLng.lng();
    };

    $scope.create = function() {
      var factory = new Factory($scope.factory);
      factory.company_id = company.id;

      factory.$save(function(response) {
        $uibModalInstance.close(response);
      });
    };

    $scope.update = function() {
      $scope.factory = new Factory($scope.factory);
      $scope.factory.company_id = company.id;

      $scope.factory.$update(function(response) {
        factory = response;
        $uibModalInstance.close(response);
      });
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
