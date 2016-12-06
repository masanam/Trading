'use strict';

angular.module('coalpedia').controller('PortController', ['$scope', '$stateParams', '$state', '$uibModal', 'Port',
  function($scope, $stateParams, $state, $uibModal, Port) {
    $scope.add = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/coalpedia/views/port/_create.modal.view.html',
        controller: 'PortModalController',
        windowClass: 'xl-modal',
        resolve: {
          port: new Port(),
          company: $scope.company
        }
      });

      modalInstance.result.then(function (res) {
        if(!$scope.company.ports) $scope.company.ports = [];
        
        $scope.company.ports.push(res);
      });
    };

    $scope.edit = function (port) {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/coalpedia/views/port/_update.modal.view.html',
        controller: 'PortModalController',
        windowClass: 'xl-modal',
        resolve: {
          port: Port.get({ id: port.id }),
          company: $scope.company
        }
      });

      modalInstance.result.then(function (res) {
        if(!$scope.company.ports) $scope.company.ports = [];
        $scope.company.ports.splice($scope.company.ports.indexOf(port), 1, res);
      });
    };

    $scope.delete = function (port) {
      if(confirm('Are you sure you want to delete ' + port.port_name + '?')){
        port = new Port(port);
        port.$remove(function (res){
          $scope.company.ports.splice($scope.company.ports.indexOf(port), 1);
        });
      }
    };

    $scope.findOne = function(id) {
      if(id !== undefined){
        $scope.portId = id;
      } else {
        $scope.portId = $stateParams.id;
      }

      Port.get({ id: $scope.portId }, function(port){
        $scope.port = port;
      });
    };
  }
]);
