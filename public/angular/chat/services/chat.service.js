'use strict';

angular.module('chat').factory('Chat', ['Authentication', 'FirebaseService', '$firebaseArray',
  function (Authentication, FirebaseService, $firebaseArray) {
    var sell_chats = [];
    var mainApp = FirebaseService.mainApp;

    return {
      findChatByOrder: function(orderId, callback) {
        var path_chat = 'order_chat/' + orderId;
        var ref = mainApp.database().ref(path_chat);
        var chats = $firebaseArray(ref);
        return callback(chats);
      },

      sendChat: function(orderId, userId, message) {
        // sending chat
        var chat = {
          'order_id': orderId,
          'user_id': Authentication.user.id,
          'author': Authentication.user.name,
          'message': message,
          'created_at': Date.now()
        };
        //console.log(chat);
        
        var chat_key = mainApp.database().ref('order_chat/' + orderId).push(chat).key;

        // sending notification
        var notification = {
          'url': 'order/' + orderId,
          'notification': 'You received a new message',
          'created_at': Date.now(),
          'isRead': false
        };

        for (var i = userId.length - 1; i >= 0; i--) {
          var notif_key = mainApp.database().ref('notification/' + userId[i].user_id).push(notification).key;
        }
      }
    };
  }
]);