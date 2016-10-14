'use strict';

angular.module('chat').controller('ChatController', ['$scope', 'firebase', 'SellDeal', 'BuyDeal', 'OrderDeal', 'Authentication', '$location', '$stateParams', 'BuyDealChat', 'SellDealChat',
	function($scope, firebase, SellDeal, BuyDeal, OrderDeal, Authentication, $location, $stateParams, BuyDealChat, SellDealChat) {
  $scope.buy_deal = {
    id: 1
  };
  $scope.sell_deal = {};

  // TESTING
  $scope.deal = {
    id: 1
  };

  $scope.chats = [];

  var config = {
    apiKey: 'AIzaSyACILHAOiy4G9TtCgs0szgZBZokr4cduuo',
    authDomain: 'coal-trade.firebaseapp.com',
    databaseURL: 'https://coal-trade.firebaseio.com',
    storageBucket: 'coal-trade.appspot.com',
    messagingSenderId: '407921708335'
  };
  var mainApp = firebase.initializeApp(config, 'webApps');

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
      var path_chat_buy = 'buy_deal_chat/' + $scope.buy_deal.id;
      var chats_tracker_buy = mainApp.database().ref(path_chat_buy);
      chats_tracker_buy.on('child_added', function(data) {
        console.log(data.key, data.val().message, data.val().author);
        $scope.chats.push(data.val());
        console.log($scope.chats);
      });
    } else if(type === 'sell') {
      var path_chat_sell = 'sell_deal_chat/' + $scope.sell_deal.id;
      var chats_tracker_sell = mainApp.database().ref(path_chat_sell);
      chats_tracker_sell.on('child_added', function(data) {
        console.log(data.key, data.val().message, data.val().author);
        $scope.chats.push(data.val());
      });
    }
  };

  $scope.findCurrentUser = function() {
    // $scope.user = User.get({ action: current });
    $scope.user = Authentication.user;
  };

  $scope.sendMessage = function(type) {
    if(type === 'buy') {
      $scope.chat = new BuyDealChat({
        'buy_deal_id': $scope.buy_deal.id,
        'user_id': $scope.buy_deal.user_id,
        'message': $scope.chat.message
      });
    } else if(type === 'sell') {
      $scope.chat = new SellDealChat({
        'sell_deal_id': $scope.sell_deal.id,
        'user_id': $scope.buy_deal.user_id,
        'message': $scope.chat.message
      });
    }

    $scope.chat.$save({ action: 'send' }, function(res) {
      // $scope.chats.push(res);
    });
  };
}]);