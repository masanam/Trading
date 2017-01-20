'use strict';

angular.module('coalpedia').controller('FactoryModalController', ['$scope', '$uibModalInstance', '$timeout', '$interval', 'Factory', 'Company', 'factory', 'company', 'createNew',
  function($scope, $uibModalInstance, $timeout, $interval, Factory, Company, factory, company, createNew) {
    $scope.factory = factory;
    if(createNew) $scope.createNew = createNew;
    $scope.selected = {};

    $scope.find = function (keyword) {
      Factory.query({ q: keyword, company_id:company.id, coalpedia:true }, function(res){
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
      $scope.factory.company_id = company.id;

      $scope.factory.$update({ id: $scope.factory.id }, function(response) {
        factory = response;
        $uibModalInstance.close(response);
      });
    };

    $scope.attach = function (factory) {
      Company.get({ id: company.id, action: 'attach', factory_id: $scope.selected.factory.id }, function(response){
        $uibModalInstance.close(response.factory);
      });
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
