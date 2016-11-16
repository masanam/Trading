'use strict';

angular.module('order').controller('OrderDetailController', ['$scope', '$uibModal', 'Order',
  function($scope,$uibModal, Order) {
    $scope.addOwnProduct = function () {
      Order.get(
        { id:$scope.order.id, action: 'stage' },
        function (res){
          $scope.order.sells = res.sells;
          $scope.display.sell = res;
        }, function (err){
          alert(err.data.message);
        });
    };

    $scope.removeBuy = function () {
      Order.get({
        id:$scope.order.id, action: 'unstage',
        buy_id:$scope.display.buy.id
      }, function (res){
        delete $scope.display.buy;
        $scope.order = res;
      });
    };

    $scope.removeSell = function () {
      Order.get({
        id:$scope.order.id, action: 'unstage',
        sell_id:$scope.display.sell.id
      }, function (res){
        delete $scope.display.sell;
        $scope.order = res;
      });
    };

    $scope.negoBuy = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: '/angular/order/views/order/_negotiate.modal.html',
        controller: 'NegotiateModalController',
        windowClass: 'xl-modal',
        resolve: {
          lead: function () {
            return {
              item: $scope.display.sell,
              type: 'sell'
            }; 
          }
        }
      });

      modalInstance.result.then(function (negotiation) {
        Order.post(
          { id:$scope.order.id, action: 'stage' },
          { sell:negotiation.id, volume:negotiation.volume, price:negotiation.price, trading_term:negotiation.trading_term, payment_term:negotiation.payment_term, notes:negotiation.notes },
          function (res){
            $scope.order.sells = res.sells;
            $scope.display.sell.pivot = negotiation;
          });
      }, function () {
        console.log('Modal dismissed at: ' + new Date());
      });
    };

    $scope.negoSell = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: '/angular/order/views/order/_negotiate.modal.html',
        controller: 'NegotiateModalController',
        windowClass: 'xl-modal',
        resolve: {
          lead: function () {
            return {
              item: $scope.display.buy,
              type: 'buy'
            }; 
          }
        }
      });

      modalInstance.result.then(function (negotiation) {
        Order.post(
          { id:$scope.order.id, action: 'stage' },
          { buy:negotiation.id, volume:negotiation.volume, price:negotiation.price, trading_term:negotiation.trading_term, payment_term:negotiation.payment_term, notes:negotiation.notes },
          function (res){
            $scope.order.buys = res.buys;
            $scope.display.buy.pivot = negotiation;
          });
      }, function () {
        console.log('Modal dismissed at: ' + new Date());
      });
    };

    $scope.addBuy = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: '/angular/order/views/order/_add-leads.modal.html',
        controller: 'AddLeadsModalController',
        windowClass: 'xl-modal',
        resolve: {
          items: function () {
            if($scope.order.buys.length===0){
              return Order.query({ type: 'sell', order: true });
            }else{
              return Order.query({ type: 'sell', order: true, order_id: $scope.order.buys[0].id });
            }
          },
          lead: function () { return 'buy'; }
        }
      });

      modalInstance.result.then(function (selectedItem) {
        if(!$scope.order.sells) $scope.order.sells = [];
        
        if($scope.order.id){
          Order.post(
            { id:$scope.order.id, action: 'stage' },
            { sell:selectedItem.id, volume:selectedItem.pivot.volume, price:selectedItem.pivot.price, trading_term:selectedItem.pivot.trading_term, payment_term:selectedItem.pivot.payment_term },
            function (res){
              $scope.order.sells = res.sells;
              $scope.display.sell = selectedItem;
              var sell_price = parseFloat($scope.display.sell.pivot.price);
              if(parseFloat($scope.order.pit_to_port)){
                sell_price += parseFloat($scope.order.pit_to_port);
              }
              if(parseFloat($scope.order.transhipment)){
                sell_price += parseFloat($scope.order.transhipment);
              }
              $scope.display.totalSellPrice = sell_price;
            });
        } else {
          $scope.order.sells.push(selectedItem);
          $scope.display.sell = selectedItem;
          var sell_price = parseFloat($scope.display.sell.pivot.price);
          if(parseFloat($scope.order.pit_to_port)){
            sell_price += parseFloat($scope.order.pit_to_port);
          }
          if(parseFloat($scope.order.transhipment)){
            sell_price += parseFloat($scope.order.transhipment);
          }
          $scope.display.totalSellPrice = sell_price;
        }
      }, function () {
        console.log('Modal dismissed at: ' + new Date());
      });
    };

    $scope.addSell = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: '/angular/order/views/order/_add-leads.modal.html',
        controller: 'AddLeadsModalController',
        windowClass: 'xl-modal',
        resolve: {
          items: function () {
            if($scope.order.sells.length===0){
              return Order.query({ type: 'buy', order: true });
            }else{
              return Order.query({ type: 'buy', order: true, order_id: $scope.order.sells[0].id });
            }
          },
          lead: function () { return 'sell'; }
        }
      });

      modalInstance.result.then(function (selectedItem) {
        if(!$scope.order.buys) $scope.order.buys = [];
        
        if($scope.order.id){
          Order.post(
            { id:$scope.order.id, action: 'stage' },
            { buy:selectedItem.id, volume:selectedItem.pivot.volume, price:selectedItem.pivot.price, trading_term:selectedItem.pivot.trading_term, payment_term:selectedItem.pivot.payment_term },
            function (res){
              $scope.order.buys = res.buys;
              $scope.display.buy = selectedItem;
              var buy_price = parseFloat($scope.display.buy.pivot.price);
              if(parseFloat($scope.order.port_to_factory)){
                buy_price -= parseFloat($scope.order.port_to_factory);
              }
              if(parseFloat($scope.order.freight_cost)){
                buy_price -= parseFloat($scope.order.freight_cost);
              }
              $scope.display.totalBuyPrice = buy_price;
            });
        } else {
          $scope.order.buys.push(selectedItem);
          $scope.display.buy = selectedItem;
          var buy_price = parseFloat($scope.display.buy.pivot.price);
          if(parseFloat($scope.order.port_to_factory)){
            buy_price -= parseFloat($scope.order.port_to_factory);
          }
          if(parseFloat($scope.order.freight_cost)){
            buy_price -= parseFloat($scope.order.freight_cost);
          }
          $scope.display.totalBuyPrice = buy_price;
        }
      }, function () {
        console.log('Modal dismissed at: ' + new Date());
      });
    };
    
  }
]);