'use strict';

angular.module('order').controller('BuyOrderSummaryController', ['$scope', '$stateParams', '$location', '$uibModal', 'Port', 'Factory', 'Order',
  function($scope, $stateParams, $location, $uibModal, Port, Factory, Order) {

    $scope.port = {};
    $scope.order_id = $stateParams.order_id;
    $scope.factory_id = $stateParams.factory_id;


    //Init select summary
    $scope.findSummary = function(){
      $scope.buy_order = Order.get({ type: 'buy' , id: $stateParams.order_id },function(res){
        $scope.buy_order.order_date = new Date();
      });
    };

    //selected port after create new
    $scope.postCreatePorts = function(){
      $scope.ports = Port.query({}, {}, function(){
        $scope.port.selected = $scope.ports[$scope.ports.length-1];
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



    //back button to port
    $scope.backToPort = function(){
      $location.path('buy-order/create/port/'+$stateParams.id+'/'+$stateParams.order_id+'/'+$stateParams.factory_id);
    };

    //button next to summary page and update order update factory port
    $scope.nextSummary = function(){
      if($scope.port.distance) {
        Factory.get({ id: $scope.factory_id }, function(res){
          $scope.factory = res;
          $scope.factory.port_id = $scope.port.selected.id;
          $scope.factory.port_distance = $scope.port.distance;
          $scope.factory.$update({ id: $scope.factory_id });
        });
        Order.get({ type: 'buy', id: $stateParams.order_id }, function(res){
          $scope.order = res;
          $scope.order.buyer_id = $stateParams.id;
          $scope.order.port_distance = $scope.port.distance;
          $scope.order.port_id = $scope.port.selected.id;
          $scope.order.port_name = $scope.port.selected.port_name;
          $scope.order.port_status = $scope.port.selected.is_private;
          $scope.order.port_daily_rate = $scope.port.selected.daily_discharge_rate;
          $scope.order.port_draft_height = $scope.port.selected.draft_height;
          $scope.order.port_latitude = $scope.port.selected.latitude;
          $scope.order.port_longitude = $scope.port.selected.longitude;
          
          $scope.order.order_status = 4;
          
          $scope.order.$update({ type: 'buy', id: $stateParams.order_id }, function(res) {
            $location.path('buy-order/create/summary/'+$stateParams.id+'/'+$stateParams.order_id+'/'+$stateParams.factory_id);
          });
        });
      }
      else{
        $scope.error = 'Please fill Distance from Discharging Port to Factory !';
      }
      
    };
    
    //open modal create port
    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/buy-order/modal.port.view.html',
        controller: 'PortModalBuyOrderController',
        scope: $scope
      });
    };

  }
]);