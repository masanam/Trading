'use strict';

angular.module('coalpedia').controller('ProductModalController', ['$scope', '$uibModalInstance', '$timeout', '$interval', 'Product', 'product', 'company',
  function($scope, $uibModalInstance, $timeout, $interval, Product, product, company) {
    $scope.product = product;
    $scope.company = company;
    $scope.selected = {};

    $scope.find = function (keyword) {
      Product.query({ q: keyword }, function(res){
        if(res.length > 0) $scope.products = res;
      });
    };

    $scope.create = function() {
      var product = new Product($scope.product);
      product.company_id = company.id;

      product.$save(function(response) {
        $uibModalInstance.close(response);
      });
    };

    $scope.update = function() {
      $scope.product = new Product($scope.product);
      $scope.product.company_id = company.id;

      $scope.product.$update(function(response) {
        product = response;
        $uibModalInstance.close(response);
      });
    };

    $scope.attach = function (product) {
      Company.get({ id: company.id, action: 'attach', product_id: $scope.selected.product.id }, function(response){
        $uibModalInstance.close(response.product);
      });
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
