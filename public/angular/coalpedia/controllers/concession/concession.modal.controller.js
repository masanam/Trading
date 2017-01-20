'use strict';

angular.module('coalpedia').controller('ConcessionModalController', ['$scope', '$uibModalInstance', '$stateParams', '$timeout', '$interval', 'NgMap', 'Concession', 'Company', 'concession', 'company', 'createNew',
  function($scope, $uibModalInstance, $stateParams, $timeout, $interval, NgMap, Concession, Company, concession, company, createNew) {
    $scope.concession = concession;
    $scope.concession.polygon = angular.fromJson(concession.polygon);

    if(createNew) $scope.createNew = createNew;
    $scope.display = {};
    $scope.selected = {};

    $scope.find = function (keyword) {
      var query = {};

      if(company) query.company_id = company.id;
      if(keyword) query.q = keyword;
      query.coalpedia = true;

      Concession.query(query, function(res){
        if(res.length > 0) $scope.concessions = res;
      });
    };

    $scope.create = function(concession) {
      concession = new Concession(concession);

      if($scope.display.polygonArray[0] !== $scope.display.polygonArray[$scope.display.polygonArray.length-1])
        $scope.display.polygonArray.push($scope.display.polygonArray[0]);

      $scope.display.polygonString = angular.toJson($scope.display.polygonArray);
      concession.polygon = $scope.display.polygonString.split(',').join(' ').split('[[').join('(').split(']]').join(')');
      concession.polygon = concession.polygon.split('] [').join(', ');
      concession.company_id = company.id;

      concession.$save(function(response) {
        $uibModalInstance.close(response);
      });
    };

    $scope.update = function() {
      concession = $scope.concession;

      if($scope.display.polygonArray[0] !== $scope.display.polygonArray[$scope.display.polygonArray.length-1])
        $scope.display.polygonArray.push($scope.display.polygonArray[0]);

      $scope.display.polygonString = angular.toJson($scope.display.polygonArray);
      concession.polygon = $scope.display.polygonString.split(',').join(' ').split('[[').join('(').split(']]').join(')');
      concession.polygon = concession.polygon.split('] [').join(', ');

     // concession.polygon = $scope.display.polygonString;
      concession.company_id = concession.company_id;
      concession.$update({ id: $stateParams.id } , function(response) {
        concession = response;
        $uibModalInstance.close(response);
        $scope.concession=response;
      });
    };

    // Reset the polygon to the original inside the model
    $scope.resetPolygon = function () {
      $scope.display.polygonArray = $scope.concession.polygon.coordinates[0];
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
