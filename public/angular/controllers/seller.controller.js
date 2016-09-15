'use strict';

angular.module('seller').controller('SellerController', ['$scope', '$http', '$stateParams', '$state', '$timeout', '$location', 'Seller', 'Production', 'Product', 'Mine',
	function($scope, $http, $stateParams, $state, $timeout, $location, Seller, Production, Product, Mine) {
		$scope.sellers = [];
		$scope.seller = {};
		$scope.productButton = false;
		$scope.supply = {};

		$scope.today = function() {
			$scope.dt = new Date();
		};
		$scope.today();

		$scope.dateOptions = {
			formatYear: 'yyyy',
			startingDay: 1
		};

		$scope.open = function() {
			$scope.popup.opened = true;
		};

		$scope.popup = {
			opened: false
		};

		$scope.open2 = function() {
			$scope.popup2.opened = true;
		};

		$scope.popup2 = {
			opened: false
		};

		$scope.format = 'dd.MM.yyyy';

		$scope.create = function() {
			$scope.loading = true;

			var seller = new Seller({
				company_name: $scope.seller.company_name,
				email: $scope.seller.email,
				phone: $scope.seller.phone,
				web: $scope.seller.web,
				industry: $scope.seller.industry,
				city: $scope.seller.city,
				address: $scope.seller.address,
				latitude: $scope.seller.latitude,
				longitude: $scope.seller.longitude
			});

			seller.$save(function(response) {
        $('#createSellerModal').modal('hide');
        $('.modal-backdrop').hide();
        $scope.find()
				$scope.loading = false;
			});
		};

		$scope.createSupply = function() {
			$scope.loading = true;

			console.log($scope.supply);

			var supply = new Product({
				mine_id: $scope.supply.mine_id, 
				commercial_term: $scope.supply.commercial_term,
				ready_date: $scope.supply.ready_date,
				expired_date: $scope.supply.expired_date,

				tm_min: $scope.supply.tm_min,
				tm_max: $scope.supply.tm_max,
				tm_reject: $scope.supply.tm_reject,
				tm_bonus: $scope.supply.tm_bonus,
				im_min: $scope.supply.im_min,
				im_max: $scope.supply.im_max,
				im_reject: $scope.supply.im_reject,
				im_bonus: $scope.supply.im_bonus,
				ash_min: $scope.supply.ash_min,
				ash_max: $scope.supply.ash_max,
				ash_reject: $scope.supply.ash_reject,
				ash_bonus: $scope.supply.ash_bonus,
				fc_min: $scope.supply.fc_min,
				fc_max: $scope.supply.fc_max,
				fc_reject: $scope.supply.fc_reject,
				fc_bonus: $scope.supply.fc_bonus,
				vm_min: $scope.supply.vm_min,
				vm_max: $scope.supply.vm_max,
				vm_reject: $scope.supply.vm_reject,
				vm_bonus: $scope.supply.vm_bonus,
				ts_min: $scope.supply.ts_min,
				ts_max: $scope.supply.ts_max,
				ts_reject: $scope.supply.ts_reject,
				ts_bonus: $scope.supply.ts_bonus,
				ncv_min: $scope.supply.ncv_min,
				ncv_max: $scope.supply.ncv_max,
				ncv_reject: $scope.supply.ncv_reject,
				ncv_bonus: $scope.supply.ncv_bonus,
				gcv_arb_min: $scope.supply.gcv_arb_min,
				gcv_arb_max: $scope.supply.gcv_arb_max,
				gcv_arb_reject: $scope.supply.gcv_arb_reject,
				gcv_arb_bonus: $scope.supply.gcv_arb_bonus,
				gcv_adb_min: $scope.supply.gcv_adb_min,
				gcv_adb_max: $scope.supply.gcv_adb_max,
				gcv_adb_reject: $scope.supply.gcv_adb_reject,
				gcv_adb_bonus: $scope.supply.gcv_adb_bonus,
				hgi_min: $scope.supply.hgi_min,
				hgi_max: $scope.supply.hgi_max,
				hgi_reject: $scope.supply.hgi_reject,
				hgi_bonus: $scope.supply.hgi_bonus,
				size_min: $scope.supply.size_min,
				size_max: $scope.supply.size_max,
				size_reject: $scope.supply.size_reject,
				size_bonus: $scope.supply.size_bonus,

				volume: $scope.supply.volume
			});

			supply.$save(function(response) {
				$location.path('/trade/product');
				$scope.loading = false;
			});
		};
    
    $scope.update = function() {
			$scope.loading = true;
			$scope.seller.$update({ id: $scope.seller.id }, function(response) {
        $scope.error = undefined;
        if($scope.sellers !== undefined){
          for(var key in $scope.sellers){
            if($scope.sellers[key].id == $scope.seller.id){
              $scope.sellers[key] = $scope.seller;
              break;
            }
          }
          $('#updateSellerModal').modal('hide');
        }else{
          $state.go('seller.index');
        }
				$scope.loading = false;
      }, function(response){
        $scope.error = response.message;
        $scope.loading = false;
      });
		};
    
    $scope.deactivate = function(seller) {
			$scope.loading = true;
      var lvStatus = 'x';
      if(seller.status === 'x'){
        lvStatus = 'a';
      }

			Seller.get({ id: seller.id, action: 'deactivate', status: lvStatus }, function(response) {
				$state.go('seller.index');
				$scope.loading = false;
        buyer.status = lvStatus;
			});
		};

		$scope.delete = function(seller) {
			$scope.loading = true;

			Seller.delete({ id: seller.id }, function(response) {
				$scope.sellers.splice($scope.sellers.indexOf(seller), 1);
			}, function(err) {
				console.log(err);
			});
		};

		$scope.find = function() {
			$scope.sellers = Seller.query();
		};
    
    $scope.findProduction = function(id) {
			$scope.productions = Production.query({ action: 'seller', sellerId: id });
		};

	$scope.findOne = function(id) {
		if(id !== undefined) {
			$scope.sellerId = id;
		} else {
			$scope.sellerId = $stateParams.id;
		}

		$scope.seller = Seller.get({ id: $scope.sellerId });

		$scope.products = Product.query({ option: 'seller' , sellerId: id });

		$timeout(function() {
			$scope.render = true;
		}, 1000);
	};

	$scope.findMineBySeller = function(id) {
		$scope.mines = Mine.query({ action: 'seller', sellerId: id });
	}
    
    $scope.goToUpdatePopup = function(id){
      $scope.findOne(id);
      $('#sellerModal').modal('hide');
      $('#updateSellerModal').modal('show');
    };
    
    $scope.goToProductions = function(id){
      //$state.go('product');
      $('#sellerModal').modal('hide');
    };
    
    $scope.goToFulfillment = function(id){
      $state.go('order-fulfillment.historySeller', { sellerId: id });
      $('#sellerModal').modal('hide');
    };
}]);