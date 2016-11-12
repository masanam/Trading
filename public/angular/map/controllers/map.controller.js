'use strict';

angular.module('map').controller('MapController', ['$scope', '$http', '$stateParams', '$state', 'Map', 'Concession', 'Port', 'NgMap',
  function($scope, $http, $stateParams, $state, Map, Concession, Port, NgMap) {
    //$scope.filters = [{ field:'gcv_arb', operand: '>=', number: 5000 }];
    $scope.filters = [];
    $scope.search = {};
    $scope.concession = {};
    $scope.concessions = [];
    $scope.ports = [];
    $scope.product = undefined;
    
    $scope.customIcon = {
      scaledSize: [32, 32],
      url: 'http://www.cliparthut.com/clip-arts/823/arrowhead-clip-art-823528.png'
    };
    
    NgMap.getMap().then(function(map) {
      $scope.map = map;
      console.log($scope.map);
    });

    $scope.find = function() {
      
      $scope.filters_gt = [];
      $scope.filters_lt = [];
      $scope.filters_bet = [];
      
      var temp_filter = [];
      
      $scope.search_port = [];
      $scope.search_product = [];
      $scope.search_concession = [];
      $scope.search_seller = [];

      var temp_search = [];
      
      var params = {};
      
      if($scope.search || $scope.filters.length > 0){
        if($scope.search){
          if($scope.search.category === 'port'){
            temp_search = $scope.search_port;
          }
          else if($scope.search.category === 'product'){
            temp_search = $scope.search_product;
          }
          else if($scope.search.category === 'concession'){
            temp_search = $scope.search_concession;
          }
          else if($scope.search.category === 'seller'){
            temp_search = $scope.search_seller;
          }
          temp_search.push($scope.search.keyword);

          params.product = $scope.search_product[0];
          params.port = $scope.search_port[0];
          params.seller = $scope.search_seller[0];
          params.concession = $scope.search_concession[0];
        }
        
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
          
          params['gt[]'] = $scope.filters_gt;
          params['lt[]'] = $scope.filters_lt;
          params['bet[]'] = $scope.filters_bet;
        }
      }
      
      params.action = 'filter';
      
      $scope.concessions = Map.query(params);
      //console.log($scope.concessions);
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

    $scope.searchByCategory = function(){
      
    };

    $scope.showDetail = function(event, concession) {
      $scope.concession = Concession.get({ action:'detail', id: concession.id }, function(concession) {
        $scope.concession = concession;
        $scope.map.showInfoWindow('info-window', event.latLng);
        
        $scope.product = undefined;
      });
    };

    $scope.showPortDetail = function(event, port) {
      $scope.connectedConcessions = Port.query({ id: port.id , concession: 'concession' });
      $scope.port = Port.get({ id: port.id }, function(port) {
        $scope.event = event;
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