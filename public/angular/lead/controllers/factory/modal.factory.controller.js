'use strict';

angular.module('factory').controller('FactoryModalController',
  function($scope, $stateParams, $uibModalInstance, $location, $interval, Factory, NgMap, MultiStepForm) {

    $scope.init = function () {
      $scope.factory = new Factory();
    };
    
    var map;
    $scope.$on('mapInitialized', function(evt, evtMap) {
      map = evtMap;
      $scope.markerMove = function(e) {
        $scope.factory.latitude = e.latLng.lat();
        $scope.factory.longitude = e.latLng.lng();
      };
    });

    $scope.create = function(){
      $scope.factory.buyer_id = $stateParams.id;
      
      $scope.factory.$save(function (res) {
        $scope.progress = 0;
        $scope.success = true;
        var stop = $interval(function() {
          if ($scope.progress >= 0 && $scope.progress < 100) {
            $scope.progress++;
          } else {
            $interval.cancel(stop);
            stop = undefined;
            $location.path('lead/buyer/'+$stateParams.id+'/setup-product').search({ new: $scope.new });
            $uibModalInstance.close('success');
          }
        }, 75);
      }, function (res) {
        $uibModalInstance.dismiss('cancel');
        $scope.error = res.data.message;
      });
      
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
    
  }
);
