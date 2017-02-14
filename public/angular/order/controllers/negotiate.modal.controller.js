'use strict';

angular.module('order').controller('NegotiateModalController', ['$uibModalInstance', '$scope', 'Order', 'Term', 'lead', 'Currency',
  function($uibModalInstance, $scope, Order, Term, lead, Currency) {
    $scope.lead = lead;    
    $scope.negotiation = angular.copy(lead.item.pivot);
    $scope.negotiation.id = $scope.lead.item.id;
    $scope.tradingTerm = Term.trading;
    $scope.paymentTerm = Term.payment;
    $scope.currencies = Currency.currencies;

    $scope.ok = function () {      
      $uibModalInstance.close($scope.negotiation);
    };

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);