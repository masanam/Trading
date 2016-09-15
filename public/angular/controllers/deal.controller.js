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
    
		$scope.deal = Deal.get;

    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/views/deal/modal.view.html',
        controller: 'DealModalController',
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