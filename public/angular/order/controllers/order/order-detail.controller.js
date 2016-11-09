'use strict';

angular.module('order').controller('OrderDetailController', ['$scope', '$uibModal',
  function($scope,$uibModal) {
    $scope.items = ['item1', 'item2', 'item3'];

    $scope.addBuy = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: '/angular/order/views/order/_add-buy.modal.html',
        controller: 'AddBuyModalController',
        size: 'lg',
        resolve: {
          items: function () {
            return $scope.items;
          }
        }
      });

      modalInstance.result.then(function (selectedItem) {
        console.log(selectedItem);
      }, function () {
        console.log('Modal dismissed at: ' + new Date());
      });
    };
  }
]);