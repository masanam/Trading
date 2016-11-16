'use strict';

angular.module('order').controller('AddCostModalController', ['$uibModalInstance', '$scope', 'Order', 'Notification',
  function($uibModalInstance, $scope, Order, Notification) {
    $scope.order = new Order($scope.order);

    $scope.ok = function () {
      var order = $scope.order;

      order.$update(function (res) {
        $scope.findOne();
        
        //Notification.sendNotification('request_approval', $scope.order, false, false);
        $uibModalInstance.dismiss('success');
      }, function (err) {
        console.log(err);
        $scope.error = err.data.message;
      });
    };

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);