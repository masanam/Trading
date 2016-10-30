'use strict';

// Index controller
angular.module('index').controller('IndexPriceController', ['$scope', '$stateParams', '$state', 'Index',
  function ($scope, $stateParams, $state, Index) {
    $scope.find = function () {
      $scope.indexPrices = Index.query({ indexId: $stateParams.indexId, submodel: 'price' });
    };
  }
]);
