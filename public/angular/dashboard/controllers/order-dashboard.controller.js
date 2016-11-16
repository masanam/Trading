'use strict';

angular.module('dashboard').controller('OrderDashboardController', ['$scope', 'Index','Order','Authentication',
  function($scope, Index, Order, Authentication) {
    $scope.Authentication = Authentication;

    //find list of order in dashboard
    $scope.find = function () {
      var possession;

      if(Authentication.user.role === 'manager') possession = 'subordinates';
      else if(Authentication.user.role === 'trader') possession = 'my';
      $scope.orders = Order.query({ possession: possession, status: 'p' });
    };

    $scope.funnel=function () {
      var order_funnel = Order.get({ action:'funnel' }, function(res){
        console.log(res);
        $scope.labels = ['Leads', 'Pending', 'Approve', 'Finalized'];
        $scope.series = ['Buy', 'Sell', 'Order'];
        $scope.data= [
          [res['lead-buy'],0,0,0],
          [res['lead-sell'],0,0,0],
          [0,res.pending,res.approve,res.finalized]
        ];
        $scope.onClick = function (point,evt) {
          console.log(point,evt);
        };
        $scope.type = 'StackedBar';
        $scope.options = {
          scales: {
            xAxes: [{
              stacked: true,
            }],
            yAxes: [{
              stacked: true
            }]
          }
        };
      });
    };
  }
]);
