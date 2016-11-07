'use strict';

angular.module('chat').controller('ChatController', ['$scope', '$stateParams', 'Order', 'Authentication', '$location', 'Chat',
	function($scope, $stateParams, Order, Authentication, $location, Chat) {
  $scope.deals = [];

  $scope.deal = {};

  // TESTING
  $scope.chat = {};
  $scope.message = '';

  $scope.initialize = function() {
    $scope.message = '';
  };

  $scope.findOneDeal = function(type, $deal) {
    $scope.deal = Order.get({ id: $stateParams.dealId });
  };

  $scope.findDealByUser = function() {
    $scope.deals = Order.query({ action: 'user', userId: Authentication.user.id });
  };

  $scope.findChatByDeal = function(type) {
    Chat.findChatByDeal($stateParams.dealId, function(res){
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
    $scope.chat.key = Chat.sendChat($stateParams.dealId, message, Date.now());
    
    $scope.initialize();
  };
}]);