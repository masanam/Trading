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
        
        $scope.concessions = Map.query({ 'gt[]': $scope.filters_gt, 'bet[]': $scope.filters_bet, 'lt[]': $scope.filters_lt });
      }else{
        $scope.concessions = [];
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

    $scope.search = function(){
      var temp_length = $scope.concessions.length;
      if($scope.search.category === 'port') {
        angular.forEach($scope.concessions, function(concession){
          if(concession.port.port_name.indexOf($scope.search.keyword) === -1) {
            $scope.concessions.splice($scope.concessions.indexOf(concession), 1);
          }
        });
      } else if($scope.search.category === 'product') {
        for(var i = 0; i < temp_length; i++) {
          if($scope.concessions[i].product.length === 0) {
            var tempo = $scope.concessions[i];
            $scope.concessions.splice($scope.concessions.indexOf(tempo), 1);
            break;
          } else {
            for(var j = 0; j < $scope.concessions[i].product.length; j++) {
              if($scope.concessions[i].product[j].product_name.indexOf($scope.search.keyword) > -1) continue;
              else if($scope.concessions[i].product[j].product_name.indexOf($scope.search.keyword) === -1 && j !== $scope.concessions[i].product.length - 1) continue;
              else if($scope.concessions[i].product[j].product_name.indexOf($scope.search.keyword) === -1 && j === $scope.concessions[i].product.length - 1) {
                var temp = $scope.concessions[i];
                $scope.concessions.splice($scope.concessions.indexOf(temp), 1);
              }
            }
          }
        }
      } else if($scope.search.category === 'concession') {
        angular.forEach($scope.concessions, function(concession){
          if(concession.concession_name.indexOf($scope.search.keyword) === -1) {
            $scope.concessions.splice($scope.concessions.indexOf(concession), 1);
          }
        });
      } else if($scope.search.category === 'seller') {
        angular.forEach($scope.concessions, function(concession){
          if(concession.seller.company_name.indexOf($scope.search.keyword) === -1) {
            $scope.concessions.splice($scope.concessions.indexOf(concession), 1);
          }
        });
      }
      console.log($scope.concessions);
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