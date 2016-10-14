'use strict';

angular.module('map').controller('MapController', ['$scope', '$http', '$stateParams', '$state', 'Map', 'Concession', 'NgMap',
  function($scope, $http, $stateParams, $state, Map, Concession, NgMap) {
    $scope.filters = [];
    //$scope.filters.gt = ['gcv_arb, 5000', 'gcv_adb, 3000'];
    $scope.concession = {};
    $scope.concessions = [];
    
    NgMap.getMap().then(function(map) {
      $scope.map = map;
    });

    $scope.find = function() {
      $scope.concessions = Map.query($scope.filters);
      //console.log("vm.positions", $scope.concessions);
    };
    
    $scope.addFilter = function(){
      $scope.filters.push();
    };

    $scope.showDetail = function(event, concession) {
      var loc = this;
      $scope.concession = Concession.get({ id: concession.id }, function(concession) {
        $scope.concession = concession;
        $scope.map.showInfoWindow('info-window', loc);
      });
    };

  }
]);