'use strict';

// Index controller
angular.module('index').controller('IndexTodayController', ['$scope', '$state', 'Index',
  function ($scope, $state, Index) {
    $scope.prices = {};
    $scope.prices.date = new Date();

    $scope.findPrices = function () {
      var x;
      var date = $scope.prices.date;
      $scope.prices = {
        date: date
      };

      Index.query({ action: 'single-date', date: date }, function (res){
        $scope.indexPrices = res;

        for(x = 0; x<res.length; x++) $scope.prices[res[x].id] = parseFloat(res[x].price);
      });
    };

    $scope.submit = function () {
      var prices = new Index($scope.prices);
      prices.$save({ action: 'single-date', date: $scope.prices.date }, function (res){
        console.log(res);
        //$state.go('index.list');
      }, function (err) {
        $scope.error = err.data.message;
      });
    };
  }
]);
