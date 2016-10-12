'use strict';

angular.module('order').controller('SellOrderModalController', function ($scope, $uibModalInstance, $filter, Seller, Order, Product) {
  
  $scope.init = function(){
    $scope.state = 0;
    $scope.choose = undefined;
    $scope.order = {
      seller_id: undefined,
      order_date: undefined,
      deadline: undefined,
      penalty: undefined,
      address: undefined,
      latitude: undefined,
      longitude: undefined,
      product_name: undefined,
      product_id: undefined,
      volume: undefined,
      gcv_arb_min: undefined,
      gcv_arb_max: undefined,
      gcv_adb_min: undefined,
      gcv_adb_max: undefined,
      ncv_min: undefined,
      ncv_max: undefined,
      ash_min: undefined,
      ash_max: undefined,
      ts_min: undefined,
      ts_max: undefined,
      tm_min: undefined,
      tm_max: undefined,
      im_min: undefined,
      im_max: undefined,
      fc_min: undefined,
      fc_max: undefined,
      vm_min: undefined,
      vm_max: undefined,
      hgi_min: undefined,
      hgi_max: undefined,
      size_min: undefined,
      size_max: undefined
    };
  };

  $scope.reset = function() {
    $scope.state = 0;
    $scope.choose = undefined;
    $scope.order = {
      seller_id: undefined,
      order_date: undefined,
      deadline: undefined,
      penalty: undefined,
      address: undefined,
      latitude: undefined,
      longitude: undefined,
      product_name: undefined,
      product_id: undefined,
      volume: undefined,
      max_price: undefined,
      gcv_arb_min: undefined,
      gcv_arb_max: undefined,
      gcv_adb_min: undefined,
      gcv_adb_max: undefined,
      ncv_min: undefined,
      ncv_max: undefined,
      ash_min: undefined,
      ash_max: undefined,
      ts_min: undefined,
      ts_max: undefined,
      tm_min: undefined,
      tm_max: undefined,
      im_min: undefined,
      im_max: undefined,
      fc_min: undefined,
      fc_max: undefined,
      vm_min: undefined,
      vm_max: undefined,
      hgi_min: undefined,
      hgi_max: undefined,
      size_min: undefined,
      size_max: undefined
    };
  };

  $scope.next = function () {
    if (($scope.state===0)&&
      ($scope.order.seller_id)&&
      ($scope.order.order_date)&&
      ($scope.order.deadline)&&
      ($scope.order.address)&&
      ($scope.order.latitude)&&
      ($scope.order.longitude)) 
      // if ($scope.state===0)
    {
      $scope.company_name = Seller.get({ id: $scope.order.seller_id });
      $scope.state = $scope.state+1;
    }

    else if (($scope.state===1)&&(($scope.choose==='available')||($scope.choose==='manual'))) 
    {
      if ($scope.order.product_name!==undefined) {
        $scope.state = $scope.state+1;
        $scope.error = undefined;
      }
      else if ($scope.order.product_name===undefined) {
        $scope.error = 'Harap pilih product / isi product name';
      }
    }

  };

  $scope.back = function () {
    $scope.state = $scope.state-1;
  };

  $scope.setChoose = function(choose) {
    $scope.choose = choose;
    $scope.order.product_id = undefined;
    $scope.order.product_name = undefined;
  };

  $scope.setSelected = function(product) {
    $scope.order.product_name = product.product_name;
    $scope.order.product_id = product.id;
    console.log($scope.order.product_name);
  };

  $scope.findAllSellers = function() {
    $scope.sellers = Seller.query();
  };

  $scope.findAllProducts = function() {
    $scope.products = Product.query();
  };


  $scope.create = function() {
    var sell_order = new Order({
      seller_id: $scope.order.seller_id, 
      order_date: $filter('date')($scope.order.order_date, 'yyyy-MM-dd'),
      deadline: $filter('date')($scope.order.deadline, 'yyyy-MM-dd'),
      address: $scope.order.address,
      latitude: $scope.order.latitude,
      longitude: $scope.order.longitude,
      penalty_desc: $scope.order.penalty,
      product_name: $scope.order.product_name,
      product_id: $scope.order.product_id,

      tm_min: $scope.order.tm_min,
      tm_max: $scope.order.tm_max,
      im_min: $scope.order.im_min,
      im_max: $scope.order.im_max,
      ash_min: $scope.order.ash_min,
      ash_max: $scope.order.ash_max,
      fc_min: $scope.order.fc_min,
      fc_max: $scope.order.fc_max,
      vm_min: $scope.order.vm_min,
      vm_max: $scope.order.vm_max,
      ts_min: $scope.order.ts_min,
      ts_max: $scope.order.ts_max,
      ncv_min: $scope.order.ncv_min,
      ncv_max: $scope.order.ncv_max,
      gcv_arb_min: $scope.order.gcv_arb_min,
      gcv_arb_max: $scope.order.gcv_arb_max,
      gcv_adb_min: $scope.order.gcv_adb_min,
      gcv_adb_max: $scope.order.gcv_adb_max,
      hgi_min: $scope.order.hgi_min,
      hgi_max: $scope.order.hgi_max,
      size_min: $scope.order.size_min,
      size_max: $scope.order.size_max,

      volume: $scope.order.volume,
      max_price: $scope.order.max_price
    });

    sell_order.$save({ type: 'sell' }, function(res) {
      $scope.sell_orders.push(res);
      $uibModalInstance.close('success');
    });
  };

  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});
