'use strict';

angular.module('chat').factory('Chat', [
  function () {
    var config = {
      apiKey: 'AIzaSyACILHAOiy4G9TtCgs0szgZBZokr4cduuo',
      authDomain: 'coal-trade.firebaseapp.com',
      databaseURL: 'https://coal-trade.firebaseio.com',
      storageBucket: 'coal-trade.appspot.com',
      messagingSenderId: '407921708335'
    };
    var mainApp = firebase.initializeApp(config, 'webApps');
    
    return {
      findChatByDeal: function(type, order_deal) {
        if(type === 'buy') {
          var path_chat_buy = 'buy_deal_chat/' + order_deal.id;
          var chats_tracker_buy = mainApp.database().ref(path_chat_buy);
          chats_tracker_buy.on('child_added', function(data) {
            return data.val();
          });
        } else if(type === 'sell') {
          var path_chat_sell = 'sell_deal_chat/' + order_deal.id;
          var chats_tracker_sell = mainApp.database().ref(path_chat_sell);
          chats_tracker_sell.on('child_added', function(data) {
            return data.val();
          });
        }
      }

      sendChat: function(type, order_deal, message) {
        if(type === 'buy') {
          var chat = {
            'buy_deal_id': order_deal.id,
            'user_id': order_deal.user_id,
            'author': Authentication.user.name,
            'message': message
          };

          mainApp.database().ref('buy_deal_chat/'+order_deal.id).push(chat);
        } else if(type === 'sell') {
          var chat = {
            'sell_deal_id': order_deal.id,
            'user_id': order_deal.user_id,
            'author': Authentication.user.name,
            'message': message
          };

          mainApp.database().ref('sell_deal_chat/'+order_deal.id).push(chat);
        }
      };
    }
  };
]);