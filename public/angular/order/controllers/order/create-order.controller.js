'use strict';

angular.module('order').controller('CreateOrderController', ['$scope', '$state', '$uibModal', 'Order',
  function($scope, $state, $uibModal, Order) {
    $scope.init = function (){
      $scope.order = {};
      $scope.order.buys = [];
      $scope.order.sells = [];
      $scope.display = {};
      $scope.totalPriceBuy = 0;
      $scope.totalVolumeBuy = 0;
      $scope.totalPitBuy = 0;
      $scope.totalTranshipmentBuy = 0;
      $scope.totalFreightBuy = 0;
      $scope.totalFactoryBuy = 0;
      $scope.totalPriceSell = 0;
      $scope.totalVolumeSell = 0;
      $scope.totalPitSell = 0;
      $scope.totalTranshipmentSell = 0;
      $scope.totalFreightSell = 0;
      $scope.totalFactorySell = 0;
    };

    // Create new Article
    $scope.create = function (isValid) {
      $scope.error = null;

      // Create new Article object
      var order = new Order($scope.order);

      // Redirect after save
      order.$save(function (res) {
        $state.go('order.view', { id: res.id });

        // Clear form fields
        $scope.order = new Order();
      }, function (err) {
        $scope.error = err;
      });
    };


    $scope.addCostModalBuys = function () {

      $scope.order.additional = 'buy';
      $scope.order.index = $scope.display.sell.index;
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/order/_add-cost.modal.html',
        controller: 'AddCostModalController',
        scope: $scope,
      });

      modalInstance.result.then(function(res){
        //if existing order, directly upload
        $scope.order.sells[$scope.order.index].additional = res;
        $scope.totalPriceBuy = 0;
        $scope.totalVolumeBuy = 0;
        $scope.totalPitBuy = 0;
        $scope.totalTranshipmentBuy = 0;
        $scope.totalFreightBuy = 0;
        $scope.totalFactoryBuy = 0;
        for (var i = 0; i < $scope.order.sells.length; i++) {
          $scope.totalPriceBuy += $scope.order.sells[i].pivot.price;
          $scope.totalVolumeBuy += $scope.order.sells[i].pivot.volume;
          if ($scope.order.sells[i].additional !== undefined) {
            $scope.totalPitBuy += $scope.order.sells[i].additional.pit_to_port;
            $scope.totalTranshipmentBuy += $scope.order.sells[i].additional.transhipment;
            $scope.totalFreightBuy += $scope.order.sells[i].additional.freight_cost;
            $scope.totalFactoryBuy += $scope.order.sells[i].additional.port_to_factory;
          }
        }
      });
    };

    $scope.addCostModalSells = function () {
      $scope.order.additional = 'sell';
      $scope.order.index = $scope.display.buy.index;
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/order/_add-cost.modal.html',
        controller: 'AddCostModalController',
        scope: $scope,
      });

      modalInstance.result.then(function(res){
        //if existing order, directly upload
        $scope.order.buys[$scope.order.index].additional = res;
        $scope.totalPriceSell = 0;
        $scope.totalVolumeSell = 0;
        $scope.totalPitSell = 0;
        $scope.totalTranshipmentSell = 0;
        $scope.totalFreightSell = 0;
        $scope.totalFactorySell = 0;
        $scope.totalSelfSell = 0;
        for (var i = 0; i < $scope.order.buys.length; i++) {
          $scope.totalPriceSell += $scope.order.buys[i].pivot.price;
          $scope.totalVolumeSell += $scope.order.buys[i].pivot.volume;
          if ($scope.order.buys[i].additional !== undefined) {
            $scope.totalPitSell += $scope.order.buys[i].additional.pit_to_port;
            $scope.totalTranshipmentSell += $scope.order.buys[i].additional.transhipment;
            $scope.totalFreightSell += $scope.order.buys[i].additional.freight_cost;
            $scope.totalFactorySell += $scope.order.buys[i].additional.port_to_factory;
            $scope.totalSelfSell += (($scope.order.buys[i].pivot.price + $scope.order.buys[i].additional.freight_cost + 
              $scope.order.buys[i].additional.port_to_factory) * $scope.order.buys[i].pivot.volume);
          }
        }
        
      });
    };
  }
]);