'use strict';

angular.module('order').controller('OrderIndexController', ['$scope', '$stateParams', '$state', 'Index',
  function($scope, $stateParams, $state, Index) {
    $scope.getIndices = function () {
      $scope.indices = Index.query({ action: 'single-date' }, function(){
      	$scope.display.index = $scope.indices[$scope.indices.length-1];
      });
    };

  	// $scope.getSingleIndex = function (index) {
   //    var x, y,
   //      indexSequence = 0,
   //      dateStart = new Date(),
   //      dateEnd = new Date('-5 days');

   //    Index.post({ action: 'single-price' },
   //      { indexId: index.id, date_start: dateStart, date_end: dateEnd, frequency: $scope.frequency },
   //      function(res){
   //        res = JSON.parse(JSON.stringify(res));
   //        if(!$scope.singleData[index.id]) $scope.singleData[index.id] = [];
   //        if(!$scope.singleSeries[index.id]) $scope.singleSeries[index.id] = [];

   //        $scope.singleSeries[index.id] = Object.keys(res);

   //        for(x in res){
   //          if(!$scope.singleData[index.id][indexSequence]) $scope.singleData[index.id][indexSequence] = [];
   //          for(y=0; y<res[x].length; y++){
   //            $scope.singleData[index.id][indexSequence][res[x].length-y-1] = parseFloat(res[x][y].price);
   //          }
   //          indexSequence++;
   //        }
   //      });
   //  };
  }
]);