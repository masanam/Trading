'use strict';

angular.module('buyer').controller('BuyerController', ['$scope', '$http', '$stateParams', '$state', '$timeout', 'Buyer', 'Order', 'Factory', 'Port', 'Product', '$uibModal', 'Contact', 'User','$location',
  function($scope, $http, $stateParams, $state, $timeout, Buyer, Order, Factory, Port, Product, $uibModal, Contact, User, $location) {
    $scope.buyers = [];
    $scope.buyer = {};
    $scope.demand = {};
    $scope.product = {};
    $scope.new = $location.search().new;
    $scope.id = $stateParams.id;

    $scope.today = function() {
      $scope.dt = new Date();
    };
    $scope.today();

    $scope.dateOptions = {
      formatYear: 'yyyy',
      startingDay: 1
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

    $scope.data = {
      availableOptions: [
        { id: 'TT', name: 'TT' },
        { id: 'LC on Sight f', name: 'LC on Sight' },
        { id: 'LC on 30 days', name: 'LC on 30 days' }
      ],
 
    };

    $scope.format = 'dd.MM.yyyy';

    $scope.create = function() {
      $scope.loading = true;

      var buyer = new Buyer({
        company_name: $scope.buyer.company_name,
        is_trader: $scope.buyer.is_trader,
        is_affiliated: $scope.buyer.is_affiliated,
        phone: $scope.buyer.phone,
        email: $scope.buyer.email,
        web: $scope.buyer.web,
        address: $scope.buyer.address,
        city: $scope.buyer.city,
        country: $scope.buyer.country,
        latitude: $scope.buyer.latitude,
        longitude: $scope.buyer.longitude,
        industry: $scope.buyer.industry,
        annual_demand: $scope.buyer.annual_demand,
        preferred_trading_term: $scope.buyer.preferred_trading_term,
        preferred_payment_term: $scope.buyer.preferred_payment_term,
        description: $scope.buyer.description 
      });

      buyer.$save(function(response) {
        $location.path('lead/buyer/'+response.id+'/setup-product');
        // $('#createBuyerModal').modal('hide');
        // $('.modal-backdrop').hide();
        $scope.findOne();
        $scope.loading = false;
      });
    };

    $scope.backToFactory = function(){
      $location.path('lead/buyer/setup-factory/'+$stateParams.id);
    };

    $scope.nextToFactory = function(){
      $location.path('lead/buyer/setup-factory/'+$scope.buyer.selected.id);
    };

    $scope.nexToPort = function(){
      console.log($scope.product.selected);
      if ($scope.product.selected) {
        $location.path('lead/port/buyer/'+$stateParams.id);
      }else{
        $scope.error = 'Please Select A Product or Create New product';
      }
    };

    $scope.findMyProductsBuyer = function() {
      $scope.products = Product.query({ id:$stateParams.id, action:'my', type:'buyer' }, function(products){
        if(products.length === 0){
          $scope.addProduct();
        }
      });
    };

    $scope.findAllBuyers = function() {
      $scope.buyers = Buyer.query();
    };

    $scope.findAllProducts = function() {
      $scope.products = Product.query();
    };

    $scope.openCreateBuyerModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/buyer/create.modal.view.html',
        controller: 'BuyerModalController',
        scope: $scope,
      });
    };

    $scope.update = function() {
      $scope.loading = true;
      $scope.buyer.$update({ id: $scope.buyer.id }, function(response) {
        $scope.error = undefined;
        if($scope.buyers !== undefined){
          for(var key in $scope.buyers){
            if($scope.buyers[key].id === $scope.buyer.id){
              $scope.buyers[key] = $scope.buyer;
              break;
            }
          }
          $state.go('lead.buyer');
        }else{
          $state.go('lead.buyer');
        }
        $scope.loading = false;
      }, function(response){
        $state.go('lead.buyer');
        $scope.error = response.message;
        $scope.loading = false;
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
    };

    $scope.find = function() {
      $scope.buyers = Buyer.query({ q: $stateParams.keyword });
    };

    $scope.findOne = function(id) {
      $scope.render = false;

      if(id !== undefined){
        $scope.buyerId = id;
      } else {
        $scope.buyerId = $stateParams.id;
      }

      $scope.buyer = Buyer.get({ id: $scope.buyerId });
      console.log($scope.buyer);
      $scope.lastOrders = Order.query({ option: 'lastOrders' , type: 'buyer', id: $scope.buyerId });
      /*$scope.pendingOrders = Order.query({ action: 'lastOrder' });*/

      $timeout(function() {
        $scope.render = true;
      }, 1000);
    };
    
    $scope.goToUpdatePopup = function(id){
      $scope.findOne(id);
      // $('#buyerModal').modal('hide');
      // $('#updateBuyerModal').modal('show');
    };
    
    $scope.goToLastOrders = function(id){
      // $('#buyerModal').modal('hide');
      // $('.modal-backdrop').hide();
      $state.go('history-order.index');
    };
    
    $scope.goToPendingOrders = function(id){
      // $('#buyerModal').modal('hide');
      // $('.modal-backdrop').hide();
      $state.go('order-buyer.viewBuyer', { buyerId: id });
    };

    $scope.addContact = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/contact/create-from-buyer.view.html',
        controller: 'CreateContactModalFormBuyerController',
        scope: $scope,
      });
    };
    
    $scope.deleteContact = function(contact){
      Contact.delete({ id: contact.id }, function (response) {
        $scope.contact = response;
        
        $scope.buyer.contact.splice($scope.buyer.contact.indexOf(contact), 1);
        //$scope.close();
        $scope.success = true;
      }, function (response) {
        $scope.error = response.data.message;
      });
    };
    
    $scope.addProduct = function () {
      
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/product/create-from-buyer.view.html',
        controller: 'CreateProductModalFromBuyerController',
        scope: $scope,
      });
    };

    $scope.addFactory = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/factory/create.view.html',
        controller: 'CustomerFactoryModalController',
        scope: $scope
      });
    };

    $scope.viewProduct = function (product) {
      
      var modalInstance = $uibModal.open({
        windowClass: 'sm-modal',
        templateUrl: './angular/lead/views/product/view-from-buyer.html',
        controller: 'ViewProductModalFromBuyerController',
        scope: $scope,
      });
    };

    $scope.deleteFactory = function(factory){
      Factory.delete({ id: factory.id }, function (response) {
        $scope.factory = response;
        
        $scope.buyer.factory.splice($scope.buyer.factory.indexOf(factory), 1);
        $scope.success = true;
      }, function (response) {
        $scope.error = response.data.message;
      });
    };
    
    $scope.deleteProduct = function(product){
      Product.delete({ id: product.id }, function (response) {
        $scope.product = response;
        
        $scope.buyer.product.splice($scope.buyer.product.indexOf(product), 1);
        $scope.close();
        $scope.success = true;
      }, function (response) {
        $scope.error = response.data.message;
      });
    };
  }
]);

//controller Create Buyer Modal
angular.module('deal').controller('BuyerModalController', function ($scope, $uibModalInstance, $timeout, $interval, Buyer, $location) {
  
  $scope.create = function(createBuyer) {
    $scope.loading = true;
    var buyer = new Buyer($scope.buyer);

    buyer.$save(function(response) {
      $scope.progress = 0;
      $scope.success = true;
      var stop = $interval(function() {
        if ($scope.progress >= 0 && $scope.progress < 100) {
          $scope.progress++;
        } else {
          $interval.cancel(stop);
          stop = undefined;
          $location.path('lead/buyer/setup-factory/'+response.id).search({ new: 'true' });
          $uibModalInstance.close();
        }
      }, 75);
      // $location.path('lead/buyer/'+response.id+'/setup-product').search({ new: 'true' });
      // $uibModalInstance.close('success');
      $scope.loading = false;
    });
  };

  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});


angular.module('buyer').controller('CreateContactModalFormBuyerController', function ($scope, $filter, $uibModalInstance, Contact, Authentication, $stateParams) {
  
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
    $scope.contact.buyer_id = $stateParams.id;

    var contact = new Contact($scope.contact);
    
    contact.$save(function (response) {
      $scope.contact = response;
      
      $scope.buyer.contact.push($scope.contact);
      $uibModalInstance.close('success');
      $scope.success = true;
    }, function (response) {
      $scope.error = response.data.message;
    });
    
  };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('buyer').controller('CreateProductModalFromBuyerController', function ($scope, $filter, $uibModalInstance, $interval, Product, Authentication, $location, $stateParams) {
  
  $scope.product = new Product();
  
  $scope.createProduct= function(){
    
    // $scope.success = $scope.error = null;
    //$scope.product.license_expired_date = $filter('date')($scope.product.license_expired_date, 'yyyy-MM-dd');

    var product = $scope.product;
    product.buyer_id = $scope.buyer.id;
    product.$save(function (response) {
      $scope.product = response;
      $scope.progress = 0;
      $scope.success = true;
      var stop = $interval(function() {
        if ($scope.progress >= 0 && $scope.progress < 100) {
          $scope.progress++;
        } else {
          $interval.cancel(stop);
          stop = undefined;
          $location.path('lead/port/buyer/'+$stateParams.id).search({ new: $scope.new });
          $scope.close();
        }
      }, 75);
    }, function (response) {
      $scope.error = response.data.message;
    });
    
  };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

angular.module('buyer').controller('ViewProductModalFromBuyerController', function ($scope, $filter, $uibModalInstance, Product, Authentication) {
  
  $scope.product = new Product();
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

