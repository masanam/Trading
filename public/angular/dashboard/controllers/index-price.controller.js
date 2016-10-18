'use strict';

angular.module('dashboard').controller('IndexPriceController', ['$scope', 'Index',
  function($scope, Index) {
    $scope.dateEnd = new Date();
    $scope.dateStart = new Date();
    $scope.frequency = 'daily';

    $scope.labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
    $scope.reviewLabels = [];
    
    $scope.month = new Array();
    $scope.month[0] = "January";
    $scope.month[1] = "February";
    $scope.month[2] = "March";
    $scope.month[3] = "April";
    $scope.month[4] = "May";
    $scope.month[5] = "June";
    $scope.month[6] = "July";
    $scope.month[7] = "August";
    $scope.month[8] = "September";
    $scope.month[9] = "October";
    $scope.month[10] = "November";
    $scope.month[11] = "December";

    $scope.series = ['Series A', 'Series B'];
    $scope.data = [
      [65, 59, 80, 81, 56, 55, 40],
      [28, 48, 40, 19, 86, 27, 90]
    ];
    $scope.datasetOverride = [{ yAxisID: 'y-axis-1' }, { yAxisID: 'y-axis-2' }];
    $scope.options = {
      scales: {
        yAxes: [
          {
            id: 'y-axis-1',
            type: 'linear',
            display: true,
            fill: false,
            position: 'left'
          },
          {
            id: 'y-axis-2',
            type: 'linear',
            display: true,
            fill: false,
            position: 'right'
          }
        ]
      }
    };


    $scope.getIndices = function () {
      $scope.indices = Index.query();
    };

    $scope.getIndexPrices = function () {
      var x, y,
        indexSequence = 0,
        dateStart = $scope.dateStart,
        dateEnd = $scope.dateEnd;

      var choosenIndex = [],
        indexSeries = [];
      $scope.showChart = false;

      for(x=0; x<$scope.indices.length; x++){
        if($scope.indices[x].choosen) choosenIndex.push($scope.indices[x].id);
      }

      Index.post({ action: 'price' },
        { indexId: choosenIndex, date_start: dateStart, date_end: dateEnd, frequency: $scope.frequency },
        function(res){
          //console.log(res.indices);
          $scope.headerPrices = res.indices;
          $scope.indexPrices = res.prices;
          $scope.series = [];
          $scope.labels = [];
          $scope.data = [];
          $scope.singleData = [];
          $scope.singleSeries = [];

          for(x=$scope.headerPrices.length-1; x>=0; x--){
            $scope.series.push($scope.headerPrices[x].index_provider + ' ' + $scope.headerPrices[x].index_name);
          }

          //transpose series
          for(x=$scope.indexPrices.length-1; x>=0; x--){
            var formattedDate = $scope.month[new Date().getMonth()];
            $scope.labels.push($scope.indexPrices[x].date);

            for(y in $scope.indexPrices[x]){
              if(y !== 'date'){
                if(indexSeries[y] === undefined) indexSeries[y] = indexSequence++;
                if($scope.data[indexSeries[y]] === undefined) $scope.data[indexSeries[y]] = [];
                $scope.data[indexSeries[y]][x] = parseFloat($scope.indexPrices[x][y]);
              }
            }
          }

          $scope.showChart = true;
        });
    };

    $scope.getSingleIndex = function (index) {
      var x, y,
        indexSequence = 0,
        dateStart = $scope.dateStart,
        dateEnd = $scope.dateEnd;

      Index.post({ action: 'single-price' },
        { indexId: index.id, date_start: dateStart, date_end: dateEnd, frequency: $scope.frequency },
        function(res){
          res = JSON.parse(JSON.stringify(res));
          if(!$scope.singleData[index.id]) $scope.singleData[index.id] = [];
          if(!$scope.singleSeries[index.id]) $scope.singleSeries[index.id] = [];

          $scope.singleSeries[index.id] = Object.keys(res);

          for(x in res){
            if(!$scope.singleData[index.id][indexSequence]) $scope.singleData[index.id][indexSequence] = [];
            for(y=0; y<res[x].length; y++){
              $scope.singleData[index.id][indexSequence].push(parseFloat(res[x][y].price));
            }
            indexSequence++;
            console.log(res[x]);
          }
        });
    };
  }
]);