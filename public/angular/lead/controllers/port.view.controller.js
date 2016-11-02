'use strict';

angular.module('port').controller('ViewPortController', ['$scope', '$stateParams', '$uibModal', '$window', 'Port',
  function($scope, $stateParams, $uibModal, $window, Port) {

    $scope.findOne = function(){
      $scope.port = Port.get({ id: $stateParams.portId });
    };

    $scope.backToDetail = function(){
      $window.history.back();
    };
  }
]);