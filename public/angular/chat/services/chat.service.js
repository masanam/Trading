'use strict';

angular.module('chat').factory('Chat', ['firebase', 'Authentication',
  function (firebase, Authentication) {
    var buy_chats = [];
    var sell_chats = [];
    var config = {
      apiKey: 'AIzaSyACILHAOiy4G9TtCgs0szgZBZokr4cduuo',
      authDomain: 'coal-trade.firebaseapp.com',
      databaseURL: 'https://coal-trade.firebaseio.com',
      storageBucket: 'coal-trade.appspot.com',
      messagingSenderId: '407921708335'
    };
    var mainApp = firebase.initializeApp(config, 'webApps');

    return {
      findChatByDeal: function(type, order_deal, callback) {
        if(type === 'buy') {
          var path_chat_buy = 'buy_deal_chat/' + order_deal.id;
          var chats_tracker_buy = mainApp.database().ref(path_chat_buy);
          chats_tracker_buy.on('child_added', function(data) {
            return callback(data.val());
          });
        } else if(type === 'sell') {
          var path_chat_sell = 'sell_deal_chat/' + order_deal.id;
          var chats_tracker_sell = mainApp.database().ref(path_chat_sell);
          chats_tracker_sell.on('child_added', function(data) {
            return callback(data.val());
          });
        }
      },

      sendChat: function(type, order_deal, message) {
        if(type === 'buy') {
          var buy_chat = {
            'buy_deal_id': order_deal.id,
            'user_id': Authentication.user.id,
            'author': Authentication.user.name,
            'message': message
          };

          var buy_key = mainApp.database().ref('buy_deal_chat/'+order_deal.id).push(buy_chat).key;
        } else if(type === 'sell') {
          var sell_chat = {
            'sell_deal_id': order_deal.id,
            'user_id': Authentication.user.id,
            'author': Authentication.user.name,
            'message': message
          };

          var sell_key = mainApp.database().ref('sell_deal_chat/'+order_deal.id).push(sell_chat).key;
        }
      }
    };
  }
]);