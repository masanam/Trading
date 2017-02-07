'use strict';

// Index controller
angular.module('index').controller('IndexController', ['$scope', '$stateParams', '$state', 'Index',
  function ($scope, $stateParams, $state, Index) {
    $scope.init = function() {
      $scope.index = {};
    };
    // Create new Article
    $scope.create = function (isValid) {
      $scope.error = null;

      // Create new Article object
      var index = new Index($scope.index);

      // Redirect after save
      index.$save(function (res) {
        $state.go('index.view', { indexId: res.id });

        // Clear form fields
        $scope.index = new Index();
      }, function (err) {
        $scope.error = err;
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

      index.$update(function (res) {
        $state.go('index.view', { indexId: res.id });
      }, function (err) {
        $scope.error = err.data.message;
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
