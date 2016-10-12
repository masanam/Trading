'use strict';

angular.module('order').controller('OrderController', ['$location', '$scope', '$http', '$uibModal', '$stateParams', '$state', 'Order', 'OrderFulfillment', 'Buyer', '$rootScope',
  function($location, $scope, $http, $uibModal, $stateParams, $state, Order, OrderFulfillment, Buyer, $rootScope) {
    
    // History datepickers
    $scope.init_date = function() {
      $scope.dt1 = null;
      $scope.dt2 = null;
    };
    $scope.init_date();

    $scope.clear = function() {
      $scope.dt1 = null;
      $scope.dt2 = null;
    };

    $scope.inlineOptions = {
      customClass: getDayClass,
      minDate: new Date(),
      showWeeks: true
    };
    
    $scope.toggleMin = function(date) {
      date = date ? null : new Date();
      return date;
    };
    
    $scope.dateOptions1 = {
      formatYear: 'yy',
      maxDate: $scope.toggleMin($scope.dt2),
      startingDay: 1
    };

    $scope.dateOptions2 = {
      formatYear: 'yy',
      minDate: $scope.toggleMin($scope.dt1),
      startingDay: 1
    };

    //$scope.toggleMin();

    $scope.open1 = function() {
      $scope.popup1.opened = true;
    };

    $scope.open2 = function() {
      $scope.popup2.opened = true;
    };

    $scope.setDate = function(year, month, day) {
      $scope.dt = new Date(year, month, day);
    };

    $scope.format = 'dd-MM-yyyy';

    $scope.popup1 = {
      opened: false
    };

    $scope.popup2 = {
      opened: false
    };

    var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    var afterTomorrow = new Date();
    afterTomorrow.setDate(tomorrow.getDate() + 1);
    $scope.events = [
      {
        date: tomorrow,
        status: 'full'
      },
      {
        date: afterTomorrow,
        status: 'partially'
      }
    ];

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
    };
    
    $scope.orders = [];
    $scope.order = {};
    $scope.createButton = false;

    $scope.initialize = function() {
      $scope.order = {
        buyer_id: '',
        contact: '',
        phone: '',

        pickup_location: '',
        latitude: '',
        longitude: '',
        
        caloric_min: '',
        caloric_max: '',
        moisture_min: '',
        moisture_max: '',
        sulphur_min: '',
        sulphur_max: '',
        ash_min: '',
        ash_max: '',

        volume: ''
      };
    };

    $scope.create = function() {
      $scope.loading = true;

      var order = new Order({
        buyer_id: $scope.order.buyer_id, 
        order_date: $scope.order.order_date,
        deadline: $scope.order.deadline,
        address: $scope.order.address,
        latitude: $scope.order.latitude,
        longitude: $scope.order.longitude,

        tm_min: $scope.demand.tm_min,
        tm_max: $scope.demand.tm_max,
        tm_reject: $scope.demand.tm_reject,
        tm_bonus: $scope.demand.tm_bonus,
        im_min: $scope.demand.im_min,
        im_max: $scope.demand.im_max,
        im_reject: $scope.demand.im_reject,
        im_bonus: $scope.demand.im_bonus,
        ash_min: $scope.demand.ash_min,
        ash_max: $scope.demand.ash_max,
        ash_reject: $scope.demand.ash_reject,
        ash_bonus: $scope.demand.ash_bonus,
        fc_min: $scope.demand.fc_min,
        fc_max: $scope.demand.fc_max,
        fc_reject: $scope.demand.fc_reject,
        fc_bonus: $scope.demand.fc_bonus,
        vm_min: $scope.demand.vm_min,
        vm_max: $scope.demand.vm_max,
        vm_reject: $scope.demand.vm_reject,
        vm_bonus: $scope.demand.vm_bonus,
        ts_min: $scope.demand.ts_min,
        ts_max: $scope.demand.ts_max,
        ts_reject: $scope.demand.ts_reject,
        ts_bonus: $scope.demand.ts_bonus,
        ncv_min: $scope.demand.ncv_min,
        ncv_max: $scope.demand.ncv_max,
        ncv_reject: $scope.demand.ncv_reject,
        ncv_bonus: $scope.demand.ncv_bonus,
        gcv_arb_min: $scope.demand.gcv_arb_min,
        gcv_arb_max: $scope.demand.gcv_arb_max,
        gcv_arb_reject: $scope.demand.gcv_arb_reject,
        gcv_arb_bonus: $scope.demand.gcv_arb_bonus,
        gcv_adb_min: $scope.demand.gcv_adb_min,
        gcv_adb_max: $scope.demand.gcv_adb_max,
        gcv_adb_reject: $scope.demand.gcv_adb_reject,
        gcv_adb_bonus: $scope.demand.gcv_adb_bonus,
        hgi_min: $scope.demand.hgi_min,
        hgi_max: $scope.demand.hgi_max,
        hgi_reject: $scope.demand.hgi_reject,
        hgi_bonus: $scope.demand.hgi_bonus,
        size_min: $scope.demand.size_min,
        size_max: $scope.demand.size_max,
        size_reject: $scope.demand.size_reject,
        size_bonus: $scope.demand.size_bonus,

        volume: $scope.order.volume
      });

      order.$save(function(response) {
        console.log(response);
        $location.path('/trade/order/due-today');
        $scope.loading = false;
      });
    };

    $scope.find = function() {
      var id = $stateParams.buyerId;
      $scope.orderBuyers = Order.query({ action: 'orderLog', buyerId: id });
      if(id !== undefined){
        $scope.buyer = Buyer.get({ id: id });
      }
    };

    $scope.findUnattended = function() {
      $scope.orders = Order.query({ status: 'o', action: 'orderLog' });
    };

    $scope.findUnmatched = function() {
      $scope.orders = Order.query({ status: 'p', action: 'orderLog' });
    };

    $scope.findMatched = function() {
      $scope.orders = Order.query({ status: 'm', action: 'orderLog' });
    };

    $scope.findDueToday = function() {
      $scope.orders = Order.query({ action: 'due-today' });
    };
    
    $scope.getTotalPrice = function(){
        var total = 0;
        for(var i = 0; i < $scope.orders.length; i++){
            var product = $scope.orders[i];
            total += (product.max_price * product.volume);
        }
        return total;
    };
    
    $scope.getTotalVolume = function(){
        var total = 0;
        for(var i = 0; i < $scope.orders.length; i++){
            var product = $scope.orders[i];
            total += product.volume;
        }
        return total;
    };

    $scope.find = function() {
      var id = $stateParams.buyerId;
      $scope.orders = Order.query({ option: 'lastOrder', type: 'buyer', buyerId: id });
      if(id){
        $scope.findBuyer();
      }
    };

    $scope.findAllBuyers = function() {
      $scope.buyers = Buyer.query();
    }
    
    $scope.findBuyer = function() {
      $scope.buyerId = $stateParams.buyerId;
      $scope.buyer = Buyer.get({ id: $scope.buyerId });
    };

    $scope.findOne = function() {
      $scope.orderId = $stateParams.id;
      $scope.order = Order.get({ id: $scope.orderId });
    };

    $scope.openModal = function (id) {
      var modalInstance = $uibModal.open({
        size: 'lg',
        templateUrl: './angular/order/views//modal.view.html',
        controller: 'OrderModalController',
        resolve: {
          order: function () {
            return Order.get({ id: id });
          }
        }
      });
    };

    $rootScope.$on('changeStatus', function(event, data) { 
      for(var key in $scope.orders){
        if($scope.orders[key].id == data.id){
          $scope.orders[key].status = data.status;
        } 
      }
    });

    
}]);

angular.module('order').controller('BuyOrderController', ['$location', '$scope', '$http', '$uibModal', '$stateParams', 'Order',
  function($location, $scope, $http, $uibModal, $stateParams, Order) {
    
    $scope.findBuyOrder = function() {
      $scope.buy_orders = Order.query({ type: 'buy' });
    };

    $scope.findOne = function(id) {

      if(id !== undefined){
        $scope.buy_orderId = id;
      } else {
        $scope.buy_orderId = $stateParams.id;
      }

      $scope.buy_order = Order.get({ type: 'buy', id: $scope.buy_orderId });
    };

    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        templateUrl: './angular/order/views/buy-order/create.modal.view.html',
        controller: 'BuyOrderModalController',
        scope: $scope,
        size: 'lg'
      });
    };

    
    

}]);

angular.module('order').controller('SellOrderController', ['$location', '$scope', '$http', '$uibModal', '$stateParams', 'Order', 'Seller',
  function($location, $scope, $http, $uibModal, $stateParams, Order, Seller) {
    
    $scope.findSellOrder = function() {
      $scope.sell_orders = Order.query({ type: 'sell' });
    };

    $scope.findOne = function(id) {

      if(id !== undefined){
        $scope.sell_orderId = id;
      } else {
        $scope.sell_orderId = $stateParams.id;
      }

      $scope.sell_order = Order.get({ type: 'sell', id: $scope.sell_orderId });
    };

    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        templateUrl: './angular/order/views/sell-order/create.modal.view.html',
        controller: 'SellOrderModalController',
        scope: $scope,
        size: 'lg'
      });
    };

}]);

angular.module('order').controller('OrderModalController', function ($scope, $uibModalInstance, $timeout, order, Order, OrderFulfillment) {
  $scope.status = {
    o: 'OPEN',
    p: 'PROGRESS',
    m: 'MATCHED',
    d: 'DEAL',
    f: 'FINISHED',
    c: 'CANCEL'
  };
  $scope.order = order;
  $scope.matchButton = false;
  $scope.markButton = '';

  $scope.errorMessage = '';

  $scope.matchedProduct = function(id) {
    $scope.loading = true;

    $scope.match = Order.query({ action: 'matching', id: id });
    $scope.loading = false;
  };

  $scope.callOrder = function(order) {
    $scope.loading =true;

    Order.get({ id: order.id , action: 'call' }, function(response) {
      order.status = 'p';
      $scope.errorMessage = 'This Order has been marked as "On Progress" and moved into "Called Order" tab';
      $scope.$emit('changeStatus', order);
      $scope.loading = false;
    });
  };

  $scope.matchOrder = function(order) {
    $scope.loading =true;

    Order.get({ id: order.id , action: 'match' }, function(response) {
      order.status = 'm';
      $scope.errorMessage = 'This Order has been marked as "Matched" and moved into "Matched Order" tab';
      $scope.$emit('changeStatus', order);
      $scope.loading = false;
    });
  };
  
  $scope.createOrderFulfillment = function(order, match) {
    $scope.loading =true;
    $scope.errorMessage = "";
    
    var orderFulfillment = new OrderFulfillment({
      order_id: order.id,
      product_id: match.id,
      volume: match.volume,
    });

    orderFulfillment.$save(function(response) {
      $scope.order = response;
      $scope.order.status = 'm';
      $scope.loading = false;
      $scope.errorMessage = "You have chosen the sourcing from "+match.mine_name+" : ("+match.volume+") tonnes";
    });
  };

  $scope.negoOrder = function(order) {
    $scope.loading =true;

    Order.get({ id: order.id , action: 'nego' }, function(response) {
      order.status = 'd';
      $scope.errorMessage = 'This Order has been marked as "Deal" and moved into "Waiting for Closing"';
      $scope.$emit('changeStatus', order);
      $scope.loading = false;
    });
  };

  $scope.finishOrder = function(order) {
    $scope.loading =true;

    Order.get({ id: order.id , action: 'finish' }, function(response) {
      order.status = 'f';
      $scope.errorMessage = 'This Order has been marked as "Finished" and moved into "Order History"';
      $scope.$emit('changeStatus', order);
      $scope.loading = false;
    });
  };

  $scope.cancelOrder = function(order) {
    $scope.loading =true;

    Order.get({ id: order.id , action: 'cancel' }, function(response) {
      order.status = 'c';
      $scope.errorMessage = 'This Order has been marked as "Cancelled" and moved into "Order History"';
      $scope.$emit('changeStatus', order);
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

angular.module('order').controller('CreateOrderController', ['$location', '$scope', '$http', '$uibModal', '$stateParams', '$state', 'Order', 'Buyer', '$rootScope',
  function($location, $scope, $http, $uibModal, $stateParams, $state, Order, Buyer, $rootScope) {
    $scope.openCreateBuyOrderModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views//create-buy-order-modal.view.html',
        controller: 'BuyOrderModalController',
        scope: $scope
      });
    };
}]);

angular.module('order').controller('BuyOrderModalController', function ($scope, $uibModalInstance, $filter, Buyer, Order, Product) {
  
  $scope.init = function(){
    $scope.state = 0;
    $scope.choose = undefined;
    $scope.error = undefined;
    $scope.order = {
      buyer_id: undefined,
      order_date: undefined,
      deadline: undefined,
      penalty: undefined,
      address: undefined,
      latitude: undefined,
      longitude: undefined,
      product_name: undefined,
      product_id: undefined,
      volume: undefined,
      gcv_arb_min: undefined,
      gcv_arb_max: undefined,
      gcv_adb_min: undefined,
      gcv_adb_max: undefined,
      ncv_min: undefined,
      ncv_max: undefined,
      ash_min: undefined,
      ash_max: undefined,
      ts_min: undefined,
      ts_max: undefined,
      tm_min: undefined,
      tm_max: undefined,
      im_min: undefined,
      im_max: undefined,
      fc_min: undefined,
      fc_max: undefined,
      vm_min: undefined,
      vm_max: undefined,
      hgi_min: undefined,
      hgi_max: undefined,
      size_min: undefined,
      size_max: undefined
    };
  };

  $scope.reset = function() {
    $scope.state = 0;
    $scope.choose = undefined;
    $scope.order = {
      buyer_id: undefined,
      order_date: undefined,
      deadline: undefined,
      penalty: undefined,
      address: undefined,
      latitude: undefined,
      longitude: undefined,
      product_name: undefined,
      product_id: undefined,
      volume: undefined,
      max_price: undefined,
      gcv_arb_min: undefined,
      gcv_arb_max: undefined,
      gcv_adb_min: undefined,
      gcv_adb_max: undefined,
      ncv_min: undefined,
      ncv_max: undefined,
      ash_min: undefined,
      ash_max: undefined,
      ts_min: undefined,
      ts_max: undefined,
      tm_min: undefined,
      tm_max: undefined,
      im_min: undefined,
      im_max: undefined,
      fc_min: undefined,
      fc_max: undefined,
      vm_min: undefined,
      vm_max: undefined,
      hgi_min: undefined,
      hgi_max: undefined,
      size_min: undefined,
      size_max: undefined
    };
  };

  $scope.next = function () {
    if (($scope.state==0)&&
      ($scope.order.buyer_id)&&
      ($scope.order.order_date)&&
      ($scope.order.deadline)&&
      ($scope.order.address)&&
      ($scope.order.latitude)&&
      ($scope.order.longitude)) 
    {
      // $scope.company_name = Buyer.get({ id: $scope.order.buyer_id });
      $scope.state = $scope.state+1;
    }

    else if (($scope.state==1)&&(($scope.choose==='available')||($scope.choose==='manual'))) 
    {
      if ($scope.order.product_name!==undefined) {
        $scope.state = $scope.state+1;
        $scope.error = undefined;
      }
      else if ($scope.order.product_name==undefined) {
        $scope.error = "Harap pilih product / isi product name";
      }
    }

  };

  $scope.back = function () {
    $scope.state = $scope.state-1;
  };

  $scope.setChoose = function(choose) {
    $scope.choose = choose;
    $scope.order.product_id = undefined;
    $scope.order.product_name = undefined;
  };

  $scope.setSelected = function(product) {
    $scope.order.product_name = product.product_name;
    $scope.order.product_id = product.id;
  };

  $scope.findAllBuyers = function() {
    $scope.buyers = Buyer.query();
  };

  $scope.findAllProducts = function() {
    $scope.products = Product.query();
  };


  $scope.create = function() {
    var buy_order = new Order({
        buyer_id: $scope.order.buyer_id, 
        order_date: $filter('date')($scope.order.order_date, "yyyy-MM-dd"),
        deadline: $filter('date')($scope.order.deadline, "yyyy-MM-dd"),
        address: $scope.order.address,
        latitude: $scope.order.latitude,
        longitude: $scope.order.longitude,
        penalty_desc: $scope.order.penalty,
        product_name: $scope.order.product_name,
        product_id: $scope.order.product_id,

        tm_min: $scope.order.tm_min,
        tm_max: $scope.order.tm_max,
        im_min: $scope.order.im_min,
        im_max: $scope.order.im_max,
        ash_min: $scope.order.ash_min,
        ash_max: $scope.order.ash_max,
        fc_min: $scope.order.fc_min,
        fc_max: $scope.order.fc_max,
        vm_min: $scope.order.vm_min,
        vm_max: $scope.order.vm_max,
        ts_min: $scope.order.ts_min,
        ts_max: $scope.order.ts_max,
        ncv_min: $scope.order.ncv_min,
        ncv_max: $scope.order.ncv_max,
        gcv_arb_min: $scope.order.gcv_arb_min,
        gcv_arb_max: $scope.order.gcv_arb_max,
        gcv_adb_min: $scope.order.gcv_adb_min,
        gcv_adb_max: $scope.order.gcv_adb_max,
        hgi_min: $scope.order.hgi_min,
        hgi_max: $scope.order.hgi_max,
        size_min: $scope.order.size_min,
        size_max: $scope.order.size_max,

        volume: $scope.order.volume,
        max_price: $scope.order.max_price
      });

      buy_order.$save({ type: 'buy' }, function(res) {
        $scope.buy_orders.push(res);
        $uibModalInstance.close('success');
      });
  }

  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('order').controller('SellOrderModalController', function ($scope, $uibModalInstance, $filter, Seller, Order, Product) {
  
  $scope.init = function(){
    $scope.state = 0;
    $scope.choose = undefined;
    $scope.order = {
      seller_id: undefined,
      order_date: undefined,
      deadline: undefined,
      penalty: undefined,
      address: undefined,
      latitude: undefined,
      longitude: undefined,
      product_name: undefined,
      product_id: undefined,
      volume: undefined,
      gcv_arb_min: undefined,
      gcv_arb_max: undefined,
      gcv_adb_min: undefined,
      gcv_adb_max: undefined,
      ncv_min: undefined,
      ncv_max: undefined,
      ash_min: undefined,
      ash_max: undefined,
      ts_min: undefined,
      ts_max: undefined,
      tm_min: undefined,
      tm_max: undefined,
      im_min: undefined,
      im_max: undefined,
      fc_min: undefined,
      fc_max: undefined,
      vm_min: undefined,
      vm_max: undefined,
      hgi_min: undefined,
      hgi_max: undefined,
      size_min: undefined,
      size_max: undefined
    };
  };

  $scope.reset = function() {
    $scope.state = 0;
    $scope.choose = undefined;
    $scope.order = {
      seller_id: undefined,
      order_date: undefined,
      deadline: undefined,
      penalty: undefined,
      address: undefined,
      latitude: undefined,
      longitude: undefined,
      product_name: undefined,
      product_id: undefined,
      volume: undefined,
      max_price: undefined,
      gcv_arb_min: undefined,
      gcv_arb_max: undefined,
      gcv_adb_min: undefined,
      gcv_adb_max: undefined,
      ncv_min: undefined,
      ncv_max: undefined,
      ash_min: undefined,
      ash_max: undefined,
      ts_min: undefined,
      ts_max: undefined,
      tm_min: undefined,
      tm_max: undefined,
      im_min: undefined,
      im_max: undefined,
      fc_min: undefined,
      fc_max: undefined,
      vm_min: undefined,
      vm_max: undefined,
      hgi_min: undefined,
      hgi_max: undefined,
      size_min: undefined,
      size_max: undefined
    };
  };

  $scope.next = function () {
    if (($scope.state==0)&&
      ($scope.order.seller_id)&&
      ($scope.order.order_date)&&
      ($scope.order.deadline)&&
      ($scope.order.address)&&
      ($scope.order.latitude)&&
      ($scope.order.longitude)) 
      // if ($scope.state==0)
    {
      $scope.company_name = Seller.get({ id: $scope.order.seller_id });
      $scope.state = $scope.state+1;
    }

    else if (($scope.state==1)&&(($scope.choose==='available')||($scope.choose==='manual'))) 
    {
      if ($scope.order.product_name!==undefined) {
        $scope.state = $scope.state+1;
        $scope.error = undefined;
      }
      else if ($scope.order.product_name==undefined) {
        $scope.error = "Harap pilih product / isi product name";
      }
    }

  };

  $scope.back = function () {
    $scope.state = $scope.state-1;
  };

  $scope.setChoose = function(choose) {
    $scope.choose = choose;
    $scope.order.product_id = undefined;
    $scope.order.product_name = undefined;
  };

  $scope.setSelected = function(product) {
    $scope.order.product_name = product.product_name;
    $scope.order.product_id = product.id;
    console.log($scope.order.product_name);
  };

  $scope.findAllSellers = function() {
    $scope.sellers = Seller.query();
  };

  $scope.findAllProducts = function() {
    $scope.products = Product.query();
  };


  $scope.create = function() {
    var sell_order = new Order({
        seller_id: $scope.order.seller_id, 
        order_date: $filter('date')($scope.order.order_date, "yyyy-MM-dd"),
        deadline: $filter('date')($scope.order.deadline, "yyyy-MM-dd"),
        address: $scope.order.address,
        latitude: $scope.order.latitude,
        longitude: $scope.order.longitude,
        penalty_desc: $scope.order.penalty,
        product_name: $scope.order.product_name,
        product_id: $scope.order.product_id,

        tm_min: $scope.order.tm_min,
        tm_max: $scope.order.tm_max,
        im_min: $scope.order.im_min,
        im_max: $scope.order.im_max,
        ash_min: $scope.order.ash_min,
        ash_max: $scope.order.ash_max,
        fc_min: $scope.order.fc_min,
        fc_max: $scope.order.fc_max,
        vm_min: $scope.order.vm_min,
        vm_max: $scope.order.vm_max,
        ts_min: $scope.order.ts_min,
        ts_max: $scope.order.ts_max,
        ncv_min: $scope.order.ncv_min,
        ncv_max: $scope.order.ncv_max,
        gcv_arb_min: $scope.order.gcv_arb_min,
        gcv_arb_max: $scope.order.gcv_arb_max,
        gcv_adb_min: $scope.order.gcv_adb_min,
        gcv_adb_max: $scope.order.gcv_adb_max,
        hgi_min: $scope.order.hgi_min,
        hgi_max: $scope.order.hgi_max,
        size_min: $scope.order.size_min,
        size_max: $scope.order.size_max,

        volume: $scope.order.volume,
        max_price: $scope.order.max_price
      });
    console.log(sell_order);

      sell_order.$save({ type: 'sell' }, function(res) {
        $scope.sell_orders.push(res);
        $uibModalInstance.close('success');
      });
  }

  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

