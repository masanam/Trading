'use strict';

angular.module('buyer').controller('BuyerController', ['$scope', '$http', '$stateParams', '$state', '$timeout', 'Buyer', 'Order', '$uibModal', 
	function($scope, $http, $stateParams, $state, $timeout, Buyer, Order, $uibModal) {
		$scope.buyers = [];
		$scope.buyer = {};
		$scope.demand = {};

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

			var buyer = new Buyer({
				company_name: $scope.buyer.company_name,
				email: $scope.buyer.email,
				phone: $scope.buyer.phone,
				web: $scope.buyer.web,
				industry: $scope.buyer.industry,
				city: $scope.buyer.city,
				address: $scope.buyer.address,
				latitude: $scope.buyer.latitude,
				longitude: $scope.buyer.longitude
			});

			buyer.$save(function(response) {
				//$state.go('buyer.index');
		        $('#createBuyerModal').modal('hide');
		        $('.modal-backdrop').hide();
		        $scope.find()
				$scope.loading = false;
			});
		};

		$scope.createDemand = function() {
			$scope.loading = true;

			console.log($scope.demand);

			var demand = new Order({
				buyer_id: $scope.buyer.id, 
				order_date: $scope.demand.order_date,
				deadline: $scope.demand.deadline,
				address: $scope.demand.address,
				latitude: $scope.demand.latitude,
				longitude: $scope.demand.longitude,

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

				volume: $scope.demand.volume
			});

			demand.$save(function(response) {
				$location.path('/trade/order/history');
				$scope.loading = false;
			});
		};

		$scope.update = function() {
			$scope.loading = true;
			$scope.buyer.$update({ id: $scope.buyer.id }, function(response) {
        $scope.error = undefined;
        if($scope.buyers !== undefined){
          for(var key in $scope.buyers){
            if($scope.buyers[key].id == $scope.buyer.id){
              $scope.buyers[key] = $scope.buyer;
              break;
            }
          }
          $('#updateBuyerModal').modal('hide');
        }else{
          $state.go('buyer.index');
        }
				$scope.loading = false;
      }, function(response){
        $scope.error = response.message;
        $scope.loading = false;
      });
		};
    
    $scope.deactivate = function(buyer) {
			$scope.loading = true;
      var lvStatus = 'x';
      if(buyer.status === 'x'){
        lvStatus = 'a';
      }

			Buyer.get({ id: buyer.id, action: 'deactivate', status: lvStatus }, function(response) {
				$state.go('buyer.index');
				$scope.loading = false;
        buyer.status = lvStatus;
			});
		};

		$scope.delete = function(buyer) {
			$scope.loading = true;

			Buyer.delete({ id: buyer.id }, function(response) {
				$scope.buyers.splice($scope.buyers.indexOf(buyer), 1);
			}, function(err) {
				console.log(err);
			});
		};
    
    $scope.findAttachedUsers = function() {
		for(var i = 0; i < $scope.buyer.user.length; i++) {
			$scope.selectedUsers.unshift($scope.buyer.user[i]);
		}
	};

	$scope.findUser = function() {
		$scope.users = User.query();
	};

	$scope.findTraders = function() {
		$scope.traders = User.query({ roles: 'trader' });
	}

	$scope.find = function() {
		$scope.buyers = Buyer.query();
	};

	$scope.findOne = function(id) {
		$scope.render = false;

		if(id !== undefined){
			$scope.buyerId = id;
		} else {
			$scope.buyerId = $stateParams.id;
		}

		$scope.buyer = Buyer.get({ id: $scope.buyerId });
		$scope.lastOrders = Order.query({ action: 'lastOrder', buyerId: $scope.buyerId });
		$scope.pendingOrders = Order.query({ action: 'lastOrder' });

		$timeout(function() {
			$scope.render = true;
		}, 1000);
	};
    
    $scope.goToUpdatePopup = function(id){
      $scope.findOne(id);
      $('#buyerModal').modal('hide');
      $('#updateBuyerModal').modal('show');
    };
    
    $scope.goToLastOrders = function(id){
      $('#buyerModal').modal('hide');
      $('.modal-backdrop').hide();
      $state.go('order.viewBuyer', { buyerId: id });
    };
    
    $scope.goToPendingOrders = function(id){
      $('#buyerModal').modal('hide');
      $('.modal-backdrop').hide();
      $state.go('order-buyer.viewBuyer', { buyerId: id });
    };

	}
]);