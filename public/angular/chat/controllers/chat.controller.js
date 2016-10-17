'use strict';

angular.module('chat').controller('ChatController', ['$scope', 'firebase', 'SellDeal', 'BuyDeal', 'OrderDeal', 'Authentication', '$location', '$stateParams', 'Chat',
	function($scope, firebase, SellDeal, BuyDeal, OrderDeal, Authentication, $location, $stateParams, Chat) {
  $scope.buy_deal = {
    id: 1
  };
  $scope.sell_deal = {};

  // TESTING
  $scope.deal = {
    id: 1
  };

  $scope.chats = [];

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
      $scope.chats.push(Chat.findChatByDeal('buy', $scope.buy_deal));
    } else if(type === 'sell') {
      $scope.chats.push(Chat.findChatByDeal('sell', $scope.sell_deal));
    }
  };

  $scope.findCurrentUser = function() {
    // $scope.user = User.get({ action: current });
    $scope.user = Authentication.user;
  };

  $scope.sendMessage = function(type) {
    if(type === 'buy') {
      var message = $scope.message;
      $scope.chats.push(Chat.sendChat('buy', $scope.buy_deal, message));
    } else if(type === 'sell') {
      var message = $scope.message;
      $scope.chats.push(Chat.sendChat('sell', $scope.sell_deal, message));
    }
  };
}]);