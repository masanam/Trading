'use strict';

angular.module('order').controller('BuyOrderModalController', function ($scope, $uibModalInstance, $filter, Buyer, Order, Product) {
  
  $scope.init = function(){
    $scope.state = 0;
    $scope.choose = undefined;
    $scope.error = undefined;
    $scope.order = {
      buyer_id: undefined,
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
      buyer_id: undefined,
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
    if (($scope.state==0)&&
      ($scope.order.buyer_id)&&
      ($scope.order.order_date)&&
      ($scope.order.deadline)&&
      ($scope.order.address)&&
      ($scope.order.latitude)&&
      ($scope.order.longitude)) 
    {
      // $scope.company_name = Buyer.get({ id: $scope.order.buyer_id });
      $scope.state = $scope.state+1;
    }

    else if (($scope.state==1)&&(($scope.choose==='available')||($scope.choose==='manual'))) 
    {
      if ($scope.order.product_name!==undefined) {
        $scope.state = $scope.state+1;
        $scope.error = undefined;
      }
      else if ($scope.order.product_name==undefined) {
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
  };

  $scope.findAllBuyers = function() {
    $scope.buyers = Buyer.query();
  };

  $scope.findAllProducts = function() {
    $scope.products = Product.query();
  };


  $scope.create = function() {
    var buy_order = new Order($scope.order);
    buy_order.order_date = $filter('date')($scope.order.order_date, 'yyyy-MM-dd');
    buy_order.deadline = $filter('date')($scope.order.deadline, 'yyyy-MM-dd');

    buy_order.$save({ type: 'buy' }, function(res) {
      $scope.buy_orders.push(res);
      $uibModalInstance.close('success');
    });
  }

  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});