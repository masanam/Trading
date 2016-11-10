'use strict';

angular.module('notification').factory('Notification', ['firebase', '$firebaseArray', 'Authentication',
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
      findChatNotificationByUser: function(orderId) {
        var path_chat = 'order_chat/' + orderId;
        var ref = mainApp.database().ref(path_chat);
        var chat = $firebaseArray(ref);
        return callback(chats);
      }

      findOrderNotificationByUser: function(userId, callback) {
        var path_notif = 'order_notification/' + userId;
        var ref = mainApp.database().ref(path_chat);
        var chats = $firebaseArray(ref);
        return callback(chats);
      },

      sendOrderNotification: function(orderId, leadsId, managerId, associatedUserId, currentTime, callback) {
        var order_notification = {
          'order_id': orderId,
          'leads_id' : leadsId,
          'user_id': Authentication.user.id,
          'manager_id': managerId,
          'associated_leads_owner_id': associatedUserId,
          'created_at': currentTime
        };

        var key = mainApp.database().ref('order_notification/' + userId).push(order_notification).key;
        return callback(key);
      }
    };
  }
]);