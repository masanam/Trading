'use strict';

angular.module('coalpedia').controller('PortModalController', ['$scope', '$uibModalInstance', '$timeout', '$interval', 'Port', 'Company', 'port', 'company', 'createNew',
  function($scope, $uibModalInstance, $timeout, $interval, Port, Company, port, company, createNew) {
    $scope.port = port;
    $scope.company = company;
    if(createNew) $scope.createNew = createNew;

    $scope.selected = {};

    $scope.find = function (keyword) {
      Port.query({ q: keyword, company_id:company.id }, function(res){
        if(res.length > 0) $scope.ports = res;
      });
    };

    $scope.changePosition = function(e) {
      $scope.port.latitude = e.latLng.lat();
      $scope.port.longitude = e.latLng.lng();
    };

    $scope.create = function(port) {
      if(!port.is_private) {
        $scope.error = 'Please Select Status of Port!';
        return;
      }
      else $scope.error = null;
      port = new Port(port);
      port.company_id = company.id;

      port.$save(function(response) {
        $uibModalInstance.close(response);
      });
    };

    $scope.update = function() {
      $scope.port.company_id = company.id;

      $scope.port.$update({ id: $scope.port.id }, function(response) {
        port = response;
        $uibModalInstance.close(response);
      });
    };

    $scope.attach = function (port) {
      console.log('aaa');
      Company.get({ id: company.id, action: 'attach', port_id: $scope.selected.port.id }, function(response){
        $uibModalInstance.close(response.port);
      });
    };


    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
