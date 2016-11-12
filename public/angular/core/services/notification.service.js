'use strict';

angular.module('notification').factory('Notification', ['Authentication', 'FirebaseService',
  function (Authentication, FirebaseService) {
    var user_notification = {};
    var manager_notification = {};
    var leads_notification = {};
    var manager_leads_notification = {};
    var mainApp = FirebaseService.mainApp;

    return {
      sendNotification: function(action, order, leadsUserId, managerLeadsUserId) {
        // sending notification
        if(action === 'request_approval') {
          manager_notification = {
            'url': 'order/' + order.id,
            'notification': 'You have an order waiting for your approval',
            'created_at': Date.now(),
            'isRead': true
          };

          mainApp.database().ref('notification/' + Authentication.user.manager_id).push(manager_notification);
        }
        if(action === 'a') {
          user_notification = {
            'url': 'order/' + order.id,
            'notification': 'Your order has been approved',
            'created_at': Date.now(),
            'isRead': true
          };

          manager_notification = {
            'url': 'order/' + order.id,
            'notification': 'You have an order waiting for your approval',
            'created_at': Date.now(),
            'isRead': true
          };

          mainApp.database().ref('notification/' + order.user_id).push(user_notification);
          mainApp.database().ref('notification/' + Authentication.user.manager_id).push(manager_notification);
        }
        if(action === 'r') {
          user_notification = {
            'url': 'order/' + order.id,
            'notification': 'Your order has been rejected',
            'created_at': Date.now(),
            'isRead': true
          };

          mainApp.database().ref('notification/' + order.user_id).push(user_notification);
        }
        if(action === 'new_order') {
          manager_notification = {
            'url': 'order/' + order.id,
            'notification': 'You have an order waiting for your approval',
            'created_at': Date.now(),
            'isRead': true
          };

          leads_notification = {
            'url': 'order/' + order.id,
            'notification': 'Your leads have been used in an order',
            'created_at': Date.now(),
            'isRead': true
          };

          manager_leads_notification = {
            'url': 'order/' + order.id,
            'notification': 'Leads of your subordinate have been used in an order',
            'created_at': Date.now(),
            'isRead': true
          };

          mainApp.database().ref('notification/' + Authentication.user.managerId).push(manager_notification);
          mainApp.database().ref('notification/' + leadsUserId).push(leads_notification);
          mainApp.database().ref('notification/' + managerLeadsUserId).push(manager_leads_notification);
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