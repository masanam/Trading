'use strict';

angular.module('coalpedia').controller('CoalpediaController', ['$scope', '$stateParams', '$state', 'Coalpedia', 
  function($scope, $stateParams, $state, Coalpedia) {
    $scope.searchType = $stateParams.type || 'customer';
    $scope.keyword = $stateParams.keyword;

    $scope.search = function(searchType, keyword) {
      if(searchType) $scope.searchType = searchType;
      if(keyword) $scope.keyword = keyword;

      if(searchType === 'concession') $state.go('concession.list', { keyword: $scope.keyword });
      else $state.go('company.list', { type:searchType, keyword: $scope.keyword });
    };

    $scope.total = function () {
      $scope.total = Coalpedia.get();
    };
  }
]);
