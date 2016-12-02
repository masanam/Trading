'use strict';

angular.module('coalpedia').controller('CoalpediaController', ['$scope', '$stateParams', '$state', 'Coalpedia', 
  function($scope, $stateParams, $state, Coalpedia) {
    $scope.searchType = 'buyer';
    $scope.state = $state.current.name;

    $scope.search = function(searchType, keyword) {
      if(searchType) $scope.searchType = searchType;
      if(keyword) $scope.keyword = keyword;

      var state = $scope.searchType + '.list';
      $state.go(state, { keyword: $scope.keyword });
    };

    $scope.initSearch = function () {
      $scope.keyword = $stateParams.keyword;

      switch($state.current.name){
        case 'seller.list' : $scope.searchType = 'seller'; break;
        case 'vendor.list' : $scope.searchType = 'vendor'; break;
        case 'concession.list' : $scope.searchType = 'concession'; break;
        default : $scope.searchType = 'buyer';
      }
    };

    $scope.total = function () {
      $scope.total = Coalpedia.get();
    };
  }
]);
