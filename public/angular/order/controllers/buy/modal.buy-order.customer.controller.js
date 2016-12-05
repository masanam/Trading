'use strict';

angular.module('order').controller('ModalBuyOrderController', function ($scope, $stateParams, $uibModalInstance, $interval, Buyer, Order, $location) {
  
  //Options Preferred Buying Term
  $scope.data = {
    availableOptions: [
      { id: 'TT', name: 'TT' },
      { id: 'LC on Sight f', name: 'LC on Sight' },
      { id: 'LC on 30 days', name: 'LC on 30 days' },
      { id: 'other', name: 'Other' }
    ]
  };

  //show freetext payment terms
  $scope.freetext = function() {
    if($scope.buyer.preferred_payment_term === 'other'){
      $scope.buyer.preferred_payment_term = '';
      $scope.buyer.freetext = true;
    }else{
      $scope.buyer.freetext = false;
    }
  };

  //creating a customer/buyer
  $scope.create = function() {
    var buyer = new Buyer($scope.buyer);

    buyer.$save(function(res) {
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
    });
  };

  //closing modal
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});