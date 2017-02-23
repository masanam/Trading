'use strict';

angular.module('order').controller('AddCostModalController', ['$uibModalInstance', '$scope', 'Company', 'Order', 'Notification', 'Environment', 'additionals',
  function($uibModalInstance, $scope, Company, Order, Notification, Environment, additionals) {
    
    if(additionals) $scope.additionals = additionals;
    else $scope.additionals = [];
  
    $scope.additionals.push({});    
    
    $scope.defaultCurrency = Environment.defaultCurrency;
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
      var emptyAdditionals = 0;
      var i = 0;
      for(i = 0; i < $scope.additionals.length; i++){
        if($scope.additionals.label === undefined && $scope.additionals.cost === undefined) emptyAdditionals++;
      }
      if(emptyAdditionals > 0){
        $scope.error = 'Please fill the empty additional cost, or remove it to proceed.';
      }else{
        $scope.error = undefined;
        $uibModalInstance.dismiss('cancel');
      }
    };    
  }
]);
