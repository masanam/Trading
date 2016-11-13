'use strict';

angular.module('notification').controller('NotificationController', ['$scope', '$stateParams', 'Order', 'Authentication', '$location', 'Notification',
	function($scope, $stateParams, Order, Authentication, $location, Notification) {
  $scope.unread_notifications = 0;
  $scope.notifications = [];
  $scope.notification = {};

  $scope.findLimitedNotificationsByUser = function() {
    Notification.findNotifications(Authentication.user.id, true, function(res){
      res.$loaded(function(res) {
        for (var i = 0; i < res.length; i++) {
          res[i].created_at = new Date(res[i].created_at);
        }
        $scope.notifications = res;
      });
    });

    Notification.findUnreadNotifications(Authentication.user.id, function(res) {
      $scope.unread_notifications = res;
    });
  };

  $scope.readNotification = function(notifId) {
    Notification.readNotification(Authentication.user.id, notifId, function(res) {
      console.log(res);
    });
  };
}]);