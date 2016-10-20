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
      "scaledSize": [32, 32],
      "url": "http://www.cliparthut.com/clip-arts/823/arrowhead-clip-art-823528.png"
    };
    
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
        
        $scope.concessions = Map.query({ action: 'filter' , 'gt[]': $scope.filters_gt, 'bet[]': $scope.filters_bet, 'lt[]': $scope.filters_lt });
      }else{
        $scope.concessions = Map.query({ action: 'filter' });
      }
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
      $scope.search_port = [];
      $scope.search_product = [];
      $scope.search_concession = [];
      $scope.search_seller = [];

      var temp_search = [];

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

        $scope.concessions = Map.query({ action: 'search' , 'product': $scope.search_product[0] , 'port': $scope.search_port[0] , 'seller': $scope.search_seller[0] , 'concession': $scope.search_concession[0] });

        console.log($scope.concessions);
      }else{
        $scope.concessions = Map.query({ action: 'search' });
      }
    };

    $scope.showDetail = function(event, concession) {
      $scope.concession = Concession.get({ action:'detail', id: concession.id }, function(concession) {
        $scope.concession = concession;
        $scope.map.showInfoWindow('info-window', event.latLng);
        
        $scope.product = undefined;
      });
    };

    $scope.showPortDetail = function(event, port) {
      console.log(port);
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