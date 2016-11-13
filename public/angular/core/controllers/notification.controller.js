'use strict';

angular.module('notification').controller('NotificationController', ['$scope', '$stateParams', 'Order', 'Authentication', '$location', 'Notification',
	function($scope, $stateParams, Order, Authentication, $location, Notification) {
  $scope.notifications = [];
  $scope.notification = {};

  $scope.findNotificationsByUser = function() {
    Notification.findNotifications(Authentication.user.id, function(res){
      res.$loaded(function(res) {
        for (var i = 0; i < res.length; i++) {
          res[i].created_at = new Date(res[i].created_at);
        }
        $scope.notifications = res;
        console.log($scope.notifications);
      });
    });
  };
}]);