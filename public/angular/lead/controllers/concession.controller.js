'use strict';

angular.module('concession').controller('ConcessionController', ['$scope', '$http', '$stateParams', '$state', 'Concession', '$uibModal', '$window', 'Product',
  function($scope, $http, $stateParams, $state, Concession, $uibModal, $window, Product) {
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

    $scope.findOne = function() {
      $scope.concessionId = $stateParams.id;
      $scope.concession = Concession.get({ action: 'detail', id: $scope.concessionId });
    };
    
    $scope.goBack = function(){
      $window.history.back();
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
    
  }
]);

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