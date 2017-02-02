'use strict';

angular.module('lead').controller('LeadLocationController', ['$scope', '$stateParams', '$uibModal', 'Environment', 'Concession', 'Factory', 'Lead', 'NgMap',
  function ($scope, $stateParams, $uibModal, Environment, Concession, Factory, Lead, NgMap) {
    $scope.destinationBy = Environment.destinationBy;

    //Init select ports
    $scope.find = function(keyword) {
      $scope.lead = Lead.get({ id:$stateParams.id }, function(){
        //console.log($scope.lead.lead_type === 'b');
        if ($scope.lead.lead_type === 'b'){
          Concession.query({ q: keyword }, function(res){
            if(res.length > 0) $scope.locations = res;
          });
        } else {
          Factory.query({ q: keyword }, function(res){
            if(res.length > 0) $scope.locations = res;
          });
        }
      });
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

    // Reset the polygon to the original inside the model
    $scope.resetPolygon = function () {
      $scope.display.polygonArray = $scope.lead.polygon.coordinates[0];
      $scope.display.polygonString = angular.toJson($scope.display.polygonArray);
    };

    // Clear displayed polygon to restart adding new ones
    $scope.clearPolygon = function(e){
      $scope.display = {
        polygonString: '',
        polygonArray: [],
      };
    };

    // Update polygon in map after editing the textarea
    $scope.updatePolygonArray = function () {
      try {
        $scope.display.polygonArray = angular.fromJson($scope.display.polygonString);
      } catch (err) {
        console.log('format error');
      }
    };

    // Update polygon in string after drawing in the map
    $scope.updatePolygonString = function (e) {
      var coordinates = e.overlay.getPath().getArray();
      e.overlay.setMap(null);

      $scope.display.polygonArray = [];
      for(var idx=0; idx < coordinates.length; idx++){
        $scope.display.polygonArray.push([coordinates[idx].lat(), coordinates[idx].lng()]);
      }

      $scope.display.polygonString = angular.toJson($scope.display.polygonArray);
    };

    // Initialize map as early use
    $scope.initMap = function(){
      NgMap.getMap().then(function(map) {
        $scope.map = map;
        $scope.resetPolygon();
      });
    };

    $scope.select = function (location) {
      $scope.clearPolygon();
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
          $scope.lead.polygon = location.polygon;

          $scope.display.polygonArray = angular.fromJson($scope.lead.polygon).coordinates[0];
          $scope.display.polygonString = angular.toJson($scope.display.polygonArray);

        } else $scope.lead.port_id = undefined;
      }
    };
  }
]);
