'use strict';

angular.module('lead').controller('LeadLocationController', ['$scope', '$stateParams', '$uibModal', 'Environment', 'Concession', 'Factory', 'Lead',
  function ($scope, $stateParams, $uibModal, Environment, Concession, Factory, Lead) {
    $scope.destinationBy = Environment.destinationBy;

    $scope.lead = Lead.get({ id:$stateParams.id });

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
            company: $scope.lead.company,
            createNew: true
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
            company: $scope.lead.company,
            createNew: true
          }
        });


      modalInstance.result.then(function (res) {
        $scope.locations.push(res);
        $scope.selected.location = res;
      });
    };

    $scope.changePosition = function(e) {
      $scope.lead.latitude = e.latLng.lat();
      $scope.lead.longitude = e.latLng.lng();
    };


    $scope.select = function (location) {
      if($scope.lead){
        if(location){
          if ($scope.lead.lead_type === 'b') $scope.lead.concession_id = location.id;
          else $scope.lead.factory_id = location.id;

          $scope.lead.address = location.address;
          $scope.lead.city = location.city;
          $scope.lead.country = location.country;
          $scope.lead.port_distance = location.port_distance;
          $scope.lead.latitude = location.latitude;
          $scope.lead.longitude = location.longitude;
        } else $scope.lead.port_id = undefined;
      }
    };
  }
]);
