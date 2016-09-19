'use strict';

angular.module('deal').controller('DealController', ['$scope', '$uibModal', 'Deal', 'SellOrder', 'BuyOrder', 'Buyer', 'Seller',
	function($scope, $uibModal, Deal, SellOrder, BuyOrder, Buyer, Seller) {
    $scope.findDeals = function(){
      $scope.deals = Deal.query;
    };
    
    $scope.findCancelled = function(){
      $scope.deals = Deal.query;
    };
    
    $scope.findFinished = function(){
      $scope.deals = Deal.query;
    };
    
    $scope.findAllSellers = function(){
      $scope.sellers = Seller.query();
    };
    
    $scope.findAllBuyers = function(){
      $scope.buyers = Buyer.query();
    };
    
		$scope.deal = Deal.get;
    
    $scope.buyOrders = [];
    
    $scope.sellOrders = [];

    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/views/deal/modal.view.html',
        controller: 'DealModalController',
        scope: $scope,
      });
    };
    
    $scope.openBuyModal = function (order) {
      $scope.order = order;
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/views/deal/buy-order-modal.view.html',
        controller: 'BuyModalController',
        scope: $scope,
      });
    };
    
    $scope.openSellModal = function (order) {
      $scope.order = order;
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/views/deal/sell-order-modal.view.html',
        controller: 'SellModalController',
        scope: $scope,
      });
    };
    
    $scope.deleteSellOrder = function (order) {
      $scope.sellOrders.splice($scope.sellOrders.indexOf(order), 1);
    };
    
    $scope.deleteBuyOrder = function (order) {
      $scope.buyOrders.splice($scope.buyOrders.indexOf(order), 1);
    };
    
    $scope.openCreateBuyModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/views/deal/create-buy-order-modal.view.html',
        controller: 'CreateBuyModalController',
        scope: $scope,
      });
    };
    
    $scope.openCreateSellModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/views/deal/create-sell-order-modal.view.html',
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
        //Add BuyOrders
        //Add SellOrders
        //Add Deals
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

}]);

angular.module('deal').controller('AlertModalController', function ($scope, $uibModalInstance) {
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('deal').controller('CreateSellModalController', function ($scope, $uibModalInstance, Deal, SellOrder, BuyOrder) {
  
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
    for (var i in $scope.sellers) {
      if ($scope.sellers[i].id === $scope.order.seller_id) {
        $scope.order.company_name = $scope.sellers[i].company_name;
      }
    }
    $scope.sellOrders.push($scope.order);
    $scope.close();
  };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('deal').controller('CreateBuyModalController', function ($scope, $uibModalInstance, Deal, SellOrder, BuyOrder) {
  
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
    for (var i in $scope.buyers) {
      if ($scope.buyers[i].id === $scope.order.buyer_id) {
        $scope.order.company_name = $scope.buyers[i].company_name;
      }
    }
    //console.log($scope.buyers[].company_name);
    $scope.buyOrders.push($scope.order);
    $scope.close();
  };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('deal').controller('BuyModalController', function ($scope, $uibModalInstance, Deal, SellOrder, BuyOrder, Product) {
  
  $scope.index = $scope.buyOrders.indexOf($scope.order);
  
  $scope.updateBuyOrder = function(index){
    $scope.buyOrders[$scope.index] = $scope.order;
  };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('deal').controller('SellModalController', function ($scope, $uibModalInstance, Deal, SellOrder, BuyOrder, Product) {
  
  $scope.index = $scope.sellOrders.indexOf($scope.order);
  
  $scope.updateSellOrder = function(index){
    $scope.sellOrders[$scope.index] = $scope.order;
  };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('deal').controller('DealModalController', function ($scope, $uibModalInstance, Deal, SellOrder, BuyOrder, Product) {
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
  
	$scope.sellers = [
		{
			company_name: 'PT Kuansing Inti Makmur',
			phone: '+6276132317',
			email: 'info@kim.com',
			price: 2400000000,
			volume: 2400,

			contact: [
				{ name: 'Albert Santos', email: 'albert@kim.com', phone: '+6276132317 ext 12' },
			]
		},
		{
			company_name: 'PT Golden Energy Mines',
			phone: '+62811123456',
			email: 'info@gems.com',
			price: 2600000000,
			volume: 2600,

			contact: [
				{ name: 'Mochtar Suhadi', email: 'mosu@gems.com', phone: '+62811123456 ext 12' },
			]
		}
	];

	$scope.vendors = [
		{
			company_name: 'PT Mitra Bahari Sentosa',
			phone: '+6212345678',
			email: 'info@mbs.com',
			price: 75000000,

			contact: [
				{ name: 'Jimmy Sunarko', email: 'jimmy@mbs.com', phone: '+6212345678 ext 12' },
			]
		}
	];

	$scope.orderFulfillments = [
		{ company: 'PT Kuansing Inti Makmur', mine: 'KIM West', order_date: Date(), status: 'd' },
		{ company: 'PT Golden Energy Mines', mine: 'PP', order_date: Date(), status: 's' }
	];

  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});