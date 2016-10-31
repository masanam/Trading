'use strict';

angular.module('chat').factory('Chat', ['firebase', '$firebaseArray', 'Authentication',
  function (firebase, $firebaseArray, Authentication) {
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
      // findChatByDeal: function(type, order_deal, callback) {
      //   if(type === 'buy') {
      //     var path_chat_buy = 'buy_deal_chat/' + order_deal.id;
      //     var ref_buy = mainApp.database().ref(path_chat_buy);
      //     var buy_chats = $firebaseArray(ref_buy);
      //     return callback(buy_chats);
      //   } else if(type === 'sell') {
      //     var path_chat_sell = 'sell_deal_chat/' + order_deal.id;
      //     var ref_sell = mainApp.database().ref(path_chat_sell);
      //     var sell_chats = $firebaseArray(ref_sell);
      //     return callback(sell_chats);
      //   }
      // },

      findChatByDeal: function(deal, callback) {
        var path_chat = 'deal_chat/' + deal.id;
        var ref = mainApp.database().ref(path_chat);
        var chats = $firebaseArray(ref);
        return callback(chats);
      },

      sendChat: function(type, order_deal, message) {
        var chat = {
          'deal_id': deal.id,
          'user_id': Authentication.user.id,
          'author': Authentication.user.name,
          'message': message
        };

        var key = mainApp.database().ref('deal_chat/'+deal.id).push(chat).key;
      }
    };
  }
]);