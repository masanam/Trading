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
      findChatByDeal: function(dealId, callback) {
        var path_chat = 'deal_chat/' + dealId;
        var ref = mainApp.database().ref(path_chat);
        var chats = $firebaseArray(ref);
        return callback(chats);
      },

      sendChat: function(dealId, message) {
        var chat = {
          'deal_id': dealId,
          'user_id': Authentication.user.id,
          'author': Authentication.user.name,
          'message': message
        };

        var key = mainApp.database().ref('deal_chat/'+dealId).push(chat).key;
      }
    };
  }
]);