'use strict';

angular.module('concession').controller('ConcessionController', ['$scope', '$http', '$stateParams', '$state', '$location', '$uibModal', 'Concession', '$window', 'Product',
  function($scope, $http, $stateParams, $state, $location, $uibModal, Concession, $window, Product) {
    $scope.concessions = [];
    $scope.concession = {};

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

    $scope.update = function() {
      $scope.loading = true;

      $scope.concession.$update({ id: $scope.concession.id }, function(response) {
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
      $scope.concessions = Concession.query({ action: 'my', id: $stateParams.id });
    };

    $scope.findOne = function() {
      $scope.concessionId = $stateParams.id;
      $scope.concession = Concession.get({ action: 'detail', id: $scope.concessionId });
    };

    $scope.goBack = function(){
      $window.history.back();
    };

    $scope.nextToProduct= function(){
      if ($scope.concession.selected) {
        $location.path('lead/buyer/'+$scope.buyer.selected.id+'/setup-product');
      }else{
        $scope.error = "Please Select A Concession or Create New Concession";
      }
    };

    $scope.nextToProductSeller= function(){
      console.log($scope.concession.selected);
      if ($scope.concession.selected) {
        $location.path('lead/seller/'+$stateParams.id+'/setup-product');
      }else{
        $scope.error = "Please Select A Concession or Create New Concession";
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

angular.module('concession').controller('ConcessionModalController', function ($scope, $uibModalInstance, $stateParams, $filter, Concession, NgMap) {
  
  $scope.init = function () {
    $scope.concession = new Concession();
  };

  $scope.create = function() {
    console.log($scope.concession);
    $scope.loading = true;
    $scope.concession.seller_id = $stateParams.id;

    // var concession = new Concession({
    //   concession_name: $scope.concession.concession_name,
    //   seller_id: $stateParams.id,
    //   owner: $scope.concession.owner,
    //   address: $scope.concession.address
    // });

    $scope.concession.$save(function(response) {
      $scope.concessions.push(response);
      $scope.loading = false;
      $uibModalInstance.close('success');
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
  
  $scope.createConcession = function(){
    console.log($scope.concession);
    
    $scope.success = $scope.error = null;
    $scope.concession.license_expiry_date = $filter('date')($scope.concession.license_expiry_date, 'yyyy-MM-dd');
    $scope.concession.seller_id = $stateParams.id;
    
    if($scope.polygon.array.length === 0){
      $scope.concession.polygon = createStringByArray($scope.polygon.array);
    }else{
      $scope.concession.polygon = '';
    }

    var concession = $scope.concession;
    
    concession.$save(function (response) {
      $scope.concession = response;
      
      $scope.seller.concession.push($scope.concession);
      $uibModalInstance.close('success');
      $scope.success = true;
    }, function (response) {
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