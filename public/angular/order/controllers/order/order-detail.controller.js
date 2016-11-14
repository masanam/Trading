'use strict';

angular.module('order').controller('OrderDetailController', ['$scope', '$uibModal', 'Order',
  function($scope,$uibModal, Order) {
    $scope.addOwnProduct = function () {
      //compare buy and sell

      //if sell < buy, error message

      //if sell > buy, do it

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
            return Order.query({ type: 'sell' });
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
            });
        } else {
          $scope.order.sells.push(selectedItem);
          $scope.display.sell = selectedItem;
          console.log('sell');
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
            return Order.query({ type: 'buy' });
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
              console.log(res.buys);
              $scope.display.buy = selectedItem;
            });
        } else {
          $scope.order.buys.push(selectedItem);
          $scope.display.buy = selectedItem;
          console.log('buy');
        }
      }, function () {
        console.log('Modal dismissed at: ' + new Date());
      });
    };
    
  }
]);