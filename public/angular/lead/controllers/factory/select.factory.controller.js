'use strict';

angular.module('factory').controller('SelectFactoryController', ['$scope', '$stateParams', 'Factory',
  function($scope, $stateParams, Factory) {

    $scope.findMyFactorys = function() {
      $scope.factorys = Factory.query({ action: 'my', id: $stateParams.id }, function(factorys){
        if(factorys.length === 0){
          $scope.openModal();
        }
      });
    };
    
  }
]);
