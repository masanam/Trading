'use strict';

angular.module('map').controller('MapController', ['$scope', '$http', '$stateParams', '$state', 'Map', 'Concession', 'Port', 'NgMap',
  function($scope, $http, $stateParams, $state, Map, Concession, Port, NgMap) {
    //$scope.filters = [{ field:'gcv_arb', operand: '>=', number: 5000 }];
    $scope.filters = [];
    $scope.concession = {};
    $scope.concessions = [];
    $scope.ports = [];
    $scope.product = undefined;
    
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
      console.log(concession);
      $scope.concession = Concession.get({ action:'detail', id: concession.id }, function(concession) {
        $scope.concession = concession;
        $scope.map.showInfoWindow('info-window', event.latLng);
        
        $scope.product = undefined;
      });
    };

    $scope.showPortDetail = function(event, port) {
      $scope.connectedConcessions = Port.query({ id: port.id , concession: 'concession' });
      $scope.port = Port.get({ id: port.id }, function(port) {
        $scope.port = port;
        $scope.map.showInfoWindow('port-info-window', event.latLng);
        
        $scope.product = undefined;
      });
    };
    
    $scope.showProduct = function(product) {
      $scope.product = product;
    };
    
    $scope.selectPill = function(index){
      $scope.selectedPill = index;
    };

  }
]);