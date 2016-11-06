'use strict';

angular.module('order').controller('BuyOrderCreateController', ['$scope', '$filter', '$location', 'Buyer', 'Order', 'Product', 'Port', 'NgMap',
  function ($scope, $filter, $location, Buyer, Order, Product, Port, NgMap) {
  
    $scope.init = function(){
      $scope.state = 0;
      $scope.choose = undefined;
      $scope.error = undefined;
      $scope.order = new Order();
      $scope.positions = [];
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

    //Port (Optional) init
    $scope.findAllPorts = function() {
      $scope.ports = Port.query();
    };

    $scope.findAllProducts = function() {
      $scope.products = Product.query();
    };

    //Selected Port attribut
    $scope.selectedPort = function(id) {
      Port.get({ id:id }, function(res){
        $scope.order.port_id = res.id;
        $scope.order.port_name = res.port_name;
        $scope.order.port_daily_rate = res.daily_discharge_rate;
        $scope.order.port_draft_height = res.draft_height;
        $scope.order.port_latitude = parseFloat(res.latitude);
        $scope.order.port_longitude = parseFloat(res.longitude);
      });
    };

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

    $scope.placeMarker = function(event) {
      if (Object.keys($scope.positions).length === 0) {
        $scope.positions.push({ latitude:event.latLng.lat(), longitude:event.latLng.lng() });
        $scope.order.latitude = parseFloat($filter('number')(event.latLng.lat(), 8), 8);
        $scope.order.longitude = parseFloat($filter('number')(event.latLng.lng(), 8), 8);
        $scope.map.panTo(event.latLng);
      }
    };

    $scope.getPositions = function(event) {
      if(Object.keys($scope.positions).length === 1){
        $scope.order.latitude = parseFloat($filter('number')(event.latLng.lat(), 8), 8);
        $scope.order.longitude = parseFloat($filter('number')(event.latLng.lng(), 8), 8);
        $scope.map.panTo(event.latLng);
      }
    };

    $scope.deleteMarker = function() {
      $scope.positions = [];
      $scope.order.latitude = null;
      $scope.order.longitude = null;
    };

  }
]);