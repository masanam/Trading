'use strict';

// Index controller
angular.module('index').controller('IndexPriceController', ['$scope', '$stateParams', '$state', 'Index',
  function ($scope, $stateParams, $state, Index) {
    $scope.find = function () {
      $scope.indexPrices = Index.query({ indexId: $stateParams.indexId, submodel: 'price' });
    };

    // Find existing Article
    $scope.findOne = function () {
      Index.get({
        indexPriceId: $stateParams.indexPriceId,
        submodel: 'price'
      }, function (res){
        $scope.indexPrice = res;
        $scope.indexPrice.date = new Date(res.date);
        $scope.indexPrice.price = parseFloat(res.price);
      });
    };

    // Update existing Article
    $scope.update = function (isValid) {
      $scope.error = null;

      var indexPrice = $scope.indexPrice;

      indexPrice.$update({ submodel: 'price', indexPriceId: indexPrice.id }, function (res) {
        $state.go('index.view', { indexId: res.index_id });
      }, function (err) {
        $scope.error = err.data.message;
      });
    };
  }
]);
