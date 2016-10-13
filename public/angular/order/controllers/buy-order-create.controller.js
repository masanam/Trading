'use strict';

angular.module('order').controller('BuyOrderCreateController', ['$scope', '$filter',  'Buyer', 'Order', 'Product',
  function ($scope, $filter, Buyer, Order, Product) {
  
  $scope.init = function(){
    $scope.state = 0;
    $scope.choose = undefined;
    $scope.error = undefined;
    $scope.order = new Order();
  };

  $scope.next = function () {
      $scope.state = $scope.state+1;
    if (($scope.state==0)&&
      ($scope.order.buyer_id)&&
      ($scope.order.order_date)&&
      ($scope.order.order_deadline)&&
      ($scope.order.address)&&
      ($scope.order.latitude)&&
      ($scope.order.longitude)) 
    {
      $scope.order.order_date = $filter('date')($scope.order.order_date, 'yyyy-MM-dd');
      $scope.order.order_date = $filter('date')($scope.order.order_deadline, 'yyyy-MM-dd');
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

    else if (($scope.state==2)&&($scope.order.volume)&&($scope.order.max_price)) 
    {
      $scope.state = $scope.state+1;
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
    $scope.order.gcv_arb_min = product.gcv_arb_min;
    $scope.order.gcv_arb_max = product.gcv_arb_max;
    $scope.order.gcv_adb_min = product.gcv_adb_min;
    $scope.order.gcv_adb_max = product.gcv_adb_max;
    $scope.order.ncv_min = product.ncv_min;
    $scope.order.ncv_max = product.ncv_max;
    $scope.order.ash_min = parseFloat(product.ash_min, 10);
    $scope.order.ash_max = parseFloat(product.ash_max, 10);
    $scope.order.ts_min = parseFloat(product.ts_min, 10);
    $scope.order.ts_max = parseFloat(product.ts_max, 10);
    $scope.order.tm_min = parseFloat(product.tm_min, 10);
    $scope.order.tm_max = parseFloat(product.tm_max, 10);
    $scope.order.im_min = parseFloat(product.im_min, 10);
    $scope.order.im_max = parseFloat(product.im_max, 10);
    $scope.order.fc_min = parseFloat(product.fc_min, 10);
    $scope.order.fc_max = parseFloat(product.fc_max, 10);
    $scope.order.vm_min = parseFloat(product.vm_min, 10);
    $scope.order.vm_max = parseFloat(product.vm_max, 10);
    $scope.order.hgi_min = product.hgi_min;
    $scope.order.hgi_max = product.hgi_max;
    $scope.order.size_min = product.size_min;
    $scope.order.size_max = product.size_max;
  };

  $scope.findAllBuyers = function() {
    $scope.buyers = Buyer.query();
  };

  $scope.findAllProducts = function() {
    $scope.products = Product.query();
  };

  // $scope.findAllPorts = function() {
  //   $scope.ports = Port.query();
  // };

  $scope.create = function() {
    
    console.log($scope.order);
    var buy_order = new Order({
        buyer_id: $scope.order.buyer_id, 
        order_date: $filter('date')($scope.order.order_date, 'yyyy-MM-dd'),
        order_deadline: $filter('date')($scope.order.order_deadline, 'yyyy-MM-dd'),
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
        max_price: $scope.order.max_price,

        port_id: $scope.order.port_id
      });

      $scope.order.$save({ type: 'buy' }, function(res) {
        console.log(res);
        $scope.buy_orders.push(res);
        $uibModalInstance.close('success');
      });
  }


}]);