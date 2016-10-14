'use strict';

angular.module('order').controller('BuyOrderCreateController', ['$scope', '$filter', '$location', 'Buyer', 'Order', 'Product', 'NgMap',
  function ($scope, $filter, $location, Buyer, Order, Product, NgMap) {
  
    $scope.init = function(){
      $scope.state = 0;
      $scope.choose = undefined;
      $scope.error = undefined;
      $scope.order = new Order();
    };

    $scope.next = function () {
      if (($scope.state===0)&&
        ($scope.order.buyer_id)&&
        ($scope.order.order_date)&&
        ($scope.order.order_deadline)&&
        ($scope.order.address)&&
        ($scope.order.latitude)&&
        ($scope.order.longitude)) 
      {
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
      $scope.order.order_date = $filter('date')($scope.order.order_date, 'yyyy-MM-dd');
      $scope.order.order_deadline = $filter('date')($scope.order.order_deadline, 'yyyy-MM-dd');
      $scope.order.ready_date = $filter('date')($scope.order.ready_date, 'yyyy-MM-dd');
      $scope.order.expired_date = $filter('date')($scope.order.expired_date, 'yyyy-MM-dd');
      $scope.order.$save({ type: 'buy' }, function(res) {
        $location.path('buy-order'); 
      });
    };

    NgMap.getMap().then(function(map) {
      $scope.map = map;
    });

    $scope.placeMarker = function(e) {
      // if(!$scope.marker){
      //   $scope.marker = new google.maps.Marker({ position: e.latLng, map: $scope.map, draggable: true });
      //   $scope.map.panTo(e.latLng);
      // }
    };
  }
]);