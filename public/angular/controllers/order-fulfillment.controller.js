'use strict';

angular.module('order').controller('OrderFulfillmentController', ['$scope', '$http', '$stateParams', '$state', '$uibModal', '$rootScope', 'BoardDataFactory', 'BoardService', 'DTOptionsBuilder', 'NgMap', 'OrderFulfillment',
  function($scope, $http, $stateParams, $state, $uibModal, $rootScope, BoardDataFactory, BoardService, DTOptionsBuilder, NgMap, OrderFulfillment) {
    $scope.orderFulfillments = [];
    $scope.orderFulfillment = {};

    $scope.options = DTOptionsBuilder.newOptions().withPaginationType('full_numbers').withDisplayLength();

    $scope.kanban = BoardService.kanbanBoard(BoardDataFactory.kanban);

    $scope.kanbanSortOptions = {
      //restrict move across columns. move only within column.
      /*accept: function (sourceItemHandleScope, destSortableScope) {
       return sourceItemHandleScope.itemScope.sortableScope.$id === destSortableScope.$id;
       },*/
      itemMoved: function (event) {
        event.source.itemScope.modelValue.status = event.dest.sortableScope.$parent.column.name;
      },
      orderChanged: function (event) {
      },
      containment: '#board'
    };

    NgMap.getMap().then(function(map) {
      $scope.map = map;
    });

    $scope.findOngoing = function() {
      $scope.orderFulfillments = OrderFulfillment.query({ option: 'ongoing-trade' });
    };
    
    $scope.findWaitingForCall = function() {
      $scope.orderFulfillments = OrderFulfillment.query({ option: 'waiting-for-call' });
    };
    
    $scope.findWaitingForNego = function() {
      $scope.orderFulfillments = OrderFulfillment.query({ option: 'waiting-for-nego' });
    };
    
    $scope.findWaitingForShipment = function() {
      $scope.orderFulfillments = OrderFulfillment.query({ option: 'waiting-for-shipment' });
    };
    
    $scope.findWaitingForClosing = function() {
      $scope.orderFulfillments = OrderFulfillment.query({ option: 'waiting-for-closing' });
    };
    
    $scope.findDueToday = function() {
      $scope.orderFulfillments = OrderFulfillment.query({ option: 'due-today' });
    };

    $scope.findLog = function() {
      $scope.orderFulfillments = OrderFulfillment.query({ option: 'log' });
    };

    $scope.findHistory = function(id) {
      $scope.orderFulfillments = OrderFulfillment.query({ option: 'history', sellerId: id });
    };

    $scope.find = function() {
      $scope.orderFulfillments = OrderFulfillment.query();
    };

    $scope.labels = ["Download Sales", "In-Store Sales", "Mail-Order Sales"];
    $scope.data = [300, 500, 100];

    $scope.openModal = function (id) {
      var modalInstance = $uibModal.open({
        size: 'lg',
        templateUrl: './angular/views/order-fulfillment/modal.view.html',
        controller: 'OrderFulfillmentModalController',
        resolve: {
          orderFulfillment: function () {
            return $scope.orderFulfillment = OrderFulfillment.get({ id: id });
          }
        }
      });
    };
    
    $rootScope.$on('changeStatus', function(event, data) { 
      for(var key in $scope.orderFulfillments){
        if($scope.orderFulfillments[key].id === data.id){
          $scope.orderFulfillments[key].status = data.status;
        } 
      }
    });

}]);

angular.module('order').controller('OrderFulfillmentModalController', function ($scope, $uibModalInstance, $timeout, OrderFulfillment, orderFulfillment) {
  $scope.status = {
    o: 'OPEN',
    p: 'PROGRESS',
    d: 'DEAL',
    s: 'SHIPPING',
    a: 'DELIVERED',
    f: 'FINISHED',
    c: 'CANCEL',
    r: 'REJECT'
  };
  $scope.orderFulfillment = orderFulfillment;
  
  $scope.errorMessage = '';
  
  $scope.progressOrder = function(orderFulfillment) {
    $scope.loading = true;

    OrderFulfillment.get({ id: orderFulfillment.id , action: 'attend', status: 'p'}, function(response) {
      orderFulfillment.status = 'p';
      $scope.errorMessage = 'This Order has been marked as "On Progress" and moved into "Waiting for Nego"';
      $scope.$emit('changeStatus', orderFulfillment);
      $scope.loading = false;
    });
  };
  
  $scope.dealOrder = function(orderFulfillment) {
    $scope.loading = true;

    OrderFulfillment.get({ id: orderFulfillment.id , action: 'attend', status: 'd'}, function(response) {
      orderFulfillment.status = 'd';
      $scope.errorMessage = 'This Order has been marked as "Deal" and moved into "Waiting for Shipment"';
      $scope.$emit('changeStatus', orderFulfillment);
      $scope.loading = false;
    });
  };

  $scope.shipOrder = function(orderFulfillment) {
    $scope.loading = true;

    OrderFulfillment.get({ id: orderFulfillment.id , action: 'attend', status: 's'}, function(response) {
      orderFulfillment.status = 's';
      $scope.errorMessage = 'This Order has been marked as "Shipment" and moved into "Waiting for Shipment"';
      $scope.$emit('changeStatus', orderFulfillment);
      $scope.loading = false;
    });
  };

  $scope.destOrder = function(orderFulfillment) {
    $scope.loading = true;

    OrderFulfillment.get({ id: orderFulfillment.id , action: 'attend', status: 'a'}, function(response) {
      orderFulfillment.status = 'a';
      $scope.errorMessage = 'This Order has been marked as "Arrived" and moved into "Waiting for Closing"';
      $scope.$emit('changeStatus', orderFulfillment);
      $scope.loading = false;
    });
  };
  
  $scope.finishOrder = function(orderFulfillment) {
    $scope.loading = true;

    OrderFulfillment.get({ id: orderFulfillment.id , action: 'attend', status: 'f'}, function(response) {
      orderFulfillment.status = 'f';
      $scope.errorMessage = 'This Order has been marked as "Finished" and moved into "Sourcing History"';
      $scope.$emit('changeStatus', orderFulfillment);
      $scope.loading = false;
    });
  };
  
  $scope.cancelOrder = function(orderFulfillment) {
    $scope.loading = true;

    OrderFulfillment.get({ id: orderFulfillment.id , action: 'attend', status: 'c'}, function(response) {
      orderFulfillment.status = 'c';
      $scope.errorMessage = 'This Order has been marked as "Cancelled" and moved into "Sourcing History"';
      $scope.$emit('changeStatus', orderFulfillment);
      $scope.loading = false;
    });
  };
  
  $scope.rejectOrder = function(orderFulfillment) {
    $scope.loading = true;

    OrderFulfillment.get({ id: orderFulfillment.id , action: 'attend', status: 'r'}, function(response) {
      orderFulfillment.status = 'r';
      $scope.errorMessage = 'This Order has been marked as "Rejected" and moved into "Sourcing History"';
      $scope.$emit('changeStatus', orderFulfillment);
      $scope.loading = false;
    });
  };

  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };

  $timeout(function() {
    $scope.render = true;
  }, 1000);
});