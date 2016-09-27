'use strict';

angular.module('vendor').controller('VendorController', ['$scope', '$http', '$stateParams', '$state', 'Vendor', 'Order', '$uibModal', 
	function($scope, $http, $stateParams, $state, Vendor, Order, $uibModal) {
		$scope.vendors = [];
		$scope.vendor = {};

		$scope.create = function() {
			$scope.loading = true;

			var vendor = new Vendor({
				company_name: $scope.vendor.company_name,
				email: $scope.vendor.email,
				phone: $scope.vendor.phone,
				web: $scope.vendor.web,
				industry: $scope.vendor.industry,
				city: $scope.vendor.city,
				address: $scope.vendor.address,
				latitude: $scope.vendor.latitude,
				longitude: $scope.vendor.longitude
			});

			vendor.$save(function(response) {
				//$state.go('vendor.index');
        $('#createVendorModal').modal('hide');
        $('.modal-backdrop').hide();
        $scope.find()
				$scope.loading = false;
			});
		};

		$scope.update = function() {
			$scope.loading = true;
			$scope.vendor.$update({ id: $scope.vendor.id }, function(response) {
        $scope.error = undefined;
        if($scope.vendors !== undefined){
          for(var key in $scope.vendors){
            if($scope.vendors[key].id == $scope.vendor.id){
              $scope.vendors[key] = $scope.vendor;
              break;
            }
          }
          $('#updateVendorModal').modal('hide');
        }else{
          $state.go('vendor.index');
        }
				$scope.loading = false;
      }, function(response){
        $scope.error = response.message;
        $scope.loading = false;
      });
		};
    
    $scope.deactivate = function(vendor) {
			$scope.loading = true;
      var lvStatus = 'x';
      if(vendor.status === 'x'){
        lvStatus = 'a';
      }

			Vendor.get({ id: vendor.id, action: 'deactivate', status: lvStatus }, function(response) {
				$state.go('vendor.index');
				$scope.loading = false;
        vendor.status = lvStatus;
			});
		};

		$scope.delete = function(vendor) {
			$scope.loading = true;

			Vendor.delete({ id: vendor.id }, function(response) {
				$scope.vendors.splice($scope.vendors.indexOf(vendor), 1);
			}, function(err) {
				console.log(err);
			});
		};
    
    $scope.findAttachedUsers = function() {
			for(var i = 0; i < $scope.vendor.user.length; i++) {
				$scope.selectedUsers.unshift($scope.vendor.user[i]);
			}
		};

		$scope.findUser = function() {
			$scope.users = User.query();
		};

		$scope.findTraders = function() {
			$scope.traders = User.query({ roles: 'trader' });
		}

		$scope.find = function() {
			$scope.vendors = Vendor.query({ action: 'search', search: $stateParams.keyword });
		};

		$scope.findOne = function(id) {
      if(id !== undefined){
        $scope.vendorId = id;
      }else{
        $scope.vendorId = $stateParams.id;
      }
			$scope.vendor = Vendor.get({ id: $scope.vendorId });
      $scope.lastOrders = Order.query({ action: 'lastOrder', vendorId: $scope.vendorId });
      $scope.pendingOrders = Order.query({ action: 'pendingOrder', vendorId: $scope.vendorId });
		};
    
    $scope.goToUpdatePopup = function(id){
      $scope.findOne(id);
      $('#vendorModal').modal('hide');
      $('#updateVendorModal').modal('show');
    };
    
    $scope.goToLastOrders = function(id){
      $('#vendorModal').modal('hide');
      $('.modal-backdrop').hide();
      $state.go('order-history.viewVendor', { vendorId: id });
    };
    
    $scope.goToPendingOrders = function(id){
      $('#vendorModal').modal('hide');
      $('.modal-backdrop').hide();
      $state.go('order-vendor.viewVendor', { vendorId: id });
    };
    
	}
]);