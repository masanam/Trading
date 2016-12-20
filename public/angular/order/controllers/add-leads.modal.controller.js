'use strict';

angular.module('order').controller('AddLeadsModalController', ['$uibModalInstance', '$scope', 'Order', 'Term', 'items', 'lead',
  function($uibModalInstance, $scope, Order, Term, items, lead) {
    $scope.items = items;
    $scope.lead = lead;
    $scope.selected = {
      item: $scope.items[0]
    };

    $scope.tradingTerm = Term.trading;
    $scope.paymentTerm = Term.payment;

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
  }
]);