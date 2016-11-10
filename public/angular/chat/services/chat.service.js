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
      findChatByDeal: function(orderId, callback) {
        var path_chat = 'order_chat/' + orderId;
        var ref = mainApp.database().ref(path_chat);
        var chats = $firebaseArray(ref);
        return callback(chats);
      },

      sendChat: function(orderId, message, currentTime) {
        var chat = {
          'order_id': orderId,
          'user_id': Authentication.user.id,
          'author': Authentication.user.name,
          'message': message,
          'created_at': currentTime
        };

        var key = mainApp.database().ref('order_chat/'+orderId).push(chat).key;
      }
    };
  }
]);