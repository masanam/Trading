'use strict';

angular.module('deal').controller('DealController', ['$scope', '$uibModal', 'Deal', 'Order', 'Product',
	function($scope, $uibModal, Deal, Order, Product) {
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
    };
    
    $scope.findAllBuyers = function(){
      $scope.buyers = [
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
    };
    
		$scope.deal = Deal.get;
    
    $scope.buyOrders = [{
      id: 1,
      buyer_id: 1,
      company_name: 'PT. Sinarmas Master Lain',
      order_date: '2008-10-01',
      volume: 1000,
      gcv_arb_min: 2000,
      gcv_arb_max: 2500,
      gcv_adb_min: 1000,
      gcv_adb_max: 1500,
      ncv_min: 1000,
      ncv_max: 1500,
      max_price: 20,
    },{
      id: 2,
      buyer_id: 2,
      company_name: 'PT. Master Batu Bara',
      order_date: '2008-12-01',
      volume: 2500,
      gcv_arb_min: 2000,
      gcv_arb_max: 2500,
      gcv_adb_min: 1100,
      gcv_adb_max: 1500,
      ncv_min: 1300,
      ncv_max: 1500,
      max_price: 10,
    }];
    
    $scope.sellOrders = [{
      id: 1,
      seller_id: 1,
      company_name: 'PT. Master Batu Bara',
      order_date: '2008-12-01',
      volume: 2500,
      gcv_arb_min: 2000,
      gcv_arb_max: 2500,
      gcv_adb_min: 1100,
      gcv_adb_max: 1500,
      ncv_min: 1300,
      ncv_max: 1500,
      max_price: 10,
    }];

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

}]);

angular.module('deal').controller('CreateSellModalController', function ($scope, $uibModalInstance, Deal, Order) {
  
  $scope.createSellOrder = function(order){
    $scope.sellOrders.push(order);
  };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('deal').controller('CreateBuyModalController', function ($scope, $uibModalInstance, Deal, Order) {
  
  $scope.createBuyOrder = function(order){
    $scope.buyOrders.push(order);
  };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('deal').controller('BuyModalController', function ($scope, $uibModalInstance, Deal, Order, Product) {
  
  console.log($scope.order);
  
  /*$scope.order = {
    id: 1,
    company_name: 'PT. Sinarmas Master Lain',
    order_date: '2008-10-01',
    volume: 1000,
    gcv_arb_min: 2000,
    gcv_arb_max: 2500,
    gcv_adb_min: 1000,
    gcv_adb_max: 1500,
    ncv_min: 1000,
    ncv_max: 1500,
    max_price: 20,
  };*/
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('deal').controller('SellModalController', function ($scope, $uibModalInstance, Deal, Order, Product) {
  
  console.log($scope.order);
  
  /*$scope.order = {
    id: 1,
    company_name: 'PT. Master Batu Bara',
    order_date: '2008-12-01',
    volume: 2500,
    gcv_arb_min: 2000,
    gcv_arb_max: 2500,
    gcv_adb_min: 1100,
    gcv_adb_max: 1500,
    ncv_min: 1300,
    ncv_max: 1500,
    max_price: 10,
  };*/
  
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