'use strict';

angular.module('dashboard').controller('SystemDashboardController', ['Authentication', '$scope', 'User', 'Order','$location',
  function(Authentication, $scope, User, Order, $location) {
    $scope.total = {};
    
    $scope.$watch('start_date', function(res){
      $scope.init();
    });

    $scope.$watch('end_date', function(res){
      $scope.init();
    });

    $scope.downloadXls = function(){
      Order.get({ action:'csv' });
    };
    $scope.init = function (){
      console.log($scope.start_date);
      User.get({ total:true }, function (res){
        $scope.total.users = res.count;
      });

      User.get({ login:true }, function (res){
        $scope.total.logins = res.count;
      });

      Order.get({ funnel:true }, function(res){
        $scope.total.approvedOrders = res.approved;
        $scope.total.orders = res.pending + res.approved + res.finalized;
        $scope.total.leads = res['lead-buy'] + res['lead-sell'];
      });

      Order.query({ category: 'everyone', start_date: $scope.start_date, end_date: $scope.end_date }, function(res){
        console.log(res);
        
        console.log($scope.end_date);
        $scope.orders = res;
        console.log($scope.orders);
      });
    };

  }
]);