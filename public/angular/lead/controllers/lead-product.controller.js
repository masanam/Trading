'use strict';

angular.module('lead').controller('LeadProductController', ['$scope', '$stateParams', '$uibModal', 'Product', 'Lead',
  function ($scope, $stateParams, $uibModal, Product, Lead) {
    //Init select products
    $scope.find = function(keyword) {
      Product.query({ q: keyword }, function(res){
        if(res.length > 0) $scope.products = res;
      });
    };

    $scope.add = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/coalpedia/views/product/_create.modal.view.html',
        controller: 'ProductModalController',
        windowClass: 'xl-modal',
        resolve: {
          product: new Product(),
          company: $scope.lead.company
        }
      });

      modalInstance.result.then(function (res) {
        $scope.selected.product = res;
      });
    };
  }
]);