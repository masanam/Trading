'use strict';

angular.module('chat').controller('ChatController', ['$scope', '$stateParams', 'Order', 'Authentication', '$location', 'Chat',
	function($scope, $stateParams, Order, Authentication, $location, Chat) {
  $scope.orders = [];

  $scope.order = {};

  // TESTING
  $scope.chat = {};
  $scope.message = '';

  $scope.initialize = function() {
    $scope.message = '';
  };

  $scope.findOneOrder = function($order) {
    $scope.order = Order.get({
      id: $stateParams.id,
      envelope: 'true'
    }, function(res){
      $scope.order = res.order;
      for (var i = 0; i < $scope.order.sells.length; i++) {
        // $scope.order.sells[i].additional = $scope.order.sells[i].pivot.negotiations[0];
        // $scope.order.sells[i].additional.others_cost = parseFloat($scope.order.sells[i].pivot.negotiations[0].others_cost) || 0;
        // $scope.order.sells[i].additional.insurance_cost = parseFloat($scope.order.sells[i].pivot.negotiations[0].insurance_cost) || 0;
        // $scope.order.sells[i].additional.interest_cost = parseFloat($scope.order.sells[i].pivot.negotiations[0].interest_cost) || 0;
        // $scope.order.sells[i].additional.surveyor_cost = parseFloat($scope.order.sells[i].pivot.negotiations[0].surveyor_cost) || 0;
        // $scope.order.sells[i].additional.port_to_factory = parseFloat($scope.order.sells[i].pivot.negotiations[0].port_to_factory) || 0;
        // $scope.order.sells[i].additional.transhipment = parseFloat($scope.order.sells[i].pivot.negotiations[0].transhipment) || 0;
        // $scope.order.sells[i].additional.freight_cost = parseFloat($scope.order.sells[i].pivot.negotiations[0].freight_cost) || 0;
        // $scope.order.sells[i].additional.pit_to_port = parseFloat($scope.order.sells[i].pivot.negotiations[0].pit_to_port) || 0;
      }
      for (i = 0; i < $scope.order.buys.length; i++) {
        // console.log($scope.order.buys[i]);
        // $scope.order.buys[i].additional = $scope.order.buys[i].pivot.negotiations[0];
        // $scope.order.buys[i].additional.others_cost = parseFloat($scope.order.buys[i].pivot.negotiations[0].others_cost) || 0;
        // $scope.order.buys[i].additional.insurance_cost = parseFloat($scope.order.buys[i].pivot.negotiations[0].insurance_cost) || 0;
        // $scope.order.buys[i].additional.interest_cost = parseFloat($scope.order.buys[i].pivot.negotiations[0].interest_cost) || 0;
        // $scope.order.buys[i].additional.surveyor_cost = parseFloat($scope.order.buys[i].pivot.negotiations[0].surveyor_cost) || 0;
        // $scope.order.buys[i].additional.port_to_factory = parseFloat($scope.order.buys[i].pivot.negotiations[0].port_to_factory) || 0;
        // $scope.order.buys[i].additional.transhipment = parseFloat($scope.order.buys[i].pivot.negotiations[0].transhipment) || 0;
        // $scope.order.buys[i].additional.freight_cost = parseFloat($scope.order.buys[i].pivot.negotiations[0].freight_cost) || 0;
        // $scope.order.buys[i].additional.pit_to_port = parseFloat($scope.order.buys[i].pivot.negotiations[0].pit_to_port) || 0;
      }
      $scope.checkOrderUsers();
    });
  };

  $scope.findChatByOrder = function() {
    Chat.findChatByOrder($stateParams.id, function(res){
      res.$loaded(function(res) {
        for (var i = 0; i < res.length; i++) {
          res[i].created_at = new Date(res[i].created_at);
        }
        $scope.chats = res;
      });
    });
  };

  $scope.findRelatedUsers = function() {
    // $scope.user = User.get({ action: current });
    $scope.user = Authentication.user;
    $scope.relatedUsers = Order.get({ orderId: $stateParams.id }, function() {
      for (var i = $scope.relatedUsers.length - 1; i >= 0; i--) {
        if($scope.relatedUsers[i].user_id === Authentication.user.id) {
          $scope.relatedUsers.splice(i, 1);
        }
      }
    });
  };

  $scope.sendMessage = function() {
    var message = $scope.message;
    if(message !== ''){
      $scope.chat.key = Chat.sendChat($stateParams.id, $scope.order.users, message);
      
      $scope.initialize();
    }
  };
}]);