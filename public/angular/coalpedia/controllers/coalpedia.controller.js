'use strict';

angular.module('coalpedia').controller('CoalpediaController', ['$scope', '$stateParams', '$state', 'Coalpedia', 'Environment', 
  function($scope, $stateParams, $state, Coalpedia, Environment) {
    $scope.searchType = $state.current.name === 'concession.list' ? 'concession' : $stateParams.type || 'customer';
    $scope.keyword = $stateParams.keyword;
    $scope.showBuy = Environment.showBuy;


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
