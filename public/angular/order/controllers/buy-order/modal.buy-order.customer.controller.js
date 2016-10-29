'use strict';

angular.module('order').controller('ModalBuyOrderController', function ($scope, $stateParams, $uibModalInstance, $interval, Buyer, Order, $location) {
  
  console.log($stateParams.order_id);
  //Options Preferred Buying Term
  $scope.data = {
    availableOptions: [
      { id: 'TT', name: 'TT' },
      { id: 'LC on Sight f', name: 'LC on Sight' },
      { id: 'LC on 30 days', name: 'LC on 30 days' }
    ]
  };

  //creating a customer/buyer
  $scope.create = function() {
    $scope.loading = true;
    var buyer = new Buyer($scope.buyer);

    buyer.$save(function(res) {
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

          //go to step factory
          $scope.order = new Order({
            buyer_id: res.id,
            order_status: 1
          });

          //from existing order / back button
          if ($stateParams.order_id) {
            $scope.order.$update({ type: 'buy', id: $stateParams.order_id }, function(res) {
              $location.path('buy-order/create/factory/'+res.buyer_id+'/'+res.id);
              $uibModalInstance.close('success');
            });
          }
          //new order
          else{
            $scope.order.$save({ type: 'buy' }, function(res) {
              $location.path('buy-order/create/factory/'+res.buyer_id+'/'+res.id);
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