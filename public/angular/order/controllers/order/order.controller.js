'use strict';

angular.module('order').controller('OrderController', ['$scope', '$stateParams', '$state', 'Order', 'Authentication', '$uibModal',
  function($scope, $stateParams, $state, Order, Authentication, $uibModal) {
    $scope.browse = {};

    $scope.$watchGroup(['browse.status', 'browse.possession'], function() { $scope.find(); });

    $scope.display = {};
    $scope.display.totalBuyPrice = 51000;
    $scope.display.totalBuyVolume = 1000;
    $scope.display.totalSellPrice = 39000;
    $scope.display.totalSellVolume = 1000;

    // Create new Article
    $scope.create = function (isValid) {
      $scope.error = null;

      // Create new Article object
      var order = new Order($scope.order);

      // Redirect after save
      order.$save(function (res) {
        $state.go('order.view', { id: res.id });

        // Clear form fields
        $scope.order = new Order();
      }, function (err) {
        $scope.error = err;
      });
    };

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

      /*var order = $scope.order;
      
      order.status = status;

      order.$update(function (res) {
        $scope.order.status = status;
        //$state.go('order.view', { orderId: res.id });
      }, function (err) {
        $scope.error = err.data.message;
      });*/
    };
    
    $scope.openReasonModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/order/_reason.modal.html',
        controller: 'OrderReasonModalController',
        scope: $scope,
      });
    };
    
    // Approve Order
    $scope.approve_reject = function (status) {
      $scope.error = null;

      Order.get({ id: $scope.order.id, action: 'approve', status : status }, function (res) {
        $scope.order = res;
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
      var docHead = document.head.outerHTML;
      var orderContent = document.getElementById('order-detail').outerHTML;
      var approvalContent = document.getElementById('order-approval').outerHTML;
      var canvas = document.getElementById("line");
      var graph = canvas.toDataURL();

      var winAttr = "location=yes, statusbar=no, menubar=no, titlebar=no, toolbar=no,dependent=no, width=865, height=600, resizable=yes, screenX=200, screenY=200, personalbar=no, scrollbars=yes";

      var newWin = window.open("", "_blank", winAttr);
      var writeDoc = newWin.document;
      writeDoc.open();
      writeDoc.writeln('<!doctype html><html>' + docHead + '<body onLoad="window.print();">' + orderContent + approvalContent + '</body></html>');
      writeDoc.getElementById('lineChart').innerHTML = '<img src="'+graph+'" />';
      writeDoc.close();
      newWin.focus();
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
        $scope.checkOrderUsers();
      });
    };
  }
]);

