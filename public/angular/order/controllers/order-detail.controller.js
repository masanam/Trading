'use strict';

angular.module('order').controller('OrderDetailController', ['$scope', '$uibModal', 'Order',
  function($scope,$uibModal, Order) {

    $scope.init = function () {
      $scope.totalPriceBuy = 0;
      $scope.totalVolumeBuy = 0;
      $scope.totalSelfBuy = 0;
      $scope.totalSelfAdditionalBuy = 0;
      $scope.totalPriceSell = 0;
      $scope.totalVolumeSell = 0;
      $scope.totalSelfSell = 0;
      $scope.totalSelfAdditionalSell = 0;
      $scope.calculateTotal();
    };

    $scope.calculateTotal = function(){
      var i;

      for (i = 0; i < $scope.order.sells.length; i++) {
        $scope.totalPriceBuy += $scope.order.sells[i].pivot.price;
        $scope.totalVolumeBuy += $scope.order.sells[i].pivot.volume;
        if ($scope.order.sells[i].additional !== undefined) {
          $scope.totalSelfBuy += (($scope.order.sells[i].pivot.price + $scope.order.sells[i].additional.freight_cost + 
            $scope.order.sells[i].additional.port_to_factory) * $scope.order.sells[i].pivot.volume);
          $scope.totalSelfAdditionalBuy += ($scope.order.sells[i].additional.freight_cost + 
            $scope.order.sells[i].additional.port_to_factory) * $scope.order.sells[i].pivot.volume;
        }else{
          $scope.totalSelfBuy += (($scope.order.sells[i].pivot.price) * $scope.order.sells[i].pivot.volume);
          $scope.totalSelfAdditionalBuy += $scope.order.sells[i].pivot.volume;
        }
      }
      for (i = 0; i < $scope.order.buys.length; i++) {
        $scope.totalPriceSell += $scope.order.buys[i].pivot.price;
        $scope.totalVolumeSell += $scope.order.buys[i].pivot.volume;
        if ($scope.order.buys[i].additional !== undefined) {
          $scope.totalSelfSell += (($scope.order.buys[i].pivot.price + $scope.order.buys[i].additional.freight_cost + 
            $scope.order.buys[i].additional.port_to_factory) * $scope.order.buys[i].pivot.volume);
          $scope.totalSelfAdditionalSell += ($scope.order.buys[i].additional.freight_cost + 
            $scope.order.buys[i].additional.port_to_factory) * $scope.order.buys[i].pivot.volume;
        }else{
          $scope.totalSelfSell += (($scope.order.buys[i].pivot.price) * $scope.order.buys[i].pivot.volume);
          $scope.totalSelfAdditionalSell += $scope.order.buys[i].pivot.volume;
        }
      }
    };
    
    $scope.addOwnProduct = function () {
      Order.get({ 
        id : $scope.order.id, 
        action : 'stage' 
      },
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
        id : $scope.order.id, action: 'unstage',
        sell_id : $scope.display.sell.id
      }, function (res){
        delete $scope.display.sell;
        $scope.order = res;
      });
    };
    
    $scope.removeSellFront = function () {
      $scope.order.sells.splice($scope.display.sell, 1);
      delete $scope.display.sell;
    };
    
    $scope.removeBuyFront = function () {
      $scope.order.buys.splice($scope.display.buy, 1);
      delete $scope.display.buy;
    };

    $scope.negoBuy = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: '/angular/order/views/_negotiate.modal.html',
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
        templateUrl: '/angular/order/views/_negotiate.modal.html',
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
        templateUrl: '/angular/order/views/_add-leads.modal.html',
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
              $scope.display.sell.index = $scope.order.sells.length-1;
              $scope.calculateTotal();
            });
        } else {
          $scope.order.sells.push(selectedItem);
          $scope.display.sell = selectedItem;
          $scope.display.sell.index = $scope.order.sells.length-1;
          $scope.calculateTotal();
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
        templateUrl: '/angular/order/views/_add-leads.modal.html',
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
              $scope.display.buy.index = $scope.order.buys.length-1;
              $scope.calculateTotal();
            });
        } else {
          $scope.order.buys.push(selectedItem);
          $scope.display.buy = selectedItem;
          $scope.display.buy.index = $scope.order.buys.length-1;
          $scope.calculateTotal();
        }
      }, function () {
        console.log('Modal dismissed at: ' + new Date());
      });
    };

    $scope.addCostModalBuys = function () {

      $scope.order.additional = 'buy';
      $scope.order.index = $scope.display.sell.index;
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/_add-cost.modal.html',
        controller: 'AddCostModalController',
        scope: $scope,
      });

      modalInstance.result.then(function(res){
        //if existing order, directly upload
        $scope.order.sells[$scope.order.index].additional = res;
        $scope.totalPriceBuy = 0;
        $scope.totalVolumeBuy = 0;
        $scope.totalSelfBuy = 0;
        $scope.totalSelfAdditionalBuy = 0;
        for (var i = 0; i < $scope.order.sells.length; i++) {
          $scope.totalPriceBuy += $scope.order.sells[i].pivot.price;
          $scope.totalVolumeBuy += $scope.order.sells[i].pivot.volume;
          if ($scope.order.sells[i].additional !== undefined) {
            $scope.totalSelfBuy += (($scope.order.sells[i].pivot.price + $scope.order.sells[i].additional.freight_cost + 
              $scope.order.sells[i].additional.port_to_factory) * $scope.order.sells[i].pivot.volume);
            $scope.totalSelfAdditionalBuy += ($scope.order.sells[i].additional.freight_cost + 
              $scope.order.sells[i].additional.port_to_factory) * $scope.order.sells[i].pivot.volume;
          }
        }
      });
    };

    $scope.addCostModalSells = function () {
      $scope.order.additional = 'sell';
      $scope.order.index = $scope.display.buy.index;
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/_add-cost.modal.html',
        controller: 'AddCostModalController',
        scope: $scope,
      });

      modalInstance.result.then(function(res){
        //if existing order, directly upload
        $scope.order.buys[$scope.order.index].additional = res;
        $scope.totalPriceSell = 0;
        $scope.totalVolumeSell = 0;
        $scope.totalSelfSell = 0;
        $scope.totalSelfAdditionalSell = 0;
        for (var i = 0; i < $scope.order.buys.length; i++) {
          $scope.totalPriceSell += $scope.order.buys[i].pivot.price;
          $scope.totalVolumeSell += $scope.order.buys[i].pivot.volume;
          if ($scope.order.buys[i].additional !== undefined) {
            $scope.totalSelfSell += (($scope.order.buys[i].pivot.price + $scope.order.buys[i].additional.freight_cost + 
              $scope.order.buys[i].additional.port_to_factory) * $scope.order.buys[i].pivot.volume);
            $scope.totalSelfAdditionalSell += ($scope.order.buys[i].additional.freight_cost + 
              $scope.order.buys[i].additional.port_to_factory) * $scope.order.buys[i].pivot.volume;
          }
        }
        
      });
    };

    // $scope.totalPriceBuy = function(){
    //   var total = 0;
    //   for (var i = 0; i < $scope.order.sells.length; i++) {
    //     total = total + $scope.order.sells[i].pivot.price;
    //   }
    //   return total;
    // };

    // $scope.totalPitBuy = function(){
    //   var total = 0;
    //   for (var i = 0; i < $scope.order.sells.length; i++) {
    //     if ($scope.order.sells[i].additional !== undefined) {
    //       total = total + $scope.order.sells[i].additional.pit_to_port;
    //     }
    //   }
    //   return total;
    // };

    // $scope.totalTranshipmentBuy = function(){
    //   var total = 0;
    //   for (var i = 0; i < $scope.order.sells.length; i++) {
    //     if ($scope.order.sells[i].additional !== undefined) {
    //       total = total + $scope.order.sells[i].additional.transhipment;
    //     }
    //   }
    //   return total;
    // };

    // $scope.totalVolumeBuy = function(){
    //   var total = 0;
    //   for (var i = 0; i < $scope.order.sells.length; i++) {
    //     total = total + $scope.order.sells[i].pivot.volume;
    //   }
    //   return total;
    // };

    // $scope.totalPriceSell = function(){
    //   var total = 0;
    //   for (var i = 0; i < $scope.order.buys.length; i++) {
    //     total = total + $scope.order.buys[i].pivot.price;
    //   }
    //   return total;
    // };

    // $scope.totalPitSell = function(){
    //   var total = 0;
    //   for (var i = 0; i < $scope.order.buys.length; i++) {
    //     if ($scope.order.buys[i].additional !== undefined) {
    //       total = total + $scope.order.buys[i].additional.pit_to_port;
    //     }
    //   }
    //   return total;
    // };

    // $scope.totalTranshipmentSell = function(){
    //   var total = 0;
    //   for (var i = 0; i < $scope.order.buys.length; i++) {
    //     if ($scope.order.buys[i].additional !== undefined) {
    //       total = total + $scope.order.buys[i].additional.transhipment;
    //     }
    //   }
    //   return total;
    // };

  }
]);