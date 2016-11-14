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

    $scope.$on('windowFocus', function(){
      console.log('focus');
    });

    $scope.$on('windowBlur', function(){
      console.log('blur');
    });

    $scope.ok = function () {
      $uibModalInstance.close($scope.selected.item);
    };

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);