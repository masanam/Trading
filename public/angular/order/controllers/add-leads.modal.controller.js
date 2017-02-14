'use strict';

angular.module('order').controller('AddLeadsModalController', ['$uibModalInstance', '$scope', 'Order', 'Term', 'items', 'lead', 'Currency', 'Environment', 'Exchange_rate',
  function($uibModalInstance, $scope, Order, Term, items, lead, Currency, Environment, Exchange_rate) {
    $scope.items = items;            
    
    // console.log(items[0].length);
    // console.log($scope.items[2]);
    $scope.defaultCurrency = Environment.defaultCurrency;    
    $scope.lead = lead;
    $scope.selected = {
      item: $scope.items[0]
    };    

    $scope.tradingTerm = Term.trading;
    $scope.paymentTerm = Term.payment;
    $scope.currencies = Currency.currencies;    

    $scope.getUsed = function(lead){
      $scope.used = 0;
      for(var i = 0; i < lead.used.length; i++){
        $scope.used += lead.used[i].volume;
      }
      return $scope.used;
    };

    $scope.ok = function () {      
      $uibModalInstance.close($scope.selected.item);
    };

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };

    $scope.findExchange_rate = function (curr) {
      if(curr === $scope.defaultCurrency) {
        $scope.selected.item.pivot.exchange_rate = 1;
        $scope.selected.item.pivot.base_price = $scope.selected.item.pivot.deal_price;
      }
      else {
        Exchange_rate.get({ buy: curr , sell: $scope.defaultCurrency }, function(res){          
          $scope.selected.item.pivot.exchange_rate = res.value;
          $scope.selected.item.pivot.base_price = $scope.selected.item.pivot.exchange_rate * $scope.selected.item.pivot.deal_price;
        });
      }
    };
  }
]);
