'use strict';

angular.module('order').controller('OrderDetailController', ['$scope', '$uibModal', '$stateParams', 'Lead', 'Order', 'Environment',
  function($scope,$uibModal,$stateParams, Lead, Order, Environment) {

    $scope.productQuality = Environment.productQuality;
    $scope.showBuy = Environment.showBuy;
    $scope.defaultCurrency = Environment.defaultCurrency;      
    $scope.init = function () {
      $scope.sell_base_currency_id = '';
      $scope.sell_deal_currency_id = '';
      $scope.buy_base_currency_id = '';
      $scope.buy_deal_currency_id = '';
      $scope.totalDealPriceBuy = 0;
      $scope.totalBasePriceBuy = 0;
      $scope.totalDealPriceSell = 0;
      $scope.totalBasePriceSell = 0;
      $scope.totalVolumeBuy = 0;
      $scope.totalVolumeSell = 0;
      $scope.totalSelfBuy = 0;
      $scope.totalSelfSell = 0;
      $scope.totalSelfAdditionalBuy = 0;
      $scope.totalSelfAdditionalSell = 0;
      $scope.calculateTotal();
      if(Environment.trx === 'sell') $scope.order.in_house = true;
    };

    $scope.calculateTotal = function(){
      var i;     

      if ($scope.order.sells){        
        for (i = 0; i < $scope.order.sells.length; i++) {
          $scope.sell_deal_currency_id = $scope.order.sells[i].pivot.deal_currency_id; 
          $scope.sell_base_currency_id = $scope.order.sells[i].pivot.base_currency_id; 
          $scope.totalDealPriceSell += $scope.order.sells[i].pivot.deal_price*$scope.order.sells[i].pivot.volume;
          $scope.totalBasePriceSell += $scope.order.sells[i].pivot.base_price*$scope.order.sells[i].pivot.volume;
          $scope.totalVolumeSell += $scope.order.sells[i].pivot.volume;
          if ($scope.order.sells[i].additional !== undefined) {
            $scope.totalSelfSell += (($scope.order.sells[i].pivot.base_price + $scope.order.sells[i].additional.freight_cost +
              $scope.order.sells[i].additional.port_to_factory) * $scope.order.sells[i].pivot.volume);
            $scope.totalSelfAdditionalSell += ($scope.order.sells[i].additional.freight_cost +
              $scope.order.sells[i].additional.port_to_factory) * $scope.order.sells[i].pivot.volume;
          }else{
            $scope.totalSelfSell += (($scope.order.sells[i].pivot.base_price) * $scope.order.sells[i].pivot.volume);
            $scope.totalSelfAdditionalSell += $scope.order.sells[i].pivot.volume;
          }
        }
      }
      if ($scope.order.buys){      
        for (i = 0; i < $scope.order.buys.length; i++) {
          $scope.buy_deal_currency_id = $scope.order.buys[i].pivot.deal_currency_id; 
          $scope.buy_base_currency_id = $scope.order.buys[i].pivot.base_currency_id; 
          $scope.totalDealPriceBuy += $scope.order.buys[i].pivot.deal_price*$scope.order.buys[i].pivot.volume;
          $scope.totalBasePriceBuy += $scope.order.buys[i].pivot.base_price*$scope.order.buys[i].pivot.volume;
          $scope.totalVolumeBuy += $scope.order.buys[i].pivot.volume;
          
          if ($scope.order.buys[i].additional !== undefined) {
            $scope.totalSelfBuy += (($scope.order.buys[i].pivot.base_price + $scope.order.buys[i].additional.freight_cost +
              $scope.order.buys[i].additional.port_to_factory) * $scope.order.buys[i].pivot.volume);
            $scope.totalSelfAdditionalBuy += ($scope.order.buys[i].additional.freight_cost +
              $scope.order.buys[i].additional.port_to_factory) * $scope.order.buys[i].pivot.volume;
          }else{
            $scope.totalSelfBuy += (($scope.order.buys[i].pivot.base_price) * $scope.order.buys[i].pivot.volume);
            $scope.totalSelfAdditionalBuy += $scope.order.buys[i].pivot.volume;
          }
        }
      }      
    };

    $scope.checkAlike = function (display){
      Lead.query({ lead_id:display.id, matching:'alike', order:true }, function(res){        
        if (display.lead_type === 'b')
          $scope.alikeBuys = res;
        else
          $scope.alikeSells = res;        
      });
    };

    $scope.removeLead = function (lead) {
      var sell_index = $scope.order.sells.indexOf(lead);
      var buy_index = $scope.order.buys.indexOf(lead);

      // delete lead in order & displayed elements
      var reconcile = function () {
        if(sell_index > -1) $scope.order.sells.splice(sell_index, 1);
        if(buy_index > -1) $scope.order.buys.splice(buy_index, 1);

        if($scope.display.sell === lead){
          delete $scope.display.sell;
          if($scope.order.sells !== null) $scope.display.sell = $scope.order.sells[0];
        }

        if($scope.display.buy === lead){
          delete $scope.display.buy;
          if($scope.order.buys !== null) $scope.display.buy = $scope.order.buys[0];
        }
      };

      if(!$scope.order.id){
        reconcile();
      } else {
        Order.update(
          { id: $scope.order.id, action: 'unstage' },
          { lead_id: lead.id },
        function (res){
          $scope.order = res;
          reconcile();
        });
      }
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
              item: $scope.display.buy,
              type: 'buy'
            };
          }
        }
      });

      modalInstance.result.then(function (negotiation) {
        $scope.loadingNego = true;
        Order.update(
          { id:$scope.order.id, action: 'stage' },
          { lead_type:'buy', lead_id:negotiation.id, negotiation:true, volume:negotiation.volume,
            base_currency_id: negotiation.base_currency_id, base_price: negotiation.base_price,
            deal_currency_id: negotiation.deal_currency_id, deal_price: negotiation.deal_price,
            exchange_rate: negotiation.exchange_rate, trading_term:negotiation.trading_term, payment_term:negotiation.payment_term,
            notes:negotiation.notes },
          function (res){
            $scope.loadingNego = false;
            $scope.order.buys = res.buys;
            negotiation.created_at = new Date();
            $scope.display.buy.pivot.negotiations.push(negotiation);
          }, function (res){
            $scope.loadingNego = false;
            alert(res.data.message + '. Try again with acceptable value!');
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
              item: $scope.display.sell,
              type: 'sell'
            };
          }
        }
      });

      modalInstance.result.then(function (negotiation) {            
        $scope.loadingNego = true;
        Order.update(
          { id:$scope.order.id, action: 'stage' },
          { lead_type:'sell', lead_id:negotiation.id, negotiation:true, volume:negotiation.volume,
            base_currency_id: negotiation.base_currency_id, base_price: negotiation.base_price,
            deal_currency_id: negotiation.deal_currency_id, deal_price: negotiation.deal_price,
            exchange_rate: negotiation.exchange_rate, trading_term:negotiation.trading_term, payment_term:negotiation.payment_term,
            notes:negotiation.notes },
          function (res){
            $scope.loadingNego = false;
            $scope.order.sells = res.sells;
            negotiation.created_at = new Date();
            $scope.display.sell.pivot.negotiations.push(negotiation);            
            $scope.display.sell.pivot = res.sells[0].pivot;
            console.log($scope.display.sell);
          }, function (res){
            $scope.loadingNego = false;
            alert(res.data.message + '. Try again with acceptable value!');
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
            if($scope.order.sells.length===0){
              return Lead.query({ lead_type: 'buy', order: true });
            }else{
              return Lead.query({ lead_type: 'buy', order: 'matching', lead_id: $scope.order.sells[0].id });
            }
          },
          lead: function () { return 'buy'; }
        }
      });

      modalInstance.result.then(function (selectedItem) {
        if(!$scope.order.buys) $scope.order.buys = [];
        $scope.checkAlike(selectedItem);


        if($scope.order.id){
          Order.update(
            { id:$scope.order.id, action: 'stage' },
            { lead_type:'buy', lead_id:selectedItem.id, volume:selectedItem.pivot.volume,
              base_currency_id: selectedItem.pivot.base_currency_id, base_price: selectedItem.pivot.base_price,
              deal_currency_id: selectedItem.pivot.deal_currency_id, deal_price: selectedItem.pivot.deal_price,
              exchange_rate: selectedItem.pivot.exchange_rate, trading_term:selectedItem.pivot.trading_term, payment_term:selectedItem.pivot.payment_term },
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
            if($scope.order.buys.length===0){
              return Lead.query({ lead_type: 'sell', order: true });
            }else{
              return Lead.query({ lead_type: 'sell', order: 'matching', lead_id: $scope.order.buys[0].id });
            }
          },
          lead: function () { return 'sell'; }
        }
      });

      modalInstance.result.then(function (selectedItem) {
        if(!$scope.order.buys) $scope.order.buys = [];
        $scope.checkAlike(selectedItem);        
        if($scope.order.id){
          Order.update(
            { id:$scope.order.id, action: 'stage' },
            { lead_type:'sell', lead_id:selectedItem.id, volume:selectedItem.pivot.volume,
              base_currency_id: selectedItem.pivot.base_currency_id, base_price: selectedItem.pivot.base_price,
              deal_currency_id: selectedItem.pivot.deal_currency_id, deal_price: selectedItem.pivot.deal_price,
              exchange_rate: selectedItem.pivot.exchange_rate, trading_term:selectedItem.pivot.trading_term, payment_term:selectedItem.pivot.payment_term },
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
    $scope.addCostModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/_add-cost.modal.html',
        controller: 'AddCostModalController',
        scope: $scope
      });

      modalInstance.result.then(function(res){
        if(!$scope.order.additional_cost) $scope.order.additional_cost = [];

        angular.extend($scope.order.additional_cost, res);
        // $scope.order.additional_cost.push(res);
        //if existing order, directly upload
        if($stateParams.id) {
          console.log(res);
          $scope.order.$update({ id:$stateParams.id },function (res) {
            $scope.order = res;
          }, function (err) {
            $scope.error = err.data.message;
          });
        }
        else {

        }
      });
    };
    $scope.totalAdditional = 0;
    $scope.total = function(){
      console.log($scope.order.additional_cost);
      var i;
      console.log($scope.order.additional_cost.length);
      for(i=0;i<$scope.order.additional_cost.length;i++){
        $scope.totalAdditional += $scope.order.additional_cost[i].cost;
      };
      console.log($scope.totalAdditional);
    };


  }
]);
