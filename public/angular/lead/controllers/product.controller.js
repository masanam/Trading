'use strict';

angular.module('product').controller('ProductController', ['$scope', '$state', '$http', '$stateParams', '$q', '$uibModal', 'Product', 'Mine','Seller','Buyer',
  function($scope, $state, $http, $stateParams, $q, $uibModal, Product, Mine,Seller,Buyer) {
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
      $scope.mines = Mine.query({ option: 'dropdown' });
    };

    $scope.openModal = function (id) {
      var modalInstance = $uibModal.open({
        size: 'lg',
        templateUrl: './angular/views/product/product-modal.view.html',
        controller: 'ProductModalController',
        resolve: {
          product: function () {
            return Product.get({ id: id });;
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
      
      $scope.mines = Mine.query({ option: 'dropdown' }, function (){
        for( var x=0; x < $scope.mines.length; x++ ){
          if( $scope.product.mine_id === $scope.mines[x].id ){
            $scope.product.mine = $scope.mines[x];
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

      var product = new Product({
        mine_id: $scope.product.mine_id,
        commercial_term: $scope.product.commercial_term,

        volume: $scope.product.volume,

        tm_min: $scope.product.tm_min,
        tm_max: $scope.product.tm_max,
        tm_reject: $scope.product.tm_reject,
        tm_bonus: $scope.product.tm_bonus,
        im_min: $scope.product.im_min,
        im_max: $scope.product.im_max,
        im_reject: $scope.product.im_reject,
        im_bonus: $scope.product.im_bonus,
        ash_min: $scope.product.ash_min,
        ash_max: $scope.product.ash_max,
        ash_reject: $scope.product.ash_reject,
        ash_bonus: $scope.product.ash_bonus,
        fc_min: $scope.product.fc_min,
        fc_max: $scope.product.fc_max,
        fc_reject: $scope.product.fc_reject,
        fc_bonus: $scope.product.fc_bonus,
        vm_min: $scope.product.vm_min,
        vm_max: $scope.product.vm_max,
        vm_reject: $scope.product.vm_reject,
        vm_bonus: $scope.product.vm_bonus,
        ts_min: $scope.product.ts_min,
        ts_max: $scope.product.ts_max,
        ts_reject: $scope.product.ts_reject,
        ts_bonus: $scope.product.ts_bonus,
        ncv_min: $scope.product.ncv_min,
        ncv_max: $scope.product.ncv_max,
        ncv_reject: $scope.product.ncv_reject,
        ncv_bonus: $scope.product.ncv_bonus,
        gcv_arb_min: $scope.product.gcv_arb_min,
        gcv_arb_max: $scope.product.gcv_arb_max,
        gcv_arb_reject: $scope.product.gcv_arb_reject,
        gcv_arb_bonus: $scope.product.gcv_arb_bonus,
        gcv_adb_min: $scope.product.gcv_adb_min,
        gcv_adb_max: $scope.product.gcv_adb_max,
        gcv_adb_reject: $scope.product.gcv_adb_reject,
        gcv_adb_bonus: $scope.product.gcv_adb_bonus,
        hgi_min: $scope.product.hgi_min,
        hgi_max: $scope.product.hgi_max,
        hgi_reject: $scope.product.hgi_reject,
        hgi_bonus: $scope.product.hgi_bonus,
        size_min: $scope.product.size_min,
        size_max: $scope.product.size_max,
        size_reject: $scope.product.size_reject,
        size_bonus: $scope.product.size_bonus,
      });

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

    $scope.add = function (){
      $scope.loading = true;

      var production = new Production({
        tonnage: $scope.production.tonnage,
        product_id: $scope.product.id,
        description: $scope.production.description
      });

      production.$save(function(response) {
        $state.go('product.index');
        $scope.loading = false;
      });
    };

    $scope.opname = function  (){
      $scope.loading = true;
      var date = new Date();

      var production = new Production({
        tonnage: $scope.correction.tonnage - $scope.product.tonnage,
        product_id: $scope.product.id,
        description: 'Stock Opname - ' + date
      });

      $scope.product.tonnage = $scope.correction.tonnage;

      production.$save(function(response) {
        $state.go('product.index');
        $scope.loading = false;
      });
    };

    $scope.delete = function (id){
      $scope.loading = true;

      Product.delete({ id: $scope.product.id }, function(response) {
        $state.go('product.index');
      }, function(err) {
        console.log(err);
      });
    };
}]);



angular.module('product').controller('ProductModalController', function ($scope, $uibModalInstance, Product, product) {
  $scope.product = product;

  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});


angular.module('product').controller('CrtProductModalController', function ($scope, $filter, $uibModalInstance, Product ) {
  
  //$scope.initializeOrder = function(){
        $scope.product = {
          id: undefined,
          product_name: undefined,
          commercial_term: undefined,
          buyer_id: undefined,
          ready_date: undefined,
          expired_date: undefined,
          seller_id: undefined,
          volume: undefined,
          tm_min: undefined,
          tm_max: undefined,
          tm_reject: undefined,
          tm_bonus: undefined,
          im_min: undefined,
          im_max: undefined,
          im_reject: undefined,
          im_bonus: undefined,
          ash_min: undefined,
          ash_max: undefined,
          ash_reject: undefined,
          ash_bonus: undefined,
          fc_min: undefined,
          fc_max: undefined,
          fc_reject: undefined,
          fc_bonus: undefined,
          vm_min: undefined,
          vm_max: undefined,
          vm_reject: undefined,
          vm_bonus: undefined,
          ts_min: undefined,
          ts_max: undefined,
          ts_reject: undefined,
          ts_bonus: undefined,
          ncv_min: undefined,
          ncv_max: undefined,
          ncv_reject: undefined,
          ncv_bonus: undefined,
          gcv_arb_min: undefined,
          gcv_arb_max: undefined,
          gcv_arb_reject: undefined,
          gcv_arb_bonus: undefined,
          gcv_adb_min: undefined,
          gcv_adb_max: undefined,
          gcv_adb_reject: undefined,
          gcv_adb_bonus: undefined,
          hgi_min: undefined,
          hgi_max: undefined,
          hgi_reject: undefined,
          hgi_bonus: undefined,
          size_min: undefined,
          size_max: undefined,
          size_reject: undefined,
          size_bonus: undefined,
      
    };
  //};

    $scope.validationOptions = {
        rules: {
            product_name: {
                required: true
            },
            commercial_term: {
                required: true
            }
            
        },
        messages: {
            product_name: "field not be empty",
            commercial_term: "field not be empty"
    
        }
    }


  $scope.crtProduct = function (formCreateProduct) {

    if(formCreateProduct.validate()){
      var product = new Product({
          buyer_id: $scope.product.buyer_id,
          seller_id: $scope.product.seller_id,
          commercial_term: $scope.product.commercial_term,
          product_name: $scope.product.product_name,
          volume: $scope.product.volume,
          ready_date: $scope.product.ready_date,
          expired_date: $scope.product.expired_date,
          tm_min: $scope.product.tm_min,
          tm_max: $scope.product.tm_max,
          tm_reject: $scope.product.tm_reject,
          tm_bonus: $scope.product.tm_bonus,
          im_min: $scope.product.im_min,
          im_max: $scope.product.im_max,
          im_reject: $scope.product.im_reject,
          im_bonus: $scope.product.im_bonus,
          ash_min: $scope.product.ash_min,
          ash_max: $scope.product.ash_max,
          ash_reject: $scope.product.ash_reject,
          ash_bonus: $scope.product.ash_bonus,
          fc_min: $scope.product.fc_min,
          fc_max: $scope.product.fc_max,
          fc_reject: $scope.product.fc_reject,
          fc_bonus: $scope.product.fc_bonus,
          vm_min: $scope.product.vm_min,
          vm_max: $scope.product.vm_max,
          vm_reject: $scope.product.vm_reject,
          vm_bonus: $scope.product.vm_bonus,
          ts_min: $scope.product.ts_min,
          ts_max: $scope.product.ts_max,
          ts_reject: $scope.product.ts_reject,
          ts_bonus: $scope.product.ts_bonus,
          ncv_min: $scope.product.ncv_min,
          ncv_max: $scope.product.ncv_max,
          ncv_reject: $scope.product.ncv_reject,
          ncv_bonus: $scope.product.ncv_bonus,
          gcv_arb_min: $scope.product.gcv_arb_min,
          gcv_arb_max: $scope.product.gcv_arb_max,
          gcv_arb_reject: $scope.product.gcv_arb_reject,
          gcv_arb_bonus: $scope.product.gcv_arb_bonus,
          gcv_adb_min: $scope.product.gcv_adb_min,
          gcv_adb_max: $scope.product.gcv_adb_max,
          gcv_adb_reject: $scope.product.gcv_adb_reject,
          gcv_adb_bonus: $scope.product.gcv_adb_bonus,
          hgi_min: $scope.product.hgi_min,
          hgi_max: $scope.product.hgi_max,
          hgi_reject: $scope.product.hgi_reject,
          hgi_bonus: $scope.product.hgi_bonus,
          size_min: $scope.product.size_min,
          size_max: $scope.product.size_max,
          size_reject: $scope.product.size_reject,
          size_bonus: $scope.product.size_bonus,
      });

      product.$save(function(response) {
        $scope.products.push(response);
        $uibModalInstance.close('success');
        $scope.loading=false;
      });
    }   
 };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});