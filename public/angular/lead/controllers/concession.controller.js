'use strict';

angular.module('concession').controller('ConcessionController', ['$scope', '$http', '$stateParams', '$state', 'Concession',
  function($scope, $http, $stateParams, $state, Concession) {
    $scope.concessions = [];
    $scope.concession = {};

    $scope.create = function() {
      $scope.loading = true;

      var concession = new Concession({
        concession_name: $scope.concession.concession_name,
        seller_id: $scope.concession.seller_id,
        owner: $scope.concession.owner,
        address: $scope.concession.address
      });

      concession.$save(function(response) {
        $state.go('concession.index');
        $scope.loading = false;
      });
    };

    $scope.update = function() {
      $scope.loading = true;

      $scope.concession.$update({ id: $scope.concession.id }, function(response) {
        $state.go('concession.index');
        $scope.loading = false;
      });
    };

    $scope.delete = function(concession) {
      $scope.loading = true;

      Concession.delete({ id: concession.id }, function(response) {
        $scope.concessions.splice($scope.concessions.indexOf(concession), 1);
      }, function(err) {
        console.log(err);
      });
    };

    $scope.find = function() {
      $scope.concessions = Concession.query();
    };

    $scope.findOne = function() {
      $scope.concessionId = $stateParams.id;
      $scope.concession = Concession.get({ action: 'detail', id: $scope.concessionId });
    };
  }
]);