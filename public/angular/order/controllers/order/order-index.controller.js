'use strict';

angular.module('order').controller('OrderIndexController', ['$scope', '$stateParams', '$state', 'Index',
  function($scope, $stateParams, $state, Index) {
    $scope.getIndices = function () {
      $scope.indices = Index.query({ action: 'single-date' }, function(){
        $scope.display.index = $scope.indices[$scope.indices.length-1];

        $scope.render($scope.display.index);
      });
    };

    $scope.options = [];

    $scope.render = function(index){
      $scope.display.index = index;
      $scope.series = [];
      $scope.data = [[],[],[]];
      $scope.labels = [];
      $scope.colors = ['#d64d4d','#e39e54','#4d7358'];
      $scope.datasetOverride = [
        { type:'line', tension:0, fill:false },
        { type:'line', fill:false, pointStyle:'crossRot', pointRadius:0 },
        { type:'line', fill:false, pointStyle:'crossRot', pointRadius:0 },
      ];

      var x,y,
        indexSequence = 0,
        date = new Date();

      date.setDate(date.getDate()-5);

      Index.query({ submodel:'price', indexId:$scope.display.index.id, date:date, latest:'7' },
        function (res){
          $scope.series = [ index.index_provider + ' ' + index.index_name, 'buy', 'sell' ];

          for(x = 0; x<res.length; x++){
            $scope.data[0][x] = res[x].price;  
            $scope.data[1][x] = ($scope.display.sell.min_price + $scope.order.pit_to_port + $scope.order.transhipment);
            $scope.data[2][x] = ($scope.display.buy.max_price - $scope.order.port_to_factory - $scope.order.freight_cost);
            $scope.labels[x] = res[x].date;
          }
          
          var mid = res.length/2;
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