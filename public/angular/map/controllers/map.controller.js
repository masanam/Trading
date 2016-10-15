'use strict';

angular.module('map').controller('MapController', ['$scope', '$http', '$stateParams', '$state', 'Map', 'Concession', 'NgMap',
  function($scope, $http, $stateParams, $state, Map, Concession, NgMap) {
    $scope.filters = [{ field:'gcv_arb', operand: '>=', number: 5000 }];
    $scope.concession = {};
    $scope.concessions = [];
    
    NgMap.getMap().then(function(map) {
      $scope.map = map;
    });

    $scope.find = function() {
      
      $scope.filters_gt = [];
      $scope.filters_lt = [];
      $scope.filters_bet = [];
      
      var temp_filter = [];
      
      if($scope.filters.length > 0){      
        for(var i = 0; i < $scope.filters.length; i++){
          if($scope.filters[i].operand === '>='){
            temp_filter = $scope.filters_gt;
          }
          else if($scope.filters[i].operand === '<='){
            temp_filter = $scope.filters_lt;
          }
          else{
            temp_filter = $scope.filters_bet;
          }
          temp_filter.push($scope.filters[i].field+','+$scope.filters[i].number);
        }
        
        $scope.concessions = Map.query({ 'gt[]': $scope.filters_gt, 'bet[]': $scope.filters_bet, 'lt[]': $scope.filters_lt });
      }else{
        $scope.concessions = [];
      }
    };
    
    $scope.addFilter = function(){
      $scope.filters.push({ field:'', operand: '', number: 0 });
    };
    
    $scope.deleteFilter = function(filter){
      $scope.filters.splice($scope.filters.indexOf(filter), 1);
      $scope.find();
    };
    
    $scope.resetFilter = function(){
      $scope.filters = [];
      $scope.find();
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