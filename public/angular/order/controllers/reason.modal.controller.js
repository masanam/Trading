'use strict';

angular.module('order').controller('OrderReasonModalController', ['$uibModalInstance', '$scope', 'Order', 'status', 'Notification', 'Contract',
  function($uibModalInstance, $scope, Order, status, Notification, Contract) {

    $scope.status = status;
    $scope.step = 1;
    $scope.init= function(){
      $scope.order.reason = '';
      $scope.order.contracts = {};
    };

    $scope.ok = function () {
      console.log($scope.order.sells[0].laycan_end);
      if($scope.order.reason !== ''){
        $scope.step++;
      }else{
        $scope.error = 'Please enter a reason to proceed';
      }
    };

    $scope.back = function () {
      $scope.step--;
    };

    $scope.submit = function () {
      $scope.loading = true;
      if($scope.order.reason !== ''){
        var order = new Order($scope.order);
        if($scope.order.contracts) {
          var contract = new Contract({
            'contract_no': $scope.order.contracts.contract_no,
            'order_id': $scope.order.id,
            'shipment_count': $scope.order.contracts.shipment_count,
            'term': $scope.order.contracts.term,
            'term_desc': $scope.order.contracts.term_desc,
            // 'date_from': $scope.order.contracts.date_from,
            // 'date_to': $scope.order.contracts.date_to,
            'date_from': order.sells[0].laycan_start,
            'date_to': order.sells[0].laycan_start,
          });
        }

        $scope.approval = undefined;

        order.status = $scope.status;
        if($scope.status === 'x') order.cancel_reason = $scope.order.reason;
        else if($scope.status === 'f') order.finalize_reason = $scope.order.reason;
        else if($scope.status === 'p') order.request_reason = $scope.order.reason;
        else if($scope.status === 'r') order.reject_reason = $scope.order.reason;
        /*
        * hasapu 14 - 02 - 2017
        * Input reject reason for status 'r'
        */
        else if($scope.status === 'r') {
          $scope.approval = 'approval';
        }

        order.$update({ id:order.id, status:order.status, action: $scope.approval }, function (res) {
          $scope.loading = false;
          $scope.order = res;
          // if($scope.status === 'x') $scope.order.cancel_reason = $scope.reason;
          // else if($scope.status === 'f') $scope.order.finalize_reason = $scope.reason;
          // else if($scope.status === 'p') $scope.order.request_reason = $scope.reason;
          Notification.sendNotification('request_approval', $scope.order, false, false);

          /*
          * Aryo Pradipta Gema 17 - 01 - 2017 12:42 pm
          * Create contract after finishing an order
          */
          if($scope.order.status === 'f') {
            contract.$save(function(res) {
              $scope.order.contracts = res;
            }, function(err) {
              $scope.error = err.data.message;
            });
          }

          $uibModalInstance.close($scope.order);
        }, function (err) {
          $scope.error = err.data.message;
        });
      }else{
        $scope.error = 'Please enter a reason to proceed';
      }
    };

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
