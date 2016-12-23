'use strict';

angular.module('lead').controller('LeadPortController', ['$scope', '$stateParams', '$uibModal', 'Port', 'Lead',
  function ($scope, $stateParams, $uibModal, Port, Lead) {
    //Init select ports
    $scope.find = function(keyword) {
      Port.query({ q: keyword }, function(res){
        if(res.length > 0) $scope.ports = res;
      });
    };

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
          company: $scope.lead.company
        }
      });

      modalInstance.result.then(function (res) {
        $scope.selected.port = res;
      });
    };

    $scope.changePosition = function(e) {
      $scope.lead.port_latitude = e.latLng.lat();
      $scope.lead.port_longitude = e.latLng.lng();
    };

    $scope.select = function (port) {
      if($scope.lead){
        if(port){
          $scope.lead.port_id = port.id;
          $scope.lead.port_name = port.port_name;
          $scope.lead.port_status = port.status;
          $scope.lead.port_daily_rate = port.daily_rate;
          $scope.lead.port_draft_height = port.draft_height;
          $scope.lead.port_latitude = port.latitude;
          $scope.lead.port_longitude = port.longitude;
        } else $scope.lead.port_id = undefined;
      }
    };
  }
]);