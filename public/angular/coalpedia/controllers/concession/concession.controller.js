'use strict';

angular.module('coalpedia').controller('ConcessionController', ['$scope', '$stateParams', '$state', '$uibModal', 'Concession',
  function($scope, $stateParams, $state, $uibModal, Concession) {
    $scope.selected = {};

    $scope.find = function() {
      $scope.concessions = Concession.query({ q: $stateParams.keyword, type:$scope.searchType });
    };

    $scope.findOne = function(id) {
      if(id !== undefined){
        $scope.concessionId = id;
      } else {
        $scope.concessionId = $stateParams.id;
      }

      Concession.get({ id: $scope.concessionId }, function(concession){
        $scope.concession = concession;

        switch(concession.company.company_type){
          case 'c' : $scope.companyType = 'customer'; break;
          case 's' : $scope.companyType = 'supplier'; break;
          case 't' : $scope.companyType = 'supplier'; break;
          case 'v' : $scope.companyType = 'vendor'; break;
        }
      });
    };
  }
]);
