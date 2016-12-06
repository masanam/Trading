'use strict';

angular.module('coalpedia').controller('ProductModalController', ['$scope', '$uibModalInstance', '$timeout', '$interval', 'Product', 'product', 'company',
  function($scope, $uibModalInstance, $timeout, $interval, Product, product, company) {
    $scope.product = product;
    $scope.company = company;
    $scope.selected = {};

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

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
