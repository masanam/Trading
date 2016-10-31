'use strict';

angular.module('index').controller('DashboardController', ['$scope', '$state', '$http', 'NgMap', 'Concession', 'Buyer', 'Order', 'News', 'Authentication', 'Deal',
  function($scope, $state, $http, NgMap, Concession, Buyer, Order, News, Authentication, Deal) {
    var heatmap;
    $state.go('dashboard.main');
    $scope.Authentication = Authentication;
    $scope.showNews = 5;
    $scope.msg1 = true;
    $scope.msg2 = true;

    NgMap.getMap().then(function(map) {
      $scope.map = map;
    });

    $scope.loadConcessions = function(){
      $scope.mines = Concession.query({ option: 'detail' });
    };

    $scope.loadBuyers = function(){
      $scope.buyers = Buyer.query();
    };

    $scope.loadTodayOrder = function(){
      $scope.todayOrders = Order.query({ option: 'due-today' });
    };
    
    $scope.loadDeals = function(){
      $scope.deals = Deal.query;
    };


    $scope.loadNews = function(){
      $scope.news = News.query();
    };
    
    $scope.loadICI = function(){
      $http({
        method: 'GET',
        url: 'http://api.eia.gov/series/?api_key=6FE0A3265783D9A5E76B6FF2905FBFB7&series_id=COAL.EXPORT_PRICE.TOT-ID-TOT.Q',
        skipAuthorization: true
      }).then(function(response, err){
        $scope.ici = response.data.series[0].data;
        var labels = []; var data = [];

        for(var x=0; x<10;x++){
          labels.push($scope.ici[x][0]);
          data.push($scope.ici[x][1]);
        }

        $scope.labels = labels;
        $scope.data = [ data ];

        $scope.datasetOverride = [{ yAxisID: 'y-axis-1' }];
        $scope.options = {
          scales: {
            yAxes: [
              {
                id: 'y-axis-1',
                type: 'linear',
                display: true,
                position: 'left',
                ticks: {
                  beginAtZero:true
                }
              }
            ]
          }
        };
      });
    };

    $scope.loadSupply = function() {
      $scope.supplies = Concession.query({ option: 'detail' });
    };

    $scope.loadDemand = function() {
      $scope.orders = Order.query({ option: 'all' });
    };

    $scope.todos = ['Call Wilmar', 'Done the Jawa manis deal', 'Remind Borneo Indobara about their production rate'];
    $scope.todo = {};
    $scope.dones = [];
    $scope.addtodo = false;
    $scope.newToDo = '';
    $scope.donebtn = false;

    $scope.doneToDo = function($index, todo) {
      $scope.dones.push(todo);
      $scope.todos.splice($index, 1);
    };

    $scope.save = function() {
      $scope.dones = [];
      alert('You have modified your to do list');
    };

    $scope.cancel = function(todo) {
      for (var i = 0 ; i < $scope.dones.length; i++) {
        $scope.todos.push($scope.dones[i]);
      }
      $scope.dones = [];
    };

    $scope.createToDo = function(newToDo) {
      $scope.todos.push(newToDo);
      $scope.addtodo = false;
    };
  }
]);