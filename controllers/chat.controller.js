'use strict';

angular.module('deal').controller('DealController', ['$scope', '$uibModal', 'Deal', 'Order', 'Buyer', 'Seller', 'SellDeal', 'BuyDeal', 'Authentication', '$location', '$stateParams', 'Pusher', 'BuyDealChat', 'SellDealChat',
	function($scope, $uibModal, Deal, Order, Buyer, Seller, SellDeal, BuyDeal, Authentication, $location, $stateParams, Pusher, BuyDealChat, SellDealChat) {
    $scope.deals = [];

    $scope.findDeals = function(){
      $scope.deals = Deal.query({action:'table', status: 'a'});
    };
    
    $scope.findFinished = function(){
      $scope.deals = Deal.query({action:'table', status: 'f'});
    };
    
    $scope.findCancelled = function(){
      $scope.deals = Deal.query({action:'table', status: 'x'});
    };
    
    $scope.findOne = function(){
      $scope.deal = Deal.get({ id: $stateParams.id });
    


      // Get the buy deals
      BuyDeal.query({action:'getByDeal', dealId: $stateParams.id}, function(buyDeals){
        for(var i = 0; i < buyDeals.length; i++){
            var buy_deals = buyDeals[i];
            var buy_order = buy_deals.buy_order;
            buy_order.buyer_id = buy_deals.buy_order.buyer.id.toString();
            buy_order.company_name = buy_deals.buy_order.buyer.company_name;
            $scope.buyOrders.push(buy_order);
        }
      });
      
      // Get the sell deals
      SellDeal.query({action:'getByDeal', dealId: $stateParams.id}, function(sellDeals){
        for(var i = 0; i < sellDeals.length; i++){
            var sell_deals = sellDeals[i];
            var sell_order = sell_deals.sell_order;
            sell_order.seller_id = sell_deals.sell_order.seller.id.toString();
            sell_order.company_name = sell_deals.sell_order.seller.company_name;
            $scope.sellOrders.push(sell_order);
        }
      });
    };

    $scope.findAllBuyers = function(){
      console.log('asasdasd');
      $scope.buyers = Buyer.query();
    };
    
    $scope.findAllSellers = function(){
      $scope.sellers = Seller.query();
    };
    
		//$scope.deal = Deal.get;
    
    $scope.buyOrders = [];
    
    $scope.sellOrders = [];

    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/deal/views/modal.view.html',
        controller: 'DealModalController',
        scope: $scope,
      });
    };
    
    $scope.openBuyModal = function (order) {
      $scope.order = order;
      
      $scope.order.deadline = new Date($scope.order.deadline);
      $scope.order.order_date = new Date($scope.order.order_date);
      
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/deal/views/buy-order-modal.view.html',
        controller: 'BuyModalController',
        scope: $scope,
      });
    };
    
    $scope.openSellModal = function (order) {
      $scope.order = order;
      
      $scope.order.deadline = new Date($scope.order.deadline);
      $scope.order.order_date = new Date($scope.order.order_date);
      
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/deal/views/sell-order-modal.view.html',
        controller: 'SellModalController',
        scope: $scope,
      });
    };
    
    $scope.deleteOrder = function (order) {
      $scope.sellOrders.splice($scope.sellOrders.indexOf(order), 1);
    };
    
    $scope.deleteOrder = function (order) {
      $scope.buyOrders.splice($scope.buyOrders.indexOf(order), 1);
    };
    
    $scope.openCreateBuyModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/deal/views/create-buy-order-modal.view.html',
        controller: 'CreateBuyModalController',
        scope: $scope,
      });
    };
    
    $scope.openCreateSellModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/deal/views/create-sell-order-modal.view.html',
        controller: 'CreateSellModalController',
        scope: $scope,
      });
    };
    
    $scope.getTotalPrice = function(){
        var total = 0;
        for(var i = 0; i < $scope.deals.length; i++){
            var product = $scope.deals[i];
            total += (product.total_sales);
        }
        return total;
    };
    
    $scope.getTotalVolume = function(){
        var total = 0;
        for(var i = 0; i < $scope.deals.length; i++){
            var product = $scope.deals[i];
            total += product.volume;
        }
        return total;
    };
    
    $scope.createDeal = function(){
      if($scope.buyOrders.length > 0 && $scope.sellOrders.length > 0){
        //Add Deals
        $scope.deal = {
          id: '',
          user_id: Authentication.user.id,
        };
        
        var deal = new Deal($scope.deal);
        
        deal.$save(function (response) {
          var dealId = response.id;
          var userId = Authentication.user.id;
          for(var i = 0; i < $scope.sellOrders.length; i++){
            var sellOrder = $scope.sellOrders[i];
            
            var sellDeal = {
              sell_order_id: sellOrder.id,
              user_id: userId,
              deal_id: dealId
            };
            
            sellDeal = new SellDeal(sellDeal);
            
            sellDeal.$save(function (response) {
            }, function(response){
              $scope.error = response.data.message;
            });
          }
          
          for(var i = 0; i < $scope.buyOrders.length; i++){
            var buyOrder = $scope.buyOrders[i];
            
            var buyDeal = {
              buy_order_id: buyOrder.id,
              user_id: userId,
              deal_id: dealId
            };
            
            buyDeal = new BuyDeal(buyDeal);
            
            buyDeal.$save(function (response) {
            }, function(response){
              $scope.error = response.data.message;
            });
          }
          
          $location.url('/deal/'+response.id);
          
        }, function (response) {
          $scope.error = response.data.message;
        });
      }else{
        $scope.error = "You need at least one buy order and one sell order!";
        var modalInstance = $uibModal.open({
          windowClass: 'xl-modal',
          templateUrl: 'alertModal.html',
          controller: 'AlertModalController',
          scope: $scope,
        });
        
      }
    };
    
    $scope.updateDeal = function(){
      if($scope.buyOrders.length > 0 && $scope.sellOrders.length > 0){
        var dealId = $scope.deal.id;
        var userId = Authentication.user.id;
        
        // Soft Delete Buy & Sell Deals
        BuyDeal.delete({ dealId: dealId }, function(response) {
          //$location.url('/deal');
        }, function(err) {
          console.log(err);
        });
        
        SellDeal.delete({ dealId: dealId }, function(response) {
          //$location.url('/deal');
        }, function(err) {
          console.log(err);
        });
        
        // Add Deals
        /*$scope.deal = {
          id: '',
          user_id: Authentication.user.id,
        };
        
        var deal = new Deal($scope.deal);
        
        deal.$save(function (response) {*/
          
          for(var i = 0; i < $scope.sellOrders.length; i++){
            var sellOrder = $scope.sellOrders[i];
            
            var sellDeal = {
              sell_order_id: sellOrder.id,
              user_id: userId,
              deal_id: dealId
            };
            
            sellDeal = new SellDeal(sellDeal);
            
            sellDeal.$save(function (response) {
            }, function(response){
              $scope.error = response.data.message;
            });
          }
          
          for(var i = 0; i < $scope.buyOrders.length; i++){
            var buyOrder = $scope.buyOrders[i];
            
            var buyDeal = {
              buy_order_id: buyOrder.id,
              user_id: userId,
              deal_id: dealId
            };
            
            buyDeal = new BuyDeal(buyDeal);
            
            buyDeal.$save(function (response) {
            }, function(response){
              $scope.error = response.data.message;
            });
          }
          
          $location.url('/deal/'+$scope.deal.id);
          
        /*}, function (response) {
          $scope.error = response.data.message;
        });*/
      }else{
        $scope.error = "You need at least one buy order and one sell order!";
        var modalInstance = $uibModal.open({
          windowClass: 'xl-modal',
          templateUrl: 'alertModal.html',
          controller: 'AlertModalController',
          scope: $scope,
        });
        
      }
    };
    
    $scope.finishDeal = function () {
      var deal = $scope.deal;
      
      Deal.get({ action: 'status', id: deal.id, status: 'f' }, function(response) {
				$location.url('/deal');
			}, function(err) {
				console.log(err);
			});

      
      /*deal.$remove(function (response) {
        $location.url('/deal');
      }, function (response) {
        $scope.error = response.data.message;
      });*/
    };
    
    $scope.cancelDeal = function () {
      var deal = $scope.deal;
      
      Deal.get({ action: 'status', id: deal.id, status: 'x' }, function(response) {
				$location.url('/deal');
			}, function(err) {
				console.log(err);
			});
    };

    $scope.buyDeal = {};
    $scope.sellDeal = {};

    $scope.findOneOrderDeal = function(type, $orderId) {
      if (type == 'buy') {
        $scope.buyDeal = BuyDeal.get({ action: 'getOneByDealAndOrder' , orderId: $orderId , dealId: $scope.deal.id });
      } else if (type == 'sell') {
        $scope.sellDeal = SellDeal.get({ action: 'getOneByDealAndOrder' , orderId: $orderId , dealId: $scope.deal.id });
        console.log($scope.sellDeal);
      }
    };
    
    $scope.openBuyDealChatModal = function () {
      $scope.modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/deal/views/modal-component/chat.view.html',
        controller: 'BuyDealChatModalController',
        scope: $scope,
        resolve: {
          buyDeal : $scope.buyDeal
        }
      });
    };

    $scope.openSellDealChatModal = function () {
      $scope.modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/deal/views/modal-component/chat.view.html',
        controller: 'SellDealChatModalController',
        scope: $scope,
        resolve: {
          sellDeal : $scope.sellDeal
        }
      });
    };

}]);

angular.module('deal').controller('AlertModalController', function ($scope, $uibModalInstance) {
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('deal').controller('BuyDealChatModalController', function ($scope, $uibModalInstance, Pusher, User, BuyDealChat, buyDeal) {
  $scope.buy_deal = {};
  $scope.buy_deal = buyDeal;
  $scope.buy_deal_id = buyDeal.id;
  $scope.buy_deal_chat = {};

  var channel = 'buy-deal-channel.'+ $scope.buy_deal_id;

  Pusher.subscribe(channel , 'message-sent', function (chat) {
    for (var i = 0; i < $scope.chats.length; i++) {
      if ($scope.chats[i].id === chat.id) {
        $scope.chats[i] = chat;
        break;
      }
    }
    $scope.chats.push(chat);
  });

  $scope.sendMessage = function() {
    $scope.buy_deal_chat = new BuyDealChat({
      'buy_deal_id': $scope.buy_deal.id,
      'user_id': $scope.buy_deal.user_id,
      'message': $scope.chat.message
    });

    $scope.buy_deal_chat.$save({ action: 'send' }, function(res) {
      // $scope.chats.push(res);
    });
  };

  $scope.findChatByDeal = function() {
    console.log($scope);
    console.log($scope.buy_deal.id);
    console.log($scope.buy_deal_id);
    $scope.chats = BuyDealChat.query({ id: $scope.buy_deal_id });
    console.log($scope.chats);
  };

  $scope.findCurrentUser = function() {
    $scope.user = User.get({ action: current });
  };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('deal').controller('SellDealChatModalController', function ($scope, $uibModalInstance, Pusher, User, SellDealChat, sellDeal) {
  console.log(sellDeal);
  $scope.sell_deal = {};
  $scope.sell_deal = sellDeal;
  $scope.sell_deal_id = sellDeal.id;
  $scope.sell_deal_chat = {};

  var channel = 'sell-deal-channel.'+ $scope.sell_deal_id;

  Pusher.subscribe(channel, 'message-sent', function (chat) {
    for (var i = 0; i < $scope.chats.length; i++) {
      if ($scope.chats[i].id === chat.id) {
        $scope.chats[i] = chat;
        break;
      }
      $scope.chats.push(chat);
    }
  });

  $scope.sendMessage = function() {
    $scope.sell_deal_chat = new SellDealChat({
      'sell_deal_id': $scope.sell_deal.id,
      'user_id': $scope.chat.message.user_id,
      'message': $scope.chat.message.message
    });

    $scope.sell_deal_chat.$save({ action: 'send' }, function(res) {
      $scope.chats.push(res);
    });
  };

  $scope.findChatByDeal = function() {
    console.log($scope.sell_deal_id);
    $scope.chats = SellDealChat.query({ id: $scope.sell_deal_id });
    console.log($scope.chats);
    console.log($scope.sell_deal_id);
  };

  $scope.findCurrentUser = function() {
    $scope.user = User.get({ action: current });
  };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('deal').controller('CreateSellModalController', function ($scope, $filter, $uibModalInstance, Deal, Order, Authentication) {
  
  $scope.initializeOrder = function(){
    $scope.order = {
      id: undefined,
      seller_id: undefined,
      company_name: undefined,
      order_date: new Date(),
      deadline: new Date(),
      address: undefined,
      latitude: undefined,
      longitude: undefined,
      penalty: undefined,
      volume: undefined,
      status: undefined,
      ash_min: undefined,
      ash_max: undefined,
      ash_reject: undefined,
      ash_bonus: undefined,
      gcv_arb_min: undefined,
      gcv_arb_max: undefined,
      gcv_arb_reject: undefined,
      gcv_arb_bonus: undefined,
      gcv_adb_min: undefined,
      gcv_adb_max: undefined,
      gcv_adb_reject: undefined,
      gcv_adb_bonus: undefined,
      fc_min: undefined,
      fc_max: undefined,
      fc_reject: undefined,
      fc_bonus: undefined,
      hgi_min: undefined,
      hgi_max: undefined,
      hgi_reject: undefined,
      hgi_bonus: undefined,
      im_min: undefined,
      im_max: undefined,
      im_reject: undefined,
      im_bonus: undefined,
      ncv_min: undefined,
      ncv_max: undefined,
      ncv_reject: undefined,
      ncv_bonus: undefined,
      size_min: undefined,
      size_max: undefined,
      size_reject: undefined,
      size_bonus: undefined,
      tm_min: undefined,
      tm_max: undefined,
      tm_reject: undefined,
      tm_bonus: undefined,
      ts_min: undefined,
      ts_max: undefined,
      ts_reject: undefined,
      ts_bonus: undefined,
      vm_min: undefined,
      vm_max: undefined,
      vm_reject: undefined,
      vm_bonus: undefined,
    };
  };
  
  $scope.createSellOrder = function(){
    
    $scope.success = $scope.error = null;
      
    $scope.order.deadline = $filter('date')($scope.order.deadline, "yyyy-MM-dd");
    $scope.order.order_date = $filter('date')($scope.order.order_date, "yyyy-MM-dd");
    $scope.order.user_id = Authentication.user.id;

    var sellOrder = new Order($scope.order);
    
    sellOrder.$save({ type: 'sell' }, function (response) {
      $scope.order = response;
      $scope.order.deadline = new Date($scope.order.deadline);
      $scope.order.order_date = new Date($scope.order.order_date);
      
      for(var i = 0; i < $scope.sellers.length; i++){
        var seller = $scope.sellers[i];
        if(seller.id == response.seller_id){
          $scope.order.company_name = seller.company_name;
          break;
        }
      }
      
      $scope.sellOrders.push($scope.order);
      $scope.close();
      $scope.success = true;
    }, function (response) {
      $scope.error = response.data.message;
    });
    
  };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('deal').controller('CreateBuyModalController', function ($scope, $filter, $uibModalInstance, Deal, Order, Authentication) {
  
  $scope.initializeOrder = function(){
    $scope.order = {
      id: undefined,
      buyer_id: undefined,
      company_name: undefined,
      order_date: new Date(),
      deadline: new Date(),
      address: undefined,
      latitude: undefined,
      longitude: undefined,
      penalty: undefined,
      volume: undefined,
      status: undefined,
      ash_min: undefined,
      ash_max: undefined,
      ash_reject: undefined,
      ash_bonus: undefined,
      gcv_arb_min: undefined,
      gcv_arb_max: undefined,
      gcv_arb_reject: undefined,
      gcv_arb_bonus: undefined,
      gcv_adb_min: undefined,
      gcv_adb_max: undefined,
      gcv_adb_reject: undefined,
      gcv_adb_bonus: undefined,
      fc_min: undefined,
      fc_max: undefined,
      fc_reject: undefined,
      fc_bonus: undefined,
      hgi_min: undefined,
      hgi_max: undefined,
      hgi_reject: undefined,
      hgi_bonus: undefined,
      im_min: undefined,
      im_max: undefined,
      im_reject: undefined,
      im_bonus: undefined,
      ncv_min: undefined,
      ncv_max: undefined,
      ncv_reject: undefined,
      ncv_bonus: undefined,
      size_min: undefined,
      size_max: undefined,
      size_reject: undefined,
      size_bonus: undefined,
      tm_min: undefined,
      tm_max: undefined,
      tm_reject: undefined,
      tm_bonus: undefined,
      ts_min: undefined,
      ts_max: undefined,
      ts_reject: undefined,
      ts_bonus: undefined,
      vm_min: undefined,
      vm_max: undefined,
      vm_reject: undefined,
      vm_bonus: undefined,
    };
  };
  
  $scope.createBuyOrder = function(){
    $scope.success = $scope.error = null;
      
    //$scope.order.deadline = new Date($scope.order.deadline);
    $scope.order.deadline = $filter('date')($scope.order.deadline, "yyyy-MM-dd");
    $scope.order.order_date = $filter('date')($scope.order.order_date, "yyyy-MM-dd");
    $scope.order.user_id = Authentication.user.id;

    var buyOrder = new Order($scope.order);
    
    buyOrder.$save({ type: 'buy' }, function (response) {
      $scope.order = response;
      for(var i = 0; i < $scope.buyers.length; i++){
        var buyer = $scope.buyers[i];
        if(buyer.id == response.buyer_id){
          $scope.order.company_name = buyer.company_name;
          break;
        }
      }
      $scope.order.deadline = new Date($scope.order.deadline);
      $scope.order.order_date = new Date($scope.order.order_date);
      $scope.buyOrders.push($scope.order);
      $scope.close();
      $scope.success = true;
    }, function (response) {
      $scope.error = response.data.message;
    });
    
  };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('deal').controller('BuyModalController', function ($scope, $uibModalInstance, Deal, Order, Product, $filter, Authentication) {
  
  $scope.index = $scope.buyOrders.indexOf($scope.order);
  
  $scope.updateOrder = function(index){
    $scope.success = $scope.error = null;
      
    //$scope.order.deadline = new Date($scope.order.deadline);
    $scope.order.deadline = $filter('date')($scope.order.deadline, "yyyy-MM-dd");
    $scope.order.order_date = $filter('date')($scope.order.order_date, "yyyy-MM-dd");
    $scope.order.user_id = Authentication.user.id;

    var buyOrder = new Order($scope.order);
    
    buyOrder.update({ type: 'buy' },function (response) {
      $scope.order = response;
      for(var i = 0; i < $scope.buyers.length; i++){
        var buyer = $scope.buyers[i];
        if(buyer.id == response.buyer_id){
          $scope.order.company_name = buyer.company_name;
          break;
        }
      }
      $scope.order.deadline = new Date($scope.order.deadline);
      $scope.order.order_date = new Date($scope.order.order_date);
      $scope.buyOrders[$scope.index] = $scope.order;
      $scope.close();
      $scope.success = true;
    }, function (response) {
      $scope.error = response.data.message;
    });
    
  };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('deal').controller('SellModalController', function ($scope, $uibModalInstance, Deal, Order, Product, $filter, Authentication) {
  
  $scope.index = $scope.sellOrders.indexOf($scope.order);
  
  $scope.updateOrder = function(index){
    $scope.success = $scope.error = null;
      
    //$scope.order.deadline = new Date($scope.order.deadline);
    $scope.order.deadline = $filter('date')($scope.order.deadline, "yyyy-MM-dd");
    $scope.order.order_date = $filter('date')($scope.order.order_date, "yyyy-MM-dd");
    $scope.order.user_id = Authentication.user.id;

    var sellOrder = new Order($scope.order);
    
    sellOrder.update({ type: sell }, function (response) {
      $scope.order = response;
      for(var i = 0; i < $scope.sellers.length; i++){
        var seller = $scope.sellers[i];
        if(seller.id == response.seller_id){
          $scope.order.company_name = seller.company_name;
          break;
        }
      }
      $scope.order.deadline = new Date($scope.order.deadline);
      $scope.order.order_date = new Date($scope.order.order_date);
      $scope.sellOrders[$scope.index] = $scope.order;
      $scope.close();
      $scope.success = true;
    }, function (response) {
      $scope.error = response.data.message;
    });
  };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('deal').controller('DealModalController', function ($scope, $uibModalInstance, Deal, Order, Product) {
	$scope.tab = 'call';
	$scope.states = ['call', 'match', 'deal'];

	$scope.next = function (){
		if($scope.tab === 'call') $scope.tab = 'match';
		if($scope.tab === 'match') $scope.tab = 'deal';
	};

	$scope.prev = function (){
		if($scope.tab === 'match') $scope.tab = 'call';
		if($scope.tab === 'deal') $scope.tab = 'match';
	};

	$scope.buyer = {
		company_name: 'PT Wilmar Nabati Indonesia',
		phone: '(031) 3979414',
		email: 'info@wilmar-international.com',
		price: 5600000000,
		volume: 5000,

		contact: [
			{ name: 'Toni', email: 'toni@wilmar-international.com', phone: '(031) 3979414 ext 12' },
			{ name: 'Dewi', email: 'dewi@wilmar-international.com', phone: '(031) 3979414 ext 8' },
		]
	};

	$scope.order = {
		'tm_min': 12,
        'tm_max': 18,
        'im_min': 8,
        'im_max': 11,
        'ash_min': 15,
        'ash_max': 16,
        'fc_min': 0,
        'fc_max': 41,
        'vm_min': 34,
        'vm_max': 42,
        'ts_min': 0,
        'ts_max': 1,
        'ncv_min': 5000,
        'ncv_max': 5100,
        'gcv_arb_min': 5600,
        'gcv_arb_max': 5800,
        'gcv_adb_min': 6100,
        'gcv_adb_max': 6300,
        'hgi_min': 35,
        'hgi_max': 40,
        'size_min': 45,
        'size_max': 50,
	};

	$scope.matchedSupply = function(id) {
		$scope.loading = true;

		$scope.matchSupply = Order.query({ action: 'matching', id: id });
		$scope.loading = false;
	};

	$scope.matchedDemand = function(id) {
		$scope.loading = true;

		$scope.matchDemand = Product.query({ action: 'matching', id: id });
		$scope.loading = false;
	};

  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});