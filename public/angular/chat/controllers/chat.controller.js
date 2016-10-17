'use strict';

angular.module('chat').controller('ChatController', ['$scope', 'SellDeal', 'BuyDeal', 'OrderDeal', 'Authentication', '$location', '$stateParams', 'Chat',
	function($scope, SellDeal, BuyDeal, OrderDeal, Authentication, $location, $stateParams, Chat) {
  $scope.buy_deal = {
    id: 1,
  };
  $scope.sell_deal = {};

  // TESTING
  $scope.deal = {};
  $scope.chat = {};
  $scope.message = '';

  $scope.chats = [];

  $scope.initialize = function() {
    $scope.message = '';
  }

  $scope.findOneOrderDeal = function(type, $orderId) {
    if (type === 'buy') {
      $scope.buy_deal = BuyDeal.get({ action: 'getOneByDealAndOrder' , orderId: $orderId , dealId: $scope.deal.id });
    } else if (type === 'sell') {
      $scope.sell_deal = SellDeal.get({ action: 'getOneByDealAndOrder' , orderId: $orderId , dealId: $scope.deal.id });
    }
  };

  $scope.findOrderDealByUser = function() {
    $scope.order_deal = OrderDeal.query({ entity: 'user', userId: Authentication.user.id });
  };

  $scope.findChatByDeal = function(type) {
    if(type === 'buy') {
      $scope.chats = Chat.findChatByDeal('buy', $scope.buy_deal);
      console.log($scope.chats);
    } else if(type === 'sell') {
      $scope.chats = Chat.findChatByDeal('sell', $scope.sell_deal);
    }
  };

  $scope.findCurrentUser = function() {
    // $scope.user = User.get({ action: current });
    $scope.user = Authentication.user;
  };

  $scope.sendMessage = function(type) {
    if(type === 'buy') {
      var buy_message = $scope.message;
      $scope.chat.key = Chat.sendChat('buy', $scope.buy_deal, buy_message);
    } else if(type === 'sell') {
      var sell_message = $scope.message;
      $scope.chat.key = Chat.sendChat('sell', $scope.sell_deal, sell_message);
    }
    $scope.initialize();
  };
}]);