'use strict';

angular.module('dashboard').controller('IndexPriceController', ['$scope', 'Index',
  function($scope, Index) {
    $scope.dateEnd = new Date();
    $scope.dateStart = new Date();
    $scope.frequency = 'daily';

    $scope.getIndices = function () {
      $scope.indices = Index.query();
    };

    $scope.getIndexPrices = function () {
      var x,
        choosenIndex = [],
        dateStart = $scope.dateStart.toString().slice(0,10),
        dateEnd = $scope.dateEnd.toString().slice(0,10);

      for(x=0; x<$scope.indices.length; x++){
        if($scope.indices[x].choosen) choosenIndex.push($scope.indices[x].id);
      }

      $scope.indexPrices = Index.post({ action: 'price' },
        { indexId: choosenIndex, date_start: dateStart, date_end: dateEnd, frequency: $scope.frequency },
        function(res){
          console.log(res);
        });
    };

    // $scope.chooseIndex = function (index) {

    //   if(index.choosen) Index.query({ indexId: index.id, date_start: dateStart, date_end: dateEnd }, function(res){
    //     $scope.indexPrices = res;
    //     console.log(res);
    //   });
    // };

    $scope.labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
    $scope.series = ['Series A', 'Series B'];
    $scope.data = [
      [65, 59, 80, 81, 56, 55, 40],
      [28, 48, 40, 19, 86, 27, 90]
    ];
    $scope.onClick = function (points, evt) {
      console.log(points, evt);
    };
    $scope.datasetOverride = [{ yAxisID: 'y-axis-1' }, { yAxisID: 'y-axis-2' }];
    $scope.options = {
      scales: {
        yAxes: [
          {
            id: 'y-axis-1',
            type: 'linear',
            display: true,
            position: 'left'
          },
          {
            id: 'y-axis-2',
            type: 'linear',
            display: true,
            position: 'right'
          }
        ]
      }
    };
  }
]);