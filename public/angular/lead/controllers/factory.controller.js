'use strict';

angular.module('factory').controller('FactoryController', ['$scope', '$stateParams', '$location', '$uibModal', 'MultiStepForm','NgMap','$state', 'Factory',
  function($scope, $stateParams, $location, $uibModal, MultiStepForm, NgMap, $state, Factory) {
    $scope.factorys = [];
    $scope.factory = new Factory();
    $scope.new = $location.search().new;

    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/factory/modal.view.html',
        controller: 'FactoryModalController',
        scope: $scope
      });
    };

    $scope.nextToProduct = function(){
      if ($scope.factory.selected) {
        MultiStepForm.tempFactoryId = $scope.factory.selected.id;
        
        $location.path('lead/buyer/'+$stateParams.id+'/setup-product');
      }else{
        $scope.error = 'Please Select A Factory or Create New Factory';
      }
    };

    var map;
    $scope.$on('mapInitialized', function(evt, evtMap) {
      map = evtMap;
      $scope.markerMove = function(e) {
        $scope.factory.latitude = $scope.map.markers[0].getPosition().lat();
        $scope.factory.longitude = $scope.map.markers[0].getPosition().lng();
      };
    });

  }
]);
