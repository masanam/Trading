'use strict';

// Index controller
angular.module('index').controller('IndexTodayController', ['$scope', '$state', 'Index',
  function ($scope, $state, Index) {
    $scope.prices = {};
    $scope.frequency = {};
    $scope.prices.date = new Date();

    $scope.findPrices = function () {
      var x;
      var date = $scope.prices.date;
      $scope.prices = {
        date: date,
        value: [],
        frequency: []
      };

      Index.query({ action: 'single-date', date: date }, function (res){        
        for(x = 0; x<res.length; x++){
          $scope.prices.value[res[x].id] = parseFloat(res[x].price);
          $scope.prices.frequency[res[x].id] = res[x].frequency;
        } 
          
        $scope.successDate = res.date;
      });
    };

    $scope.findLastPrices = function () {
      var x;
      $scope.lastprices = {
        value: [],
        frequency: [],
        date: []
      };

      Index.query({ action: 'single-date' }, function (res){
        $scope.indexPrices = res;
        for(x = 0; x<res.length; x++){
          $scope.lastprices.value[res[x].id] = parseFloat(res[x].price);                    
          $scope.lastprices.frequency[res[x].id] = res[x].frequency;
          $scope.lastprices.date[res[x].id] = res[x].updated_at;
        } 
        console.log(res);
        $scope.successDate = res.date;
      });
    };    


    $scope.submit = function () {
      var prices = new Index($scope.prices);
      prices.$save({ action: 'single-date', date: $scope.prices.date }, function (res){      
        $scope.successDate = res.date;
        //$state.go('index.list');
      }, function (err) {
        $scope.error = err.data.message;
      });
    };
  }
]);
