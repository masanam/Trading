'use strict';

angular.module('chat').controller('ChatController', ['$scope', '$stateParams', 'Order', 'OrderUser', 'Authentication', '$location', 'Chat',
	function($scope, $stateParams, Order, OrderUser, Authentication, $location, Chat) {
  $scope.orders = [];

  $scope.order = {};

  // TESTING
  $scope.chat = {};
  $scope.message = '';

  $scope.initialize = function() {
    $scope.message = '';
  };

  $scope.findOneOrder = function($order) {
    $scope.order = Order.get({ id: $stateParams.id });
  };

  $scope.findOrderByUser = function() {
    $scope.orders = Order.query({ action: 'user', userId: Authentication.user.id });
  };

  $scope.findChatByOrder = function() {
    Chat.findChatByOrder($stateParams.id, function(res){
      res.$loaded(function(res) {
        for (var i = 0; i < res.length; i++) {
          res[i].created_at = new Date(res[i].created_at);
        }
        $scope.chats = res;
      });
    });
  };

  $scope.findRelatedUsers = function() {
    // $scope.user = User.get({ action: current });
    $scope.user = Authentication.user;
    $scope.relatedUsers = OrderUser.query({ orderId: $stateParams.id }, function() {
      for (var i = $scope.relatedUsers.length - 1; i >= 0; i--) {
        if($scope.relatedUsers[i].user_id === Authentication.user.id) {
          $scope.relatedUsers.splice(i, 1);
        }
      }
      //console.log($scope.relatedUsers);
    });
  };

  $scope.sendMessage = function() {
    var message = $scope.message;
    if(message !== ''){
      $scope.chat.key = Chat.sendChat($stateParams.id, $scope.relatedUsers, message);
      
      $scope.initialize();
    }
  };
}]);