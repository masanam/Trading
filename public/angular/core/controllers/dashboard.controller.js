'use strict';

angular.module('index').controller('DashboardController', ['$scope', '$state',
  function($scope, $state) {
    $state.go('dashboard.main');
  }
]);