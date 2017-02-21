'use strict';

angular.module('coalpedia').controller('ProductController', ['$scope', '$stateParams', '$state', '$uibModal', 'Product',
  function($scope, $stateParams, $state, $uibModal, Product) {
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
          company: $scope.company,
          createNew: false
        }
      });

      modalInstance.result.then(function (res) {
        if(!$scope.company.products) $scope.company.products = [];

        $scope.company.products.push(res);
      });
    };

    $scope.edit = function (product) {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/coalpedia/views/product/_update.modal.view.html',
        controller: 'ProductModalController',
        windowClass: 'xl-modal',
        resolve: {
          product: Product.get({ id: product.id }),
          company: $scope.company,
          createNew: false
        }
      });

      modalInstance.result.then(function (res) {
        if(!$scope.company.products) $scope.company.products = [];
        $scope.company.products.splice($scope.company.products.indexOf(product), 1, res);
      });
    };

    $scope.delete = function (product) {
      if(confirm('Are you sure you want to delete ' + product.product_name + '?')){
        product = new Product(product);
        product.$remove(function (res){
          $scope.company.products.splice($scope.company.products.indexOf(product), 1);
        });
      }
    };

    $scope.findOne = function(id) {
      Product.get({ id: $stateParams.id }, function(res){
        $scope.product = res;

        switch(res.company.company_type){
          case 'c' : $scope.companyType = 'customer'; break;
          case 's' : $scope.companyType = 'supplier'; break;
          case 't' : $scope.companyType = 'supplier'; break;
          case 'v' : $scope.companyType = 'vendor'; break;
        }
      });
    };
  }
]);
