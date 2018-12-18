'use strict';

angular.module('dashboard').controller('DashboardModalController', ['$scope', '$uibModalInstance', '$timeout', '$interval', 'Environment', 'index', 'Index', '$filter',
  function($scope, $uibModalInstance, $timeout, $interval, Environment, index, Index, $filter) {
    $scope.index = index;
    $scope.find = function () {
      $scope.latestDates = [];
      console.log($scope.latestDates);
      $scope.indexPrices = Index.query({ indexId: $scope.index.id, submodel: 'price' }, function(response){
        console.log(response);
        for(var i = 0; i < response.length; i++){
          $scope.latestDates.push($filter('date')(response[i].date, 'dd/MM/yyyy'));
        }
      });
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
