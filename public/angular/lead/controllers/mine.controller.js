'use strict';

angular.module('mine').controller('MineController', ['$scope', '$http', '$stateParams', '$state', 'Mine',
  function($scope, $http, $stateParams, $state, Mine) {
    $scope.mines = [];
    $scope.mine = {};

    $scope.create = function() {
      $scope.loading = true;

      var mine = new Mine({
        seller_id: $scope.mine.seller_id,
        
        latitude: $scope.mine.latitude,
        longitude: $scope.mine.longitude,

        mine_name: $scope.mine.mine_name,

        mineable_reserve: $scope.mine.mineable_reserve,
        striping_ratio: $scope.mine.striping_ratio,
        
        road_accessibility: $scope.mine.road_accessibility,
        port_distance: $scope.mine.port_distance,
        road_capacity: $scope.mine.road_capacity,
        port_name: $scope.mine.port_name,
        river_capacity: $scope.mine.river_capacity,

        source: $scope.mine.source,
        contact: $scope.mine.contact,
        phone: $scope.mine.phone,
        
        license_type: $scope.mine.license_type,
        license_expired_date: $scope.mine.license_expired_date,
        license_overlap: $scope.mine.license_overlap,
        license_release_after12Jan2009: $scope.mine.license_release_after12Jan2009,
        license_already_production: $scope.mine.license_already_production,
        
        restricted_area: $scope.mine.restricted_area,
        land_description: $scope.mine.land_description,
        land_overlap: $scope.mine.land_overlap,
        land_produce_KP: $scope.mine.land_produce_KP,
        land_use: $scope.mine.land_use,
        
        proximity_SMG_MILL: $scope.mine.proximity_SMG_MILL,
        proximity_SMG_KP: $scope.mine.proximity_SMG_KP,
        proximity_river_road: $scope.mine.proximity_river_road,
        
        coal_bearing_formation: $scope.mine.coal_bearing_formation,
        geological_description: $scope.mine.geological_description
      });

      mine.$save(function(response) {
        $state.go('mine.index');
        $scope.loading = false;
      });
    };

    $scope.update = function() {
      $scope.loading = true;

      $scope.mine.$update({ id: $scope.mine.id }, function(response) {
        $state.go('mine.index');
        $scope.loading = false;
      });
    };

    $scope.delete = function(mine) {
      $scope.loading = true;

      Mine.delete({ id: mine.id }, function(response) {
        $scope.mines.splice($scope.mines.indexOf(mine), 1);
      }, function(err) {
        console.log(err);
      });
    };

    $scope.find = function() {
      $scope.mines = Mine.query();
    };

    $scope.findOne = function() {
      $scope.mineId = $stateParams.id;
      $scope.mine = Mine.get({ id: $scope.mineId });
    };
  }
]);