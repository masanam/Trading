'use strict';

angular.module('lead').controller('LeadLocationController', ['$scope', '$stateParams', '$uibModal', 'Concession', 'Factory', 'Lead',
  function ($scope, $stateParams, $uibModal, Concession, Factory, Lead) {
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
      var modalInstance;
      
      if ($scope.lead.lead_type === 'b')
        modalInstance = $uibModal.open({
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
        modalInstance = $uibModal.open({
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