'use strict';

angular.module('notification').controller('NotificationController', ['$scope', '$stateParams', 'Order', 'Authentication', '$location', 'Notification',
	function($scope, $stateParams, Order, Authentication, $location, Notification) {
  $scope.notifications = [];
  $scope.notification = {};

  $scope.findCurrentUserOrder = function() {
    // $scope.user = User.get({ action: current });
    $scope.orders = Order.query(Authentication.user.id);
  };

  $scope.findNotificationByDeal = function() {
    Notification.findNotificationByUser(Authentication.user.id, function(res){
      res.$loaded(function(res) {
        for (var i = 0; i < res.length; i++) {
          res[i].created_at = new Date(res[i].created_at);
        }
        $scope.notifications = res;
      });
    });
  };

  $scope.sendOrderLeadNotification = function() {
    $scope.notification.key = Notification.sendOrderLeadNotification(Authentication.user.id, Date.now());
  };

  $scope.sendApprovalRejectNotification = function() {
    $scope.notification.key = Notification.sendApprovalRejectNotification(Authentication.user.id, Date.now());
  };
}]);