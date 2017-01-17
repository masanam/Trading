'use strict';

angular.module('order').controller('OrderReasonModalController', ['$uibModalInstance', '$scope', 'Order', 'status', 'Notification', 'Contract',
  function($uibModalInstance, $scope, Order, status, Notification, Contract) {
    $scope.status = status;
    $scope.step = 1;

    $scope.ok = function () {
      console.log($scope.order);
      if($scope.order.reason !== ''){
        $scope.step++;
      }else{
        $scope.error = 'Please enter a reason to proceed';
      }
    };

    $scope.back = function () {
      $scope.step--;
    };

    $scope.submit = function () {
      if($scope.order.reason !== ''){
        var order = new Order($scope.order);
        var contract = new Contract({
          'contract_id': $scope.order.contracts.contract_id,
          'order_id': $scope.order.id,
          'num_ship': $scope.order.contracts.num_ship,
          'term': $scope.order.contracts.term,
          'term_desc': $scope.order.contracts.term_desc,
          'date_from': $scope.order.contracts.date_from,
          'date_to': $scope.order.contracts.date_to,
        });

        order.status = $scope.status;
        if($scope.status === 'x') order.cancel_reason = $scope.order.reason;
        else if($scope.status === 'f') order.finalize_reason = $scope.order.reason;
        else if($scope.status === 'p') order.request_reason = $scope.order.reason;
        order.$update({ id:order.id, status:order.status }, function (res) {
          $scope.order = res;
          // if($scope.status === 'x') $scope.order.cancel_reason = $scope.reason;
          // else if($scope.status === 'f') $scope.order.finalize_reason = $scope.reason;
          // else if($scope.status === 'p') $scope.order.request_reason = $scope.reason;
          Notification.sendNotification('request_approval', $scope.order, false, false);

          /*
          * Aryo Pradipta Gema 17 - 01 - 2017 12:42 pm
          * Create contract after finishing an order
          */
          contract.$save(function(res) {
            $scope.order.contracts = res;

            $uibModalInstance.close($scope.order);
          }, function(err) {
            $scope.error = err.data.message;
          });
        }, function (err) {
          $scope.error = err.data.message;
        });
      }else{
        $scope.error = 'Please enter a reason to proceed';
      }
    };

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
