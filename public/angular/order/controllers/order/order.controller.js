'use strict';

angular.module('order').controller('OrderController', ['$scope', '$stateParams', '$state', 'Order', 'Authentication', 'Notification', '$uibModal',
  function($scope, $stateParams, $state, Order, Authentication, Notification, $uibModal) {
    $scope.browse = {};

    $scope.$watchGroup(['browse.status', 'browse.possession'], function() { $scope.find(); });

    $scope.display = {};

    // Remove existing order
    $scope.remove = function (order) {
      if (order) {
        order.$remove();

        for (var i in $scope.indices) {
          if ($scope.indices[i] === order) {
            $scope.indices.splice(i, 1);
          }
        }
      } else {
        $scope.order.$remove(function () {
          $state.go('order.list');
        });
      }
    };

    // Update existing Article
    $scope.update = function (isValid) {
      $scope.error = null;

      var order = $scope.order;

      order.$update(function (res) {
        $state.go('order.view', { orderId: res.id });
      }, function (err) {
        $scope.error = err.data.message;
      });
    };
    
    // Request for Approval, Cancel Order, Finalize
    $scope.changeStatus = function (status) {
      $scope.error = null;
      $scope.reason = '';
      
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/order/_reason.modal.html',
        controller: 'OrderReasonModalController',
        scope: $scope,
        resolve: {
          status: function () { return status; },
        }
      });
    };
    
    $scope.openReasonModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/order/_reason.modal.html',
        controller: 'OrderReasonModalController',
        scope: $scope,
      });
    };
    
    $scope.addCostModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/order/_add-cost.modal.html',
        controller: 'AddCostModalController',
        scope: $scope,
      });
    };
    
    // Approve Order
    $scope.approve_reject = function (status) {
      $scope.error = null;

      Order.get({ id: $scope.order.id, action: 'approve', status : status }, function (res) {
        $scope.order = res;
        Notification.sendNotification(status, $scope.order, false, false);
      }, function (err) {
        $scope.error = err.data.message;
      });
    };
    
    $scope.checkOrderUsers = function(){
      $scope.included = false;
      $scope.approver = false;
      $scope.approving = false;
      $scope.associated = false;
      for (var i in $scope.order.users) {
        if($scope.order.users[i].id === Authentication.user.id){
          if($scope.order.users[i].pivot.role === 'approver'){
            $scope.approver = true;
            for (var j in $scope.order.approvals) {
              if($scope.order.approvals[j].status === 'a' && $scope.order.approvals[j].user_id === Authentication.user.id){
                $scope.approving = true;
              }
            }
          }
          else if($scope.order.users[i].pivot.role === 'associated'){
            $scope.associated = true;
          }
          $scope.included = true;
        }
      }
    };
    
    $scope.print = function(){
      $scope.orderCollapsed = false;
      $scope.financialCollapsed = true;
      $scope.qualityCollapsed = true;
      
      setTimeout(function(){
        var docHead = document.head.outerHTML;
        var orderContent = document.getElementById('order-detail').outerHTML;
        var approvalContent = document.getElementById('order-approval').outerHTML;
        var canvas = document.getElementById("line");
        var graph = canvas.toDataURL();

        var winAttr = "location=yes, statusbar=no, menubar=no, titlebar=no, toolbar=no,dependent=no, width=865, height=600, resizable=yes, screenX=200, screenY=200, personalbar=no, scrollbars=yes";

        var newWin = window.open("", "_blank", winAttr);
        var writeDoc = newWin.document;
        writeDoc.open();
        writeDoc.writeln('<!doctype html><html>' + docHead + '<body>' + orderContent + approvalContent + '</body></html>');
        writeDoc.close();
        newWin.onload = function() {
          writeDoc.getElementById('lineChart').innerHTML = '<img src="'+graph+'" />';
          newWin.print();
        };
        newWin.focus();
      }, 1000);
    };

    // Find list of order
    $scope.find = function () {
      $scope.orders = Order.query({ possession: $scope.browse.possession, status: $scope.browse.status });
    };

    // Find existing order
    $scope.findOne = function () {
      $scope.order = Order.get({
        id: $stateParams.id
      }, function(res){
        $scope.order = res;
        $scope.order.others_cost = parseFloat($scope.order.others_cost) || 0;
        $scope.order.insurance_cost = parseFloat($scope.order.insurance_cost) || 0;
        $scope.order.interest_cost = parseFloat($scope.order.interest_cost) || 0;
        $scope.order.surveyor_cost = parseFloat($scope.order.surveyor_cost) || 0;
        $scope.order.port_to_factory = parseFloat($scope.order.port_to_factory) || 0;
        $scope.order.transhipment = parseFloat($scope.order.transhipment) || 0;
        $scope.order.freight_cost = parseFloat($scope.order.freight_cost) || 0;
        $scope.order.pit_to_port = parseFloat($scope.order.pit_to_port) || 0;
        $scope.checkOrderUsers();
      });
    };
  }
]);

