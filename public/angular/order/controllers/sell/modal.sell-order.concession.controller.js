'use strict';

angular.module('order').controller('ConcessionModalSellOrderController',
  function($scope, $stateParams, $uibModalInstance, $location, $interval, Concession, Order, NgMap) {

    $scope.init = function () {
      $scope.concession = new Concession();
    };

    $scope.create = function(){
      $scope.concession.seller_id = $stateParams.id;
      
      $scope.concession.$save(function (res) {

        console.log(res);
        $scope.progress = 0;
        $scope.success = true;
        $scope.concession_id = res.id;
        var stop = $interval(function() {
          if ($scope.progress >= 0 && $scope.progress < 100) {
            $scope.progress++;
          } else {
            $interval.cancel(stop);
            stop = undefined;
            $scope.order = new Order({
              seller_id: $stateParams.id,
              concession_id: res.id,
              address: res.address,
              city: res.city,
              country: res.country,
              latitude: res.latitude,
              longitude: res.longitude,
              order_status: 2
            });
            $scope.order.$update({ type: 'sell', id: $stateParams.order_id }, function(res) {
              $location.path('sell-order/create/product/'+$stateParams.id+'/'+$stateParams.order_id+'/'+$scope.concession_id);
              $uibModalInstance.close('success');
            });
          }
        }, 75);
      });
      
    };

    $scope.initMap = function(){
      NgMap.getMap().then(function(map) {
        $scope.map = map;
      });
    };
    
    $scope.resetMap = function(){
      console.log($scope.map);
      $scope.map.shapes.foo.setMap(null);
    };
    
    $scope.resetPolygon = function(e){
      $scope.initMap();
      $scope.polygon = {
        polygonString: '',
        array: [],
      };
    };
    
    $scope.resetPolygon();
    
    /*$scope.addMarkerAndPath = function(event) {
      $scope.polygon.push([event.latLng.lat(), event.latLng.lng()]);
    };*/
    
    $scope.updatePolygonString = function(polygonString){
      $scope.polygon.polygonString = polygonString;
      if($scope.polygon.polygonString !== ''){
        $scope.polygon.array = JSON.parse($scope.polygon.polygonString);
      }else{
        $scope.polygon.array = [];
      }
    };
    
    $scope.onMapOverlayCompleted = function(e){
      
      e.overlay.setMap(null);
      
      var coordinates = e.overlay.getPath().getArray();
      
      $scope.polygon.array = [];
      
      for(var idx=0; idx < coordinates.length; idx++){
        $scope.polygon.array.push([coordinates[idx].lat(), coordinates[idx].lng()]);
      }
      
      $scope.polygon.polygonString = createStringByArray($scope.polygon.array);
      
      //$scope.polygon = e;
    };
    
    function createStringByArray(array) {
      var output = '[';
      angular.forEach(array, function (object, keyObj) {
        output += '[';
        angular.forEach(object, function (value, key) {
          if(key === 0){
            output += value + ',';
          }else{
            output += value + '';
          }
        });
        if(keyObj === (array.length-1)){
          output += ']';
        }
        else{
          output += '],';
        }
      });
      output += ']';
      return output;
    }

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
    
  }
);
