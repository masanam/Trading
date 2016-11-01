'use strict';

angular.module('factory').controller('DetailFactoryController', ['$scope', '$stateParams', 'Factory', '$window',
  function($scope, $stateParams, Factory, $window) {

    $scope.findOne = function() {
      $scope.factoryId = $stateParams.id;
      $scope.factory = Factory.get({ id: $scope.factoryId });
    };

    $scope.goBack = function(){
      $window.history.back();
    };
    
  }
]);
