'use strict';

angular.module('order').controller('NegotiateModalController', ['$uibModalInstance', '$scope', 'Order', 'Term', 'lead',
  function($uibModalInstance, $scope, Order, Term, lead) {
    $scope.lead = lead;

    $scope.tradingTerm = Term.trading;
    $scope.paymentTerm = Term.payment;

    $scope.ok = function () {
      $uibModalInstance.close($scope.negotiation);
    };

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);