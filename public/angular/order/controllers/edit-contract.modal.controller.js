'use strict';

angular.module('order').controller('EditContractModalController', ['$uibModalInstance', '$scope', 'Order', 'status', 'Notification', 'Contract',
  function($uibModalInstance, $scope, Order, status, Notification, Contract) {
    console.log('asdasdasd');
    $scope.submit = function () {
      console.log("kontol");
      var contract = new Contract({
        'contract_no': $scope.order.contracts.contract_no,
        'term': $scope.order.contracts.term,
        'term_desc': $scope.order.contracts.term_desc
      });
      console.log($scope.order.contracts);
      contract.$update({ id: $scope.order.contracts.id }, function(res) {
        $scope.order.contracts = res;
        $scope.cancel();
      }, function(err) {
        $scope.error = err.data.message;
      });
    };

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
