'use strict';

angular.module('order').controller('OrderDetailController', ['$scope', '$uibModal', 'Order',
  function($scope,$uibModal, Order) {
    $scope.addBuy = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: '/angular/order/views/order/_add-leads.modal.html',
        controller: 'AddLeadsModalController',
        //size: 'lg',
        windowClass: 'xl-modal',
        resolve: {
          items: function () {
            return Order.query({ type: 'sell' });
          },
          lead: function () { return 'buy'; }
        }
      });

      modalInstance.result.then(function (selectedItem) {
        console.log(selectedItem);
      }, function () {
        console.log('Modal dismissed at: ' + new Date());
      });
    };

    $scope.addSell = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: '/angular/order/views/order/_add-leads.modal.html',
        controller: 'AddLeadsModalController',
        //size: 'lg',
        windowClass: 'xl-modal',
        resolve: {
          items: function () {
            return Order.query({ type: 'buy' });
          },
          lead: function () { return 'sell'; }
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