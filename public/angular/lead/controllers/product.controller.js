'use strict';

angular.module('product').controller('ProductController', ['$scope', '$state', '$http', '$stateParams', '$q', '$uibModal', 'Product', 'Concession','Seller','Buyer', '$window','$location',
  function($scope, $state, $http, $stateParams, $q, $uibModal, Product, Concession,Seller,Buyer, $window, $location) {
    $scope.formOpen = false;

    $scope.find = function() {
      //find corresponding product to selected mines
      $scope.products = Product.query();
    };

    $scope.findOne = function () {
      Product.get({ id: $stateParams.id }, function(res){
        res.ash_min = parseFloat(res.ash_min);
        res.ash_max = parseFloat(res.ash_max);
        res.ts_min = parseFloat(res.ts_min);
        res.ts_max = parseFloat(res.ts_max);
        res.tm_min = parseFloat(res.tm_min);
        res.tm_max = parseFloat(res.tm_max);
        res.im_min = parseFloat(res.im_min);
        res.im_max = parseFloat(res.im_max);
        res.fc_min = parseFloat(res.fc_min);
        res.fc_max = parseFloat(res.fc_max);
        res.vm_min = parseFloat(res.vm_min);
        res.vm_max = parseFloat(res.vm_max);
        $scope.product = res;
      });
    };


    $scope.backToDetail = function(){
      $window.history.back();
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
      $scope.product.$update({ id: $stateParams.id }, function(response) {
        $location.path('lead/product/'+$stateParams.id);
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
    
    $scope.goBack = function(){
      $window.history.back();
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