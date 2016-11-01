'use strict';

angular.module('chat').controller('ChatController', ['$scope', '$stateParams', 'Deal', 'OrderDeal', 'Authentication', '$location', '$stateParams', 'Chat',
	function($scope, $stateParams, Deal, OrderDeal, Authentication, $location, Chat) {
  $scope.deals = [];

  $scope.deal = {};

  // TESTING
  $scope.chat = {};
  $scope.message = '';

  $scope.initialize = function() {
    $scope.message = '';
  };

  $scope.findOneDeal = function(type, $deal) {
    $scope.deal = Deal.get({ id: $scope.deal.id });
  };

  $scope.findDealByUser = function() {
    $scope.deals = Deal.query({ action: 'user', userId: Authentication.user.id });
  };

  $scope.findChatByDeal = function(type) {
    Chat.findChatByDeal($stateParams.dealId, function(res){
      $scope.chats = res;
    });
  };

  $scope.findCurrentUser = function() {
    // $scope.user = User.get({ action: current });
    $scope.user = Authentication.user;
  };

  $scope.sendMessage = function(type) {
    var message = $scope.message;
    $scope.chat.key = Chat.sendChat($stateParams.dealId, message);
    
    $scope.initialize();
  };
}]);