'use strict';

angular.module('bizdev').controller('IupModalController', ['$scope', '$uibModalInstance','NgMap',
  function($scope, $uibModalInstance, NgMap) {
    $scope.display = {};

    $scope.resetPolygon = function () {
      $scope.display.polygonString = $scope.iup.polygon;
      $scope.display.polygonArray = angular.fromJson($scope.iup.polygon);
    };

    $scope.clearPolygon = function(e){
      $scope.display = {
        polygonString: '',
        polygonArray: [],
      };
    };

    $scope.updatePolygonArray = function () {
      try {
        $scope.display.polygonArray = angular.fromJson($scope.display.polygonString);
      } catch (err) {
        console.log('format error');
      }
    };

    $scope.updatePolygonString = function (e) {
      var coordinates = e.overlay.getPath().getArray();
      e.overlay.setMap(null);

      $scope.display.polygonArray = [];
      for(var idx=0; idx < coordinates.length; idx++){
        $scope.display.polygonArray.push([coordinates[idx].lat(), coordinates[idx].lng()]);
      }

      $scope.display.polygonString = angular.toJson($scope.display.polygonArray);
    };

    $scope.initMap = function(){
      NgMap.getMap().then(function(map) {
        $scope.map = map;
        $scope.resetPolygon();
      });
    };


    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
