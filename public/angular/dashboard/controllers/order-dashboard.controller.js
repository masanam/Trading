'use strict';

angular.module('dashboard').controller('OrderDashboardController', ['$scope', '$uibModal', '$state', '$log','Index','Order','Authentication','Environment',
  function($scope, $uibModal, $state, $log, Index, Order, Authentication, Environment) {
    $scope.Authentication = Authentication;
    $scope.showBuy = Environment.showBuy;
    
    //find list of order in dashboard
    $scope.find = function () {
      var possession;

      $scope.orders = Order.query({ possession: 'my', status: 'p' });
    };

    $scope.remove = function (order) {
      if (order) {
        var modalInstance = $uibModal.open({
          windowClass: 'xl-modal',
          templateUrl: './angular/dashboard/views/remove-confirm.modal.html',
          controller: function($scope, $uibModalInstance) {
            console.log('Modal is opened');

            $scope.ok = function () {
              $uibModalInstance.close('true');
            };

            $scope.cancel = function () {
              $uibModalInstance.dismiss('cancel');
            };
          },
          scope: $scope,
        });

        modalInstance.result.then(function(ok) {
          if(ok === 'true') {
            order.$remove();
            $scope.orders.splice($scope.orders.indexOf(order), 1);

            for (var i in $scope.indices) {
              if ($scope.indices[i] === order) {
                $scope.indices.splice(i, 1);
              }
            }
          }
        }, function() {
          $log.info('Modal dismissed at: ' + new Date());
        });
      } else {
        $scope.order.$remove(function () {
          $state.go('order.list');
        });
      }
    };

    $scope.funnel=function () {
      var order_funnel = Order.get({ funnel:true }, function(res){
        $scope.funnel=res;

        if($scope.showBuy){
          $scope.labels = ['Leads', 'Pending', 'Approve', 'Finalized'];
          $scope.series = ['Buy', 'Sell', 'Order'];
          $scope.data= [
            [res['lead-sell'],0,0,0],
            [res['lead-buy'],0,0,0],
            [0,res.pending,res.approved,res.finalized]
          ];
        } else {
          $scope.labels = ['Leads', 'Pending', 'Approve', 'Finalized'];
          $scope.series = ['Order'];
          $scope.data= [
            [res['lead-sell'],res.pending,res.approved,res.finalized]
          ];
        }


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
