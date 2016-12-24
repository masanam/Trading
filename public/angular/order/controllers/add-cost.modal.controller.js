'use strict';

angular.module('order').controller('AddCostModalController', ['$uibModalInstance', '$scope', 'Company', 'Order', 'Notification',
  function($uibModalInstance, $scope, Company, Order, Notification) {
    if($scope.order.additional) $scope.additionals = $scope.order.additional;
    else $scope.additionals = [];

    $scope.additionals.push({});

    $scope.types = [
      'Insurance Cost',
      'Interest Rate',
      'Surveyor',
      'Others',
      'Pit-to-Port Cost',
      'Transhipment',
      'Freight Cost',
      'Port-to-Factory Cost',
    ];

    $scope.addNewChoice = function() {
      $scope.additionals.push({});
    };

    $scope.removeChoice = function(additional) {
      $scope.additionals.splice($scope.additionals.indexOf(additional),1);
    };

    $scope.findVendors = function(keyword) {
      Company.query({ q: keyword, type: 'v' }, function(res){
        if(res.length > 0) $scope.companies = res;
      });
    };

    $scope.ok = function () {
      $uibModalInstance.close($scope.additionals);
    };

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);