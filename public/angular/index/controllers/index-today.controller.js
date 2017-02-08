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
        date: date,
        value: []
      };

      Index.query({ action: 'single-date', date: date }, function (res){
        $scope.indexPrices = res;
        for(x = 0; x<res.length; x++) $scope.prices.value[res[x].id] = parseFloat(res[x].price);
        $scope.successDate = res.date;
        if (res.length === 0) Index.query({ action: 'single-date', date: date, last_price:true }, function(res){
          $scope.indexPrices = res;
          for(x = 0; x<res.length; x++) $scope.prices.value[res[x].id] = parseFloat(res[x].price);
          $scope.successDate = res.date;
        });

      });
    };

    $scope.submit = function () {
      var prices = new Index($scope.prices);
      prices.$save({ action: 'single-date', date: $scope.prices.date }, function (res){
        console.log(res);
        $scope.successDate = res.date;
        //$state.go('index.list');
      }, function (err) {
        $scope.error = err.data.message;
      });
    };
  }
]);
