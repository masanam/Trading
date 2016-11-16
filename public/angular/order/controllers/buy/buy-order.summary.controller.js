'use strict';

angular.module('order').controller('BuyOrderSummaryController', ['$scope', '$stateParams', '$location', '$uibModal', 'Port', 'Factory', 'Order', 'NgMap',
  function($scope, $stateParams, $location, $uibModal, Port, Factory, Order, NgMap) {

    $scope.buy_order = {};
    $scope.order_id = $stateParams.order_id;
    $scope.factory_id = $stateParams.factory_id;
    $scope.date = new Date();

    $scope.initMap = function() {
      NgMap.getMap().then(function(map) {
        $scope.map = map;
      });
    };

    //Init select summary
    $scope.findSummary = function(){
      $scope.buy_order = Order.get({ type: 'buy' , id: $stateParams.order_id },function(res){
        $scope.buy_order.order_date = new Date();
        $scope.buy_order.order_deadline = new Date();
        $scope.buy_order.ready_date = new Date();
        $scope.buy_order.expired_date = new Date();
      });
    };

    $scope.today = function() {
      $scope.dt = new Date();
    };
    $scope.today();

    $scope.clear = function() {
      $scope.dt = null;
    };

    $scope.inlineOptions = {
      customClass: getDayClass,
      minDate: new Date(),
      showWeeks: true
    };
    $scope.dateOptions = {
      formatYear: 'yy',
      maxDate: new Date(2020, 5, 22),
      minDate: new Date(),
      startingDay: 1
    };
    $scope.toggleMin = function() {
      $scope.inlineOptions.minDate = $scope.inlineOptions.minDate ? null : new Date();
      $scope.dateOptions.minDate = $scope.inlineOptions.minDate;
    };

    $scope.toggleMin();

    $scope.setDate = function(year, month, day) {
      $scope.dt = new Date(year, month, day);
    };

    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[0];
    $scope.altInputFormats = ['M!/d!/yyyy'];
    $scope.open1 = function() {
      $scope.popup1.opened = true;
    };
    $scope.popup1 = {
      opened: false
    };
    function getDayClass(data) {
      var date = data.date,
        mode = data.mode;
      if (mode === 'day') {
        var dayToCheck = new Date(date).setHours(0,0,0,0);

        for (var i = 0; i < $scope.events.length; i++) {
          var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

          if (dayToCheck === currentDay) {
            return $scope.events[i].status;
          }
        }
      }

      return '';
    }

    //show freetext payment terms
    $scope.freetext = function() {
      if($scope.buy_order.payment_terms === 'other'){
        $scope.buy_order.payment_terms = '';
        $scope.buy_order.freetext = true;
      }else{
        $scope.buy_order.freetext = false;
      }
    };

    //back button to port
    $scope.backToPort = function(){
      $location.path('buy-order/create/port/'+$stateParams.id+'/'+$stateParams.order_id+'/'+$stateParams.factory_id);
    };

    //button next to summary page and update order update factory port
    $scope.finish = function(){
      if(!$scope.buy_order.order_date) {
        $scope.error = 'Please fill Order Date !';
        return;
      }if(!$scope.buy_order.order_deadline) {
        $scope.error = 'Please fill Order Deadline !';
        return;
      }
      if(!$scope.buy_order.ready_date) {
        $scope.error = 'Please fill Ready Date !';
        return;
      }
      if(!$scope.buy_order.expired_date) {
        $scope.error = 'Please fill Expired Date !';
        return;
      }
      if(!$scope.buy_order.max_price) {
        $scope.error = 'Please fill Max Price !';
        return;
      }
      if(!$scope.buy_order.trading_term) {
        $scope.error = 'Please fill Buying Term !';
        return;
      }
      if(!$scope.buy_order.payment_terms) {
        $scope.error = 'Please fill Payment Terms !';
        return;
      }

      $scope.error = null;
      Order.get({ type: 'buy', id: $stateParams.order_id }, function(res){
        $scope.order = res;
        $scope.order.buyer_id = $stateParams.id;
        $scope.order.order_date = $scope.buy_order.order_date;
        $scope.order.order_deadline = $scope.buy_order.order_deadline;
        $scope.order.ready_date = $scope.buy_order.ready_date;
        $scope.order.expired_date = $scope.buy_order.expired_date;
        $scope.order.max_price = $scope.buy_order.max_price;
        $scope.order.trading_term = $scope.buy_order.trading_term;
        $scope.order.trading_term_detail = $scope.buy_order.trading_term_detail;
        $scope.order.payment_terms = $scope.buy_order.payment_terms;
        $scope.order.penalty_desc = $scope.buy_order.penalty;
        
        $scope.order.order_status = 'l';
        
        $scope.order.$update({ type: 'buy', id: $stateParams.order_id }, function(res) {
          $location.path('buy-order/'+res.id);
        });
      });
      
    };
    
  }
]);