'use strict';

angular.module('order').controller('OrderIndexController', ['$scope', '$stateParams', '$state', '$filter', 'Index',
  function($scope, $stateParams, $state, $filter, Index) {
    $scope.getIndices = function () {
      $scope.indices = Index.query({ action: 'single-date' }, function(){
        for(var x=0; x<$scope.indices.length; x++){
          if($scope.order.index_id === $scope.indices[x].id){
            $scope.display.index = $scope.indices[x]; continue;
          }
        }

        $scope.render($scope.display.index);
      });      
    };

    $scope.options = [];

    $scope.render = function(index){
      $scope.display.index = index;      
      if(!$scope.display.index && $scope.order.index_name){        
        // $scope.display.index = $scope.indices[0];
        $scope.display.index={};
        $scope.display.index.index_name = $scope.order.index_name;
        $scope.display.index.index_provider = $scope.order.index_provider;
        $scope.display.index.price = $scope.order.price;
        $scope.display.index.date = $scope.order.updated_at;
      }else if(!$scope.display.index){
        $scope.display.index = $scope.indices[0];
      }

      // console.log($scope.display.index);
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
      
      if(!$scope.display.index.id){
        for(var i =0; i<5; i++){
          $scope.data[0][i] = $scope.order.price;
          if($scope.display.sell){
            var sell_price = parseFloat($scope.display.sell.pivot.base_price);
            if(parseFloat($scope.order.pit_to_port)){
              sell_price += parseFloat($scope.order.pit_to_port);
            }
            if(parseFloat($scope.order.transhipment)){
              sell_price += parseFloat($scope.order.transhipment);
            }
            $scope.data[1][i] = sell_price;
          }
          if($scope.display.buy){
            var buy_price = parseFloat($scope.display.buy.pivot.base_price);
            if(parseFloat($scope.order.port_to_factory)){
              buy_price -= parseFloat($scope.order.port_to_factory);
            }
            if(parseFloat($scope.order.freight_cost)){
              buy_price -= parseFloat($scope.order.freight_cost);
            }
            $scope.data[2][i] = buy_price;
          }                  
        }
      }else{
        Index.query({ submodel:'price', indexId:$scope.display.index.id, date:date, latest:'7' },
          function (res){
            $scope.series = [ $scope.display.index.index_provider + ' ' + $scope.display.index.index_name, 'buy', 'sell' ];

            var mid = Math.round(res.length/2);            
            var i =0;
            for(x = res.length-1; x>=0; x--){
              $scope.data[0][x] = res[i].price;
              if($scope.display.sell){
                var sell_price = parseFloat($scope.display.sell.pivot.base_price);
                if(parseFloat($scope.order.pit_to_port)){
                  sell_price += parseFloat($scope.order.pit_to_port);
                }
                if(parseFloat($scope.order.transhipment)){
                  sell_price += parseFloat($scope.order.transhipment);
                }
                $scope.data[1][x] = sell_price;
              }
              if($scope.display.buy){
                var buy_price = parseFloat($scope.display.buy.pivot.base_price);
                if(parseFloat($scope.order.port_to_factory)){
                  buy_price -= parseFloat($scope.order.port_to_factory);
                }
                if(parseFloat($scope.order.freight_cost)){
                  buy_price -= parseFloat($scope.order.freight_cost);
                }
                $scope.data[2][x] = buy_price;
              }
              $scope.labels[x] = $filter('date')(res[i].date, 'd/M');
              i++;
            }
          });        
      }
    };

    $scope.saveIndex = function () {
      $scope.manual = 'false';      
      if($scope.order.index_name){
        $scope.order.index_id = undefined;          
        $scope.render();
      }else{        
        $scope.order.index_id = $scope.display.index.id;
        // $scope.render($scope.order);
      }      
      console.log($scope.order.index_id);
      $scope.update();
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
   //            $scope.singleData[index.id][indexSequence][res[x].length-y-1] = parseFloat(res[x][y].base_price);
   //          }
   //          indexSequence++;
   //        }
   //      });
   //  };
  }
]);
