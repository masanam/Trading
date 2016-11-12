'use strict';

angular.module('order').controller('OrderReasonModalController', ['$uibModalInstance', '$scope', 'Order', 'status', 'Notification',
  function($uibModalInstance, $scope, Order, status, Notification) {
    $scope.status = status;

    $scope.ok = function () {
      if($scope.reason !== ''){
        var order = $scope.order;
        
        order.status = $scope.status;
        if($scope.status === 'x') order.cancel_reason = $scope.reason;
        else if($scope.status === 'f') order.finalize_reason = $scope.reason;
        else if($scope.status === 'p') order.request_reason = $scope.reason;

        order.$update(function (res) {
          $scope.order.status = res.status;
          if($scope.status === 'x') $scope.order.cancel_reason = $scope.reason;
          else if($scope.status === 'f') $scope.order.finalize_reason = $scope.reason;
          else if($scope.status === 'p') $scope.order.request_reason = $scope.reason;
          Notification.sendNotification('request_approval', $scope.order, false, false);
          $uibModalInstance.dismiss('success');
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