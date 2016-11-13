'use strict';

angular.module('notification').factory('Notification', ['Authentication', 'FirebaseService', '$firebaseArray',
  function (Authentication, FirebaseService, $firebaseArray) {
    var user_notification = {};
    var manager_notification = {};
    var leads_notification = {};
    var manager_leads_notification = {};
    var unread_notifs = [];
    var path_notif = '';
    var mainApp = FirebaseService.mainApp;

    return {
      findNotifications: function(userId, callback) {
        path_notif = 'notification/' + userId;
        var ref = mainApp.database().ref(path_notif);
        var notifs = $firebaseArray(ref);
        return callback(notifs);
      },

      findUnreadNotifications: function(userId, callback) {
        var path_unread_notif = 'notification/' + userId;
        var unread_ref = mainApp.database().ref(path_unread_notif)
              .orderByChild('isRead')
              .equalTo(false)
              .on('value', function(snapshot) {
                return callback(snapshot.numChildren());
              });
      },

      sendNotification: function(action, order, leadsUserId, managerLeadsUserId) {
        // sending notification
        if(action === 'request_approval') {
          manager_notification = {
            'url': 'order/' + order.id,
            'notification': 'ORD #' + ("10000"+order.id).slice(-4) + ' is waiting for your approval',
            'created_at': Date.now(),
            'isRead': false
          };

          mainApp.database().ref('notification/' + Authentication.user.manager_id).push(manager_notification);
        }
        if(action === 'a') {
          user_notification = {
            'url': 'order/' + order.id,
            'notification': 'ORD #' + ("10000"+order.id).slice(-4) + ' is approved',
            'created_at': Date.now(),
            'isRead': false
          };

          manager_notification = {
            'url': 'order/' + order.id,
            'notification': 'ORD #' + ("10000"+order.id).slice(-4) + ' is waiting for your approval',
            'created_at': Date.now(),
            'isRead': false
          };

          mainApp.database().ref('notification/' + order.user_id).push(user_notification);
          mainApp.database().ref('notification/' + Authentication.user.manager_id).push(manager_notification);
        }
        if(action === 'r') {
          user_notification = {
            'url': 'order/' + order.id,
            'notification': 'ORD #' + ("10000"+order.id).slice(-4) + ' is rejected',
            'created_at': Date.now(),
            'isRead': false
          };

          mainApp.database().ref('notification/' + order.user_id).push(user_notification);
        }
        if(action === 'new_order') {
          manager_notification = {
            'url': 'order/' + order.id,
            'notification': 'ORD #' + ("10000"+order.id).slice(-4) + ' is waiting for your approval',
            'created_at': Date.now(),
            'isRead': false
          };

          leads_notification = {
            'url': 'order/' + order.id,
            'notification': 'ORD #' + ("10000"+order.id).slice(-4) + ' used your leads',
            'created_at': Date.now(),
            'isRead': false
          };

          manager_leads_notification = {
            'url': 'order/' + order.id,
            'notification': 'ORD #' + ("10000"+order.id).slice(-4) + ' used your leads',
            'created_at': Date.now(),
            'isRead': false
          };

          mainApp.database().ref('notification/' + Authentication.user.managerId).push(manager_notification);
          mainApp.database().ref('notification/' + leadsUserId).push(leads_notification);
          mainApp.database().ref('notification/' + managerLeadsUserId).push(manager_leads_notification);
        }
        if(action === 'cancel_order') {
          manager_notification = {
            'url': 'order/' + order.id,
            'notification': 'ORD #' + ("10000"+order.id).slice(-4) + ' is cancelled',
            'created_at': Date.now(),
            'isRead': false
          };

          leads_notification = {
            'url': 'order/' + order.id,
            'notification': 'ORD #' + ("10000"+order.id).slice(-4) + ' is cancelled',
            'created_at': Date.now(),
            'isRead': false
          };

          manager_leads_notification = {
            'url': 'order/' + order.id,
            'notification': 'ORD #' + ("10000"+order.id).slice(-4) + ' is cancelled',
            'created_at': Date.now(),
            'isRead': false
          };

          mainApp.database().ref('notification/' + Authentication.user.managerId).push(manager_notification);
          mainApp.database().ref('notification/' + leadsUserId).push(leads_notification);
          mainApp.database().ref('notification/' + managerLeadsUserId).push(manager_leads_notification);
        }
      },

      readNotification: function(userId, notifId) {
        var path_read_notif = 'notification/' + userId;
        var read_ref = mainApp.database().ref(path_read_notif);

        var read = {
          'isRead' : true
        };
        read_ref.child(notifId).update(read);
      }
    };
  }
]);