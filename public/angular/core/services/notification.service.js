'use strict';

angular.module('notification').factory('Notification', ['firebase', '$firebaseArray', 'Authentication', 'OrderUser', 
  function (firebase, $firebaseArray, Authentication, OrderUser) {
    var chats = [];
    var config = {
      apiKey: 'AIzaSyACILHAOiy4G9TtCgs0szgZBZokr4cduuo',
      authDomain: 'coal-trade.firebaseapp.com',
      databaseURL: 'https://coal-trade.firebaseio.com',
      storageBucket: 'coal-trade.appspot.com',
      messagingSenderId: '407921708335'
    };
    var mainApp = firebase.initializeApp(config, 'webApps');

    return {
      findNotificationByUser: function() {
        return 0;
      },

      findChatNotification: function(callback) {
        var order = OrderUser.query({ userId: Authentication.user.id }).success(function(callback) {
          var path_chat = 'order_chat/';
          var ref = mainApp.database().ref(path_chat);
          ref.on('child_added', function(snapshot) {
            snapshot.forEach(function(childSnapshot) {
              for(var i = 0; i < childSnapShot.length; i++) {
                for(var j = 0; j < order.length; j++) {
                  if(childSnapshot[i].key === ) {}
                }
              }
            });
          });
        });
      },

      sendNotification: function(orderId, leadsUserId, managerLeadsUserId, currentTime) {
        // sending notification
        if(action === 'new_order') {
          var manager_notification = {
            'url': 'order/' + orderId,
            'notification': 'You have an order waiting for your approval',
            'created_at': currentTime,
            'isRead': true
          };

          var leads_notification = {
            'url': 'order/' + orderId,
            'notification': 'Your leads have been used in an order',
            'created_at': currentTime,
            'isRead': true
          }

          var manager_leads_notification = {
            'url': 'order/' + orderId,
            'notification': 'Leads of your subordinate have been used in an order',
            'created_at': currentTime,
            'isRead': true
          }

          var notif_key = mainApp.database().ref('notification/' + Authentication.user.managerId).push(manager_notification).key;
          var notif_key = mainApp.database().ref('notification/' + leadsUserId).push(leads_notification).key;
          var notif_key = mainApp.database().ref('notification/' + managerLeadsUserId).push(manager_leads_notification).key;
        }
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

        var key = mainApp.database().ref('order_notification/' + Authentication.user.id).push(order_notification).key;
        return callback(key);
      }
    };
  }
]);