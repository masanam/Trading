'use strict';

angular.module('chat').controller('ChatController', ['$scope', '$stateParams', 'Order', 'Authentication', '$location', 'Chat',
	function($scope, $stateParams, Order, Authentication, $location, Chat) {
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

  $scope.findCurrentUser = function() {
    // $scope.user = User.get({ action: current });
    $scope.user = Authentication.user;
  };

  $scope.sendMessage = function(type) {
    var message = $scope.message;
    $scope.chat.key = Chat.sendChat($stateParams.id, message, Date.now());
    
    $scope.initialize();
  };
}]);