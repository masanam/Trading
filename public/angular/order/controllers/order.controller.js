'use strict';

angular.module('order').controller('OrderController', ['$scope', '$stateParams', '$state', 'Order', 'Authentication', 'Notification', '$uibModal', 'Environment',
  function($scope, $stateParams, $state, Order, Authentication, Notification, $uibModal, Environment) {
    $scope.browse = {};
    $scope.$watchGroup(['browse.status', 'browse.category'], function() { $scope.find(); });
    $scope.display = {};

    $scope.showBuy = Environment.showBuy;
    $scope.showAutoApproval = Environment.showAutoApproval;

    // Remove existing order
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
          console.log('Modal dismissed at: ' + new Date());
        });
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
      var modalInstance = null;
      if(status === 'f') {
        modalInstance = $uibModal.open({
          windowClass: 'xl-modal',
          templateUrl: './angular/order/views/_contract-planning.modal.html',
          controller: 'OrderReasonModalController',
          scope: $scope,
          resolve: {
            status: function () { return status; },
          }
        });
        modalInstance.result.then(function (order) {
          $scope.findOne();
        });
      } else {
        modalInstance = $uibModal.open({
          windowClass: 'xl-modal',
          templateUrl: './angular/order/views/_reason.modal.html',
          controller: 'OrderReasonModalController',
          scope: $scope,
          resolve: {
            status: function () { return status; },
          }
        });
        modalInstance.result.then(function (order) {
          $scope.findOne();
        });
      }

    };

    $scope.editContract = function (status) {
      $scope.error = null;
      var modalInstance = null;
      if(status === 'f') {
        modalInstance = $uibModal.open({
          windowClass: 'xl-modal',
          templateUrl: './angular/order/views/_edit-contract-planning.modal.html',
          controller: 'EditContractModalController',
          scope: $scope,
          resolve: {
            status: function () { return status; },
          }
        });
        modalInstance.result.then(function (order) {
          $scope.findOne();
        });
      }
    };

    $scope.inHouse = function (status) {
      $scope.order.in_house = status || false;
      $scope.update(true);
    };

    $scope.openReasonModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/_reason.modal.html',
        controller: 'OrderReasonModalController',
        scope: $scope,
      });
    };

    // Approve Order
    $scope.approve_reject = function (status) {
      var modalInstance = null;
      $scope.error = null;
      $scope.loadScreen = true;
      Order.get({ id: $scope.order.id, action: 'approval', status : status }, function (res) {
        $scope.order_approval = res;
        $scope.order_approval.status = status;
        if(status === 'r') {
          modalInstance = $uibModal.open({
            windowClass: 'xl-modal',
            templateUrl: './angular/order/views/_reason.modal.html',
            controller: 'OrderReasonModalController',
            scope: $scope,
            resolve: {
              status: function () { return status; },
            }
          });
          modalInstance.result.then(function (order) {
            $scope.findOne();
          });
          $scope.approving = false;
        }
        else $scope.approving = true;
        Notification.sendNotification(status, $scope.order_approval, false, false);
        $scope.findOne();
        $scope.loadScreen = false;
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
              if($scope.order.approvals[j].pivot.status === 'a' && $scope.order.approvals[j].id === Authentication.user.id){
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

    $scope.checkSubordinates = function(user_id){
      for (var i in Authentication.subordinates){
        if (Authentication.subordinates[i].id === user_id) return true;
      }
      return false;
    };

    $scope.print = function(){
      $scope.orderCollapsed = false;
      $scope.financialCollapsed = true;
      $scope.qualityCollapsed = true;

      setTimeout(function(){
        var docHead = document.head.outerHTML;
        var orderContent = document.getElementById('order-detail').outerHTML;
        var approvalContent = document.getElementById('order-approval').outerHTML;
        var canvas = document.getElementById('line');
        var graph = canvas.toDataURL();

        var winAttr = 'location=yes, statusbar=no, menubar=no, titlebar=no, toolbar=no,dependent=no, width=865, height=600, resizable=yes, screenX=200, screenY=200, personalbar=no, scrollbars=yes';

        var newWin = window.open('', '_blank', winAttr);
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
    $scope.find = function (search) {
      $scope.orders = Order.query({ q:search, category: $scope.browse.category, status: $scope.browse.status });
    };

    // Find existing order
    $scope.findOne = function () {
      $scope.order = Order.get({
        id: $stateParams.id
      }, function(res){
        $scope.order = res;
        if(Environment.trx === 'sell') $scope.order.in_house = true;

        for(var x = 0; x < $scope.order.approvals.length; x++){
          if($scope.order.approvals[x].id === $scope.Authentication.user.id) $scope.myApproval = $scope.order.approvals[x];
        }

        $scope.checkOrderUsers();
      });
    };


    // $scope.addCostModal = function () {
    //   var modalInstance = $uibModal.open({
    //     windowClass: 'xl-modal',
    //     templateUrl: './angular/order/views/_add-cost.modal.html',
    //     controller: 'AddCostModalController',
    //     scope: $scope
    //   });

    //   modalInstance.result.then(function(res){
    //     if(!$scope.order.additional) $scope.order.additional = [];

    //     angular.extend($scope.order.additional, res);
    //     //if existing order, directly upload
    //     // $scope.order.$update(function (res) {
    //     //   $scope.order = res;
    //     // }, function (err) {
    //     //   $scope.error = err.data.message;
    //     // });
    //   });
    // };
  }
]);
