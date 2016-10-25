'use strict';

angular.module('port').controller('ViewPortController', ['$scope', '$stateParams', '$uibModal', '$location', 'Port',
  function($scope, $stateParams, $uibModal, $location, Port) {

    $scope.findOne = function(){
      $scope.port = Port.get({ id: $stateParams.portId });
    };

    $scope.backToDetail = function(){
      $location.path('lead/buyer/'+$stateParams.id);
    };
  }
]);