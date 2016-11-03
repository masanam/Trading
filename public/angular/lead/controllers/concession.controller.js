'use strict';

angular.module('concession').controller('ConcessionController', ['$scope', '$http', '$stateParams', '$state', '$location', '$uibModal', 'Concession', '$window', 'Product','NgMap',
  function($scope, $http, $stateParams, $state, $location, $uibModal, Concession, $window, Product, NgMap) {
    $scope.concessions = [];
    $scope.concession = {};
    $scope.new = $location.search().new;

    $scope.create = function() {
      $scope.loading = true;

      var concession = new Concession({
        concession_name: $scope.concession.concession_name,
        seller_id: $scope.concession.seller_id,
        owner: $scope.concession.owner,
        address: $scope.concession.address
      });

      concession.$save(function(response) {
        $state.go('concession.index');
        $scope.loading = false;
      });
    };

    $scope.delete = function(concession) {
      $scope.loading = true;

      Concession.delete({ id: concession.id }, function(response) {
        $scope.concessions.splice($scope.concessions.indexOf(concession), 1);
      }, function(err) {
        console.log(err);
      });
    };

    $scope.find = function() {
      $scope.concessions = Concession.query();
    };

    $scope.findMyConcessions = function() {
      $scope.concessions = Concession.query({ action: 'my', id: $stateParams.id }, function(concessions){
        if(concessions.length === 0){
          $scope.openModalNewSeller();
        }
      });
    };

    $scope.findOne = function() {
      $scope.concessionId = $stateParams.id;
      Concession.get({ action: 'detail', id: $scope.concessionId },function(res){
        res.latitude=parseFloat(res.latitude);
        res.longitude=parseFloat(res.longitude);
        res.stripping_ratio=parseFloat(res.stripping_ratio);
        res.port_distance=parseFloat(res.port_distance);
        res.license_expiry_date=new Date(res.license_expiry_date);
        $scope.concession = res;
        
        $scope.polygon.polygonString = $scope.concession.polygon;
        $scope.updatePolygonString($scope.concession.polygon);

      });
    };

    $scope.goBack = function(){
      $state.go('lead.seller');
    };

    $scope.nextToProduct= function(){
      if ($scope.concession.selected) {
        $location.path('lead/buyer/'+$scope.buyer.selected.id+'/setup-product');
      }else{
        $scope.error = 'Please Select A Concession or Create New Concession';
      }
    };

    $scope.nextToProductSeller= function(){
      console.log($scope.concession.selected);
      if ($scope.concession.selected) {
        $location.path('lead/seller/'+$stateParams.id+'/setup-product');
      }else{
        $scope.error = 'Please Select A Concession or Create New Concession';
        console.log($scope.error);
      }

    };
    
    $scope.addProduct = function () {
      
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/product/create-from-concession.view.html',
        controller: 'CreateProductFromConcessionController',
        scope: $scope,
      });
    };

    $scope.init = function () {
      $scope.concession = new Concession();
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

    if($scope.polygon.array.length !== 0){
      $scope.concession.polygon = createStringByArray($scope.polygon.array);
    }else{
      $scope.concession.polygon = '';
    }
    
    $scope.update = function() {
      $scope.loading = true;
      
      if($scope.polygon.array.length !== 0){
        $scope.concession.polygon = createStringByArray($scope.polygon.array);
      }else{
        $scope.concession.polygon = '';
      }

      $scope.concession.$update({ id: $scope.concession.id }, function(response) {
        $state.go('lead.view-concession', { id: $scope.concession.id });
        $scope.loading = false;
      });
    };
    
    $scope.deleteProduct = function(product){
      Product.delete({ id: product.id }, function (response) {
        $scope.product = response;
        
        $scope.concession.product.splice($scope.concession.product.indexOf(product), 1);
        //$scope.close();
        $scope.success = true;
      }, function (response) {
        $scope.error = response.data.message;
      });
    };

    $scope.openModalNewSeller = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/concession/create-from-seller.view.html',
        controller: 'ConcessionModalController',
        scope: $scope
      });
    };
    
  }
]);

angular.module('concession').controller('ConcessionModalController', function ($scope, $stateParams, $location, $uibModalInstance, $filter, Concession, NgMap, $interval) {
  
  $scope.createConcession = function(){
    
    $scope.success = $scope.error = null;
    $scope.concession.license_expiry_date = $filter('date')($scope.concession.license_expiry_date, 'yyyy-MM-dd');
    $scope.concession.seller_id = $stateParams.id;

    var concession = $scope.concession;
    
    concession.$save(function (response) {
      $scope.progress = 0;
      $scope.success = true;
      var stop = $interval(function() {
        if ($scope.progress >= 0 && $scope.progress < 100) {
          $scope.progress++;
        } else {
          $interval.cancel(stop);
          stop = undefined;
          $location.path('lead/seller/'+$stateParams.id+'/setup-product').search({ new: $scope.new });
          $uibModalInstance.close('success');
        }
      }, 75);
    }, function (response) {
      $uibModalInstance.dismiss('cancel');
      $scope.error = response.data.message;
    });
    
  };

  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});  

angular.module('concession').controller('CreateProductFromConcessionController', function ($scope, $filter, $uibModalInstance, Product, Authentication) {
  
  $scope.product = new Product();
  
  var concessionId = $scope.concession.id;
    
  $scope.createProduct= function(){
    
    $scope.success = $scope.error = null;
    //$scope.product.license_expired_date = $filter('date')($scope.product.license_expired_date, 'yyyy-MM-dd');
    
    $scope.product.concession_id = concessionId;

    var product = $scope.product;
    
    product.$save(function (response) {
      $scope.product = response;
      
      $scope.concession.product.push($scope.product);
      $scope.close();
      $scope.success = true;
    }, function (response) {
      $scope.error = response.data.message;
    });
    
  };

  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});