'use strict';

angular.module('notification').controller('NotificationController', ['$scope', '$state','$stateParams', 'Order', 'Authentication', '$location', 'Notification',
	function($scope, $state, $stateParams, Order, Authentication, $location, Notification) {
  $scope.unread_notifications = 0;
  $scope.notifications = [];
  $scope.notification = {};

  $scope.findNotificationsByUser = function() {
    Notification.findNotifications(Authentication.user.id, function(res){
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
  $scope.detail =function(a){
    var id_notif = a.split('order/');
    id_notif = id_notif[1];
    $state.go('order.view', { id : id_notif });
  };


}]);