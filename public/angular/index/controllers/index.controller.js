'use strict';

// Index controller
angular.module('index').controller('IndexController', ['$scope', '$stateParams', '$state', 'Index',
  function ($scope, $stateParams, $state, Index) {
    // Create new Article
    $scope.create = function (isValid) {
      $scope.error = null;

      // Create new Article object
      var index = new Index($scope.index);

      // Redirect after save
      index.$save(function (response) {
        $state.go('index.view', { indexId: response.id });

        // Clear form fields
        $scope.index = new Index();
      }, function (errorResponse) {
        $scope.error = errorResponse;
      });
    };

    // Remove existing Article
    $scope.remove = function (index) {
      if (index) {
        index.$remove();

        for (var i in $scope.indices) {
          if ($scope.indices[i] === index) {
            $scope.indices.splice(i, 1);
          }
        }
      } else {
        $scope.index.$remove(function () {
          $state.go('index.list');
        });
      }
    };

    // Update existing Article
    $scope.update = function (isValid) {
      $scope.error = null;

      var index = $scope.index;

      index.$update(function (response) {
        $state.go('index.view', { indexId: response.id });
      }, function (errorResponse) {
        $scope.error = errorResponse.data.message;
      });
    };

    // Find a list of Index
    $scope.find = function () {
      $scope.indices = Index.query();
    };

    // Find existing Article
    $scope.findOne = function () {
      $scope.index = Index.get({
        indexId: $stateParams.indexId
      });
    };
  }
]);
