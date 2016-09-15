'use strict';

angular.module('order').controller('OrderBuyerController', ['$location', '$scope', '$http', '$stateParams', '$state', 'Order', 'OrderFulfillment', 'Buyer',
  function($location, $scope, $http, $stateParams, $state, Order, OrderFulfillment, Buyer) {
    $scope.orderBuyers = [];
    $scope.orderBuyer = {};

    $scope.initialize = function() {
      $scope.orderBuyer = {
        buyer_id: '',
        contact: '',
        phone: '',

        pickup_location: '',
        latitude: '',
        longitude: '',
        
        caloric_min: '',
        caloric_max: '',
        moisture_min: '',
        moisture_max: '',
        sulphur_min: '',
        sulphur_max: '',
        ash_min: '',
        ash_max: '',

        tonnage: ''
      };
    };

    $scope.create = function() {
      $scope.loading = true;

      var orderBuyer = new Order({
        buyer_id: 1, 
        contact: $scope.orderBuyer.contact,
        phone: $scope.orderBuyer.phone,

        pickup_location: $scope.orderBuyer.pickup_location,
        latitude: $scope.orderBuyer.latitude,
        longitude: $scope.orderBuyer.longitude,
        
        caloric_min: $scope.orderBuyer.caloric_min,
        caloric_max: $scope.orderBuyer.caloric_max,
        moisture_min: $scope.orderBuyer.moisture_min,
        moisture_max: $scope.orderBuyer.moisture_max,
        sulphur_min: $scope.orderBuyer.sulphur_min,
        sulphur_max: $scope.orderBuyer.sulphur_max,
        ash_min: $scope.orderBuyer.ash_min,
        ash_max: $scope.orderBuyer.ash_max,

        tonnage: $scope.orderBuyer.tonnage
      });

      orderBuyer.$save(function(response) {
        // $state.go('order-buyer.view');
        console.log(response);
        $location.path('order-buyer/' + response.id);
        $scope.loading = false;
      });
    };

    $scope.confirmOrderFulfillment = function(trx) {
      $scope.loading =true;

      OrderFulfillment.get({ id: trx.id , action: 'confirm' }, function(response) {
        trx.status = 'f';
        $state.go('order-buyer.view');
        $scope.loading = false;
      });
    };

    $scope.cancelOrderFulfillment = function(trx) {
      $scope.loading =true;

      OrderFulfillment.get({ id: trx.id , action: 'cancel' }, function(response) {
        trx.status = 'c';
        $state.go('order-buyer.view');
        $scope.loading = false;
      });
    };

    $scope.matchedProduct = function(id) {
      $scope.loading = true;

      $scope.match = Order.query({ action: 'matching', id: id });
      $scope.loading = false;
    };

    $scope.callOrder = function(orderBuyer) {
      $scope.loading =true;

      Order.get({ id: orderBuyer.id , action: 'call' }, function(response) {
        orderBuyer.status = 'p';
        $state.go('order-buyer.index');
        $scope.loading = false;
      });
    };

    $scope.matchOrder = function(orderBuyer) {
      $scope.loading =true;

      Order.get({ id: orderBuyer.id , action: 'match' }, function(response) {
        orderBuyer.status = 'm';
        $state.go('order-buyer.index');
        $scope.loading = false;
      });
    };

    $scope.negoOrder = function(orderBuyer) {
      $scope.loading =true;

      Order.get({ id: orderBuyer.id , action: 'nego' }, function(response) {
        orderBuyer.status = 'd';
        $state.go('order-buyer.index');
        $scope.loading = false;
      });
    };

    $scope.finishOrder = function(orderBuyer) {
      $scope.loading =true;

      Order.get({ id: orderBuyer.id , action: 'finish' }, function(response) {
        orderBuyer.status = 'f';
        $state.go('order-buyer.index');
        $scope.loading = false;
      });
    };

    $scope.cancelOrder = function(orderBuyer) {
      $scope.loading =true;

      Order.get({ id: orderBuyer.id , action: 'cancel' }, function(response) {
        orderBuyer.status = 'c';
        $state.go('order-buyer.index');
        $scope.loading = false;
      });
    };

    $scope.find = function() {
      var id = $stateParams.buyerId;
      $scope.orderBuyers = Order.query({ action: 'orderLog', buyerId: id });
      if(id !== undefined){
        $scope.buyer = Buyer.get({ id: id });
      }
    };

    $scope.findUnattended = function() {
      $scope.orders = Order.query({ status: 'o', action: 'orderLog' });
    };

    $scope.findUnmatched = function() {
      $scope.orders = Order.query({ status: 'p', action: 'orderLog' });
    };

    $scope.findMatched = function() {
      $scope.orders = Order.query({ status: 'm', action: 'orderLog' });
    };

    $scope.findOne = function(id) {
      if (!id) {
        $scope.orderBuyerId = $stateParams.id;
      } else {
        $scope.orderBuyerId = id;
      }
      $scope.orderBuyer = Order.get({ id: $scope.orderBuyerId });
    };
  }
]);