'use strict';

angular.module('order').controller('SellOrderSummaryController', ['$scope', '$stateParams', '$location', '$uibModal', 'Port', 'Concession', 'Order',
  function($scope, $stateParams, $location, $uibModal, Port, Concession, Order) {

    $scope.sell_order = {};
    $scope.order_id = $stateParams.order_id;
    $scope.concession_id = $stateParams.concession_id;


    //Init select summary
    $scope.findSummary = function(){
      $scope.sell_order = Order.get({ type: 'sell' , id: $stateParams.order_id },function(res){
        $scope.sell_order.order_date = new Date();
        $scope.sell_order.order_deadline = new Date();
        $scope.sell_order.ready_date = new Date();
        $scope.sell_order.expired_date = new Date();
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
    $scope.freetext = function(payment_terms) {
      if(payment_terms === 'other'){
        $scope.sell_order.payment_terms = '';
      }
    };

    //back button to port
    $scope.backToPort = function(){
      $location.path('sell-order/create/port/'+$stateParams.id+'/'+$stateParams.order_id+'/'+$stateParams.concession_id);
    };

    //button next to summary page and update order update concession port
    $scope.finish = function(){
      if(!$scope.sell_order.order_date) {
        $scope.error = 'Please fill Order Date !';
        return;
      }if(!$scope.sell_order.order_deadline) {
        $scope.error = 'Please fill Order Deadline !';
        return;
      }
      if(!$scope.sell_order.ready_date) {
        $scope.error = 'Please fill Ready Date !';
        return;
      }
      if(!$scope.sell_order.expired_date) {
        $scope.error = 'Please fill Expired Date !';
        return;
      }
      if(!$scope.sell_order.min_price) {
        $scope.error = 'Please fill Min Price !';
        return;
      }
      if(!$scope.sell_order.trading_term) {
        $scope.error = 'Please fill selling Term !';
        return;
      }
      if(!$scope.sell_order.payment_terms) {
        $scope.error = 'Please fill Payment Terms !';
        return;
      }

      $scope.error = null;
      Order.get({ type: 'sell', id: $stateParams.order_id }, function(res){
        $scope.order = res;
        $scope.order.seller_id = $stateParams.id;
        $scope.order.order_date = $scope.sell_order.order_date;
        $scope.order.order_deadline = $scope.sell_order.order_deadline;
        $scope.order.ready_date = $scope.sell_order.ready_date;
        $scope.order.expired_date = $scope.sell_order.expired_date;
        $scope.order.min_price = $scope.sell_order.min_price;
        $scope.order.trading_term = $scope.sell_order.trading_term;
        $scope.order.trading_term_detail = $scope.sell_order.trading_term_detail;
        $scope.order.payment_terms = $scope.sell_order.payment_terms;
        $scope.order.penalty_desc = $scope.sell_order.penalty;
        
        $scope.order.order_status = 'l';
        
        $scope.order.$update({ type: 'sell', id: $stateParams.order_id }, function(res) {
          $location.path('sell-order/'+res.id);
        });
      });
      
    };
    
  }
]);