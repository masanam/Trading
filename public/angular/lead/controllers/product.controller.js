'use strict';

angular.module('product').controller('ProductController', ['$scope', '$state', '$http', '$stateParams', '$q', '$uibModal', 'Product', 'Concession','Seller','Buyer',
  function($scope, $state, $http, $stateParams, $q, $uibModal, Product, Concession,Seller,Buyer) {
    $scope.formOpen = false;

    $scope.find = function() {
      //find corresponding product to selected mines
      $scope.products = Product.query();
    };

    $scope.findOne = function () {
      $scope.product = Product.get({ id: $stateParams.id });
    };


    $scope.initializeEmptyForm = function () {
      $scope.product = {};
      $scope.concessions = Concession.query({ option: 'dropdown' });
    };

    $scope.openModal = function (id) {
      var modalInstance = $uibModal.open({
        size: 'lg',
        templateUrl: './angular/views/product/product-modal.view.html',
        controller: 'ProductModalController',
        resolve: {
          product: function () {
            return Product.get({ id: id });
          }
        }
      });
    };

    $scope.openProductModal = function (order) {
      
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/product/create.product.modal.html',
        scope: $scope,
        controller: 'CrtProductModalController'
      });
    };

    $scope.initializeUpdateForm = function () {
      $scope.findOne($stateParams.id);
      
      $scope.concessions = Concession.query({ option: 'dropdown' }, function (){
        for(var x=0; x<$scope.concessions.length; x++){
          if($scope.product.concession_id === $scope.concessions[x].id){
            $scope.product.concession = $scope.concessions[x];
          }
        }
      });
    };

    $scope.findAllSellers = function(){
      $scope.sellers = Seller.query();
    };
    
    $scope.findAllBuyers = function(){
      $scope.buyers = Buyer.query();
    };

    $scope.initializeAddForm = function () {
      $scope.product = Product.get({ id: $stateParams.id }, function(){
        $scope.production = {};
      });
    };

    $scope.initializeOpnameForm = function () {
      $scope.product = Product.get({ id: $stateParams.id }, function(){
        $scope.correction = { volume: $scope.product.volume };
      });
    };

    $scope.create = function (){
      $scope.loading = true;

      var product = new Product($scope.product);

      product.$save(function(response) {
        $state.go('product.index');
        $scope.loading = false;
      });
    };

    $scope.update = function (){
      $scope.loading = true;

      $scope.product.$update({ id: $scope.product.id }, function(response) {
        $state.go('product.index');
        $scope.loading = false;
      });
    };

    $scope.delete = function (product){
      $scope.loading = true;

      Product.delete({ id: product.id }, function(response) {
        $scope.products.splice($scope.products.indexOf(product), 1);
      }, function(err) {
        console.log(err);
      });
    };
  }
]);


angular.module('product').controller('ProductModalController', function ($scope, $uibModalInstance, Product, product) {
  $scope.product = product;

  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});


angular.module('product').controller('CrtProductModalController', function ($scope, $filter, $uibModalInstance, Product) {
  $scope.product = new Product();

  $scope.crtProduct = function (formCreateProduct) {
    var product = new Product($scope.product);

    product.$save(function(response) {
      $scope.products.push(response);
      $uibModalInstance.close('success');
      $scope.loading=false;
    });
  };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});