'use strict';

angular.module('coalpedia').controller('PortModalController', ['$scope', '$uibModalInstance', '$timeout', '$interval', 'Port', 'Company', 'port', 'company',
  function($scope, $uibModalInstance, $timeout, $interval, Port, Company, port, company) {
    $scope.port = port;
    $scope.company = company;
    $scope.selected = {};

    $scope.find = function (keyword) {
      Port.query({ q: keyword }, function(res){
        if(res.length > 0) $scope.ports = res;
      });
    };

    $scope.changePosition = function(e) {
      $scope.port.latitude = e.latLng.lat();
      $scope.port.longitude = e.latLng.lng();
    };

    $scope.create = function() {
      var port = new Port($scope.port);
      port.company_id = company.id;

      port.$save(function(response) {
        $uibModalInstance.close(response);
      });
    };

    $scope.update = function() {
      $scope.port = new Port($scope.port);
      $scope.port.company_id = company.id;

      $scope.port.$update(function(response) {
        port = response;
        $uibModalInstance.close(response);
      });
    };

    $scope.attach = function (port) {
      Company.get({ id: company.id, action: 'attach', port_id: $scope.selected.port.id }, function(response){
        $uibModalInstance.close(response.port);
      });
    };


    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
