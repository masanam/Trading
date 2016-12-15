'use strict';

angular.module('lead').controller('LeadLocationController', ['$scope', '$stateParams', '$uibModal', 'Concession', 'Factory', 'Lead',
  function ($scope, $stateParams, $uibModal, Concession, Factory, Lead) {
    $scope.selected = {};

    $scope.$watch('selected.location', function (newValue, oldValue) {
      if(newValue){
        if ($scope.lead.lead_type === 'b') $scope.lead.concession_id = newValue.id;
        else $scope.lead.factory_id = newValue.id;

        $scope.lead.address = newValue.address;
        $scope.lead.city = newValue.city;
        $scope.lead.country = newValue.country;
        $scope.lead.port_distance = newValue.port_distance;
        $scope.lead.latitude = newValue.latitude;
        $scope.lead.longitude = newValue.longitude;
      }
      else $scope.lead.port_id = undefined;
    });

    $scope.init = function () {
      if ($scope.lead.lead_type === 'b') $scope.selected.concession = $scope.lead.location;
      else $scope.selected.factory = $scope.lead.location;
    };

    //Init select ports
    $scope.find = function(keyword) {
      if ($scope.lead.lead_type === 'b'){
        Concession.query({ q: keyword }, function(res){
          if(res.length > 0) $scope.locations = res;
        }); 
      } else {
        Factory.query({ q: keyword }, function(res){
          if(res.length > 0) $scope.locations = res;
        }); 
      }
    };

    $scope.add = function () {
      if ($scope.lead.lead_type === 'b')
        var modalInstance = $uibModal.open({
          animation: true,
          ariaLabelledBy: 'modal-title',
          ariaDescribedBy: 'modal-body',
          templateUrl: './angular/coalpedia/views/concession/_create.modal.view.html',
          controller: 'ConcessionModalController',
          windowClass: 'xl-modal',
          resolve: {
            concession: new Concession(),
            company: $scope.company
          }
        });
      else
        var modalInstance = $uibModal.open({
          animation: true,
          ariaLabelledBy: 'modal-title',
          ariaDescribedBy: 'modal-body',
          templateUrl: './angular/coalpedia/views/factory/_create.modal.view.html',
          controller: 'FactoryModalController',
          windowClass: 'xl-modal',
          resolve: {
            factory: new Factory(),
            company: $scope.company
          }
        });


      modalInstance.result.then(function (res) {
        $scope.selected.location = res;
      });
    };

    $scope.changePosition = function(e) {
      $scope.lead.latitude = e.latLng.lat();
      $scope.lead.longitude = e.latLng.lng();
    };
  }
]);