'use strict';

angular.module('order').controller('AddCostModalController', ['$uibModalInstance', '$scope', 'Order', 'Notification',
  function($uibModalInstance, $scope, Order, Notification) {
    $scope.order = new Order($scope.order);
    console.log($scope.order);

    $scope.ok = function () {
      var order = $scope.order;
      console.log($scope.order);
      
      if($scope.order.id){
        order.$update(function (res) {
          $scope.findOne();
          
          //Notification.sendNotification('request_approval', $scope.order, false, false);
          $uibModalInstance.dismiss('success');
        }, function (err) {
          $scope.error = err.data.message;
        });
      }else{
        //console.log($scope.order);
        $uibModalInstance.dismiss('success');
      }
    };

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);