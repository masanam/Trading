'use strict';

angular.module('coalpedia').controller('ConcessionModalController', ['$scope', '$uibModalInstance', '$timeout', '$interval', 'NgMap', 'Concession', 'Company', 'concession', 'company',
  function($scope, $uibModalInstance, $timeout, $interval, NgMap, Concession, Company, concession, company) {
    $scope.concession = concession;
    $scope.createNew = false;
    $scope.display = {};
    $scope.selected = {};

    $scope.find = function (keyword) {
      Concession.query({ q: keyword }, function(res){
        if(res.length > 0) $scope.concessions = res;
      });
    };

    $scope.create = function(concession) {
      concession = new Concession(concession);
      concession.polygon = $scope.display.polygonString;
      concession.company_id = company.id;

      concession.$save(function(response) {
        $uibModalInstance.close(response);
      });
    };

    $scope.update = function() {
      $scope.concession = new Concession($scope.concession);
      $scope.concession.polygon = $scope.display.polygonString;
      $scope.concession.company_id = company.id;

      $scope.concession.$update(function(response) {
        concession = response;
        $uibModalInstance.close(response);
      });
    };

    // Reset the polygon to the original inside the model
    $scope.resetPolygon = function () {
      $scope.display.polygonString = $scope.concession.polygon;
      $scope.display.polygonArray = angular.fromJson($scope.concession.polygon);
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

    $scope.attach = function (concession) {
      Company.get({ id: company.id, action: 'attach', concession_id: $scope.selected.concession.id }, function(response){
        $uibModalInstance.close(response.concession);
      });
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
