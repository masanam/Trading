'use strict';

angular.module('order').controller('AddLeadsModalController', ['$uibModalInstance', '$scope', 'Order', 'Term', 'items', 'lead', 'Currency',
  function($uibModalInstance, $scope, Order, Term, items, lead, Currency) {
    $scope.items = items;
    console.log($scope.items);
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
      console.log($scope.selected.item);
      $uibModalInstance.close($scope.selected.item);
    };

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
