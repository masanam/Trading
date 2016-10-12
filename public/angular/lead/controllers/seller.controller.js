'use strict';

angular.module('seller').controller('SellerController', ['$scope', '$http', '$stateParams', '$state', '$timeout', '$location', 'Seller', 'Production', 'Product', 'Mine', '$uibModal',
	function($scope, $http, $stateParams, $state, $timeout, $location, Seller, Production, Product, Mine, $uibModal) {
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

   

    $scope.openSellerModal = function (order) {
      
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/seller/create.seller.modal.html',
        scope: $scope,
        controller: 'CreateSellerModalController'
      });
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

		$scope.delete = function(seller) {
			$scope.loading = true;

			Seller.delete({ id: seller.id }, function(response) {
				$scope.sellers.splice($scope.sellers.indexOf(seller), 1);
			}, function(err) {
				console.log(err);
			});
		};

		$scope.find = function() {
			$scope.sellers = Seller.query({ action: 'search', search: $stateParams.keyword });
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

		//$scope.products = Product.query({ option: 'seller' , sellerId: id });

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
    
    $scope.addMine = function () {
      
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/mine/create-from-seller.view.html',
        controller: 'CreateMineModalController',
        scope: $scope,
      });
    };
    
    $scope.deleteMine = function(mine){
      Mine.delete({ id: mine.id }, function (response) {
        $scope.mine = response;
        
        $scope.seller.mine.splice($scope.seller.mine.indexOf(mine), 1);
        $scope.close();
        $scope.success = true;
      }, function (response) {
        $scope.error = response.data.message;
      });
    };

    $scope.deleteProduct = function(product){
      Product.delete({ id: product.id }, function (response) {
        $scope.product = response;
        
        $scope.seller.product.splice($scope.seller.product.indexOf(product), 1);
        $scope.close();
        $scope.success = true;
      }, function (response) {
        $scope.error = response.data.message;
      });
    };
    
    $scope.addContact = function () {
      
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/contact/create-from-seller.view.html',
        controller: 'CreateContactModalController',
        scope: $scope,
      });
    };
    
    $scope.deleteContact = function(contact){
      Contact.delete({ id: contact.id }, function (response) {
        $scope.contact = response;
        
        $scope.seller.contact.splice($scope.seller.contact.indexOf(contact), 1);
        $scope.close();
        $scope.success = true;
      }, function (response) {
        $scope.error = response.data.message;
      });
    };
    
    $scope.addProduct = function () {
      
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/product/create-from-seller.view.html',
        controller: 'CreateProductModalController',
        scope: $scope,
      });
    };
    
    $scope.deleteProduct = function(product){
      Product.delete({ id: product.id }, function (response) {
        $scope.product = response;
        
        $scope.seller.product.splice($scope.seller.product.indexOf(product), 1);
        $scope.close();
        $scope.success = true;
      }, function (response) {
        $scope.error = response.data.message;
      });
    };




}]);

angular.module('seller').controller('CreateSellerModalController', function ($scope, $filter, $uibModalInstance, Seller) {
  
  $scope.initializeOrder = function(){
    $scope.seller = {
      id: undefined,
      company_name: undefined,
      email: undefined,
      phone: undefined,
      industry: undefined,
      web: undefined,
      city: undefined,
      address: undefined,
      latitude: undefined, 
      longitude: undefined,
      description: undefined,
      
    };
  };

    $scope.validationOptions = {
        rules: {
            email: {
                required: true,
                email: true
            },
            company_name: {
                required: true
            },
            phone: {
                required: true
            },
            industry: {
                required: true
            },
            web: {
                required: true
            },
            city: {
                required: true
            },
             address: {
                required: true
            },
            latitude: {
                required: true
            },
            longitude: {
                required: true
            },
            description: {
                required: true
            }
        },
        messages: {
            email: {
                required: "We need your email address to contact you",
                email: "Your email address must be in the format of name@domain.com"
            },

            company_name: "field not be empty",
            phone: "field not be empty",
            industry: "field not be empty",
            web: "field not be empty",
            city: "field not be empty",
            address: "field not be empty",
            latitude: "field not be empty",
            longitude: "field not be empty",
            description: "field not be empty",

        }
    }


  $scope.createSeller = function (creteSeller) {
    var seller = new Seller($scope.seller);

    seller.$save(function(response) {
      $scope.sellers.push(response);
      $uibModalInstance.close('success');
      $scope.loading=false;
    });
 };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});


angular.module('seller').controller('CreateContactModalController', function ($scope, $filter, $uibModalInstance, Contact, Authentication) {
  
  $scope.initializeContact = function(){
    $scope.contact = {
      id: undefined,
      user_id: undefined,
      buyer_id: undefined,
      seller_id: undefined,
      name: undefined,
      phone: undefined,
      email: undefined,
      status: undefined,
    };
  };
  
  $scope.createContact = function(){
    
    $scope.success = $scope.error = null;
    
    $scope.contact.user_id = Authentication.user.id;
    $scope.contact.seller_id = $scope.seller.id;

    var contact = new Contact($scope.contact);
    
    contact.$save(function (response) {
      $scope.contact = response;
      
      $scope.seller.contact.push($scope.contact);
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


angular.module('seller').controller('CreateMineModalController', function ($scope, $filter, $uibModalInstance, Mine, Authentication) {
  
  $scope.initializeMine = function(){
    $scope.mine = {
      id: undefined,
      seller_id: undefined,
      mine_name: undefined,
      port_name: undefined,
      longitude: undefined,
      latitude: undefined,
      mineable_reserve: undefined,
      stripping_ratio: undefined,
      port_distance: undefined,
      road_capacity: undefined,
      river_capacity: undefined,
      license_expired_date: undefined,
      license_type: undefined,
    };
  };
  
  $scope.createMine = function(){
    
    $scope.success = $scope.error = null;
    $scope.mine.license_expired_date = $filter('date')($scope.mine.license_expired_date, "yyyy-MM-dd");
    $scope.mine.seller_id = $scope.seller.id;

    var mine = new Mine($scope.mine);
    
    mine.$save(function (response) {
      $scope.mine = response;
      
      $scope.seller.mine.push($scope.mine);
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