'use strict';

angular.module('order').controller('ModalSellOrderController', function ($scope, $stateParams, $uibModalInstance, $interval, Seller, Order, $location) {
  
  //Options Preferred Selling Term
  $scope.data = {
    availableOptions: [
      { id: 'TT', name: 'TT' },
      { id: 'LC on Sight f', name: 'LC on Sight' },
      { id: 'LC on 30 days', name: 'LC on 30 days' }
    ]
  };

  //creating a supplier/seller
  $scope.create = function() {
    $scope.loading = true;
    var seller = new Seller($scope.seller);

    seller.$save(function(res) {
      $scope.success = true;
      $scope.progress = 0;
      var stop = $interval(function() {
        //make loading from 0 to 100 %
        if ($scope.progress >= 0 && $scope.progress < 100) {
          $scope.progress++;
        } else {
          //after loading is 100 stop ++
          $interval.cancel(stop);
          stop = undefined;

          //go to step concession
          $scope.order = new Order({
            seller_id: res.id,
            order_status: 1
          });

          //go to step concession from existing order / back button
          if ($stateParams.order_id) {
            $scope.order.$update({ type: 'sell', id: $stateParams.order_id }, function(res) {
              $location.path('sell-order/create/concession/'+res.seller_id+'/'+res.id);
              $uibModalInstance.close('success');
            });
          }
          //go to step concession new order
          else{
            $scope.order.$save({ type: 'sell' }, function(res) {
              $location.path('sell-order/create/concession/'+res.seller_id+'/'+res.id);
              $uibModalInstance.close('success');
            });
          }
        }
      }, 75);
    });
  };

  //closing modal
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});