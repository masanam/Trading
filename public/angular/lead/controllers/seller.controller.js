'use strict';

angular.module('seller').controller('SellerController', ['$scope', '$http', '$stateParams', '$state', '$timeout', '$location', 'Seller', 'Product', 'Concession', 'Contact', '$uibModal', 'Order',
  function($scope, $http, $stateParams, $state, $timeout, $location, Seller, Product, Concession, Contact, $uibModal, Order) {
    $scope.sellers = [];
    $scope.seller = {};
    $scope.productButton = false;
    $scope.supply = {};
    $scope.product = {};
    $scope.new = $location.search().new;


    $scope.nextToConcession= function(){
      console.log($scope.seller.selected);
      if ($scope.seller.selected) {
        $location.path('lead/seller/setup-concession-seller/'+$scope.seller.selected.id);
      }else{
        $scope.error = 'Please Select A Owner of Concession or Create New Owner of Concession';
      }
    };
    
    $scope.backToConcession= function(){
      $location.path('lead/seller/setup-concession-seller/'+$stateParams.id);
    };

    $scope.findAllProducts = function() {
      $scope.products = Product.query();
    };

    $scope.findMyProductsSeller = function() {
      $scope.products = Product.query({ id:$stateParams.id, action:'my', type:'seller' });
    };

    $scope.nexToPort= function(){
      console.log($scope.product.selected);
      if ($scope.product.selected) {
        $location.path('lead/port/seller/'+$stateParams.id);
      }else{
        $scope.error = 'Please Select A Product or Create New product';
      }
    };

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

    $scope.open1 = function() {
      $scope.popup1.opened = true;
    };

    $scope.setDate = function(year, month, day) {
      $scope.dt = new Date(year, month, day);
    };

    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[1];
    $scope.altInputFormats = ['M!/d!/yyyy'];

    $scope.popup1 = {
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

    $scope.findAllSellers = function() {
      $scope.sellers = Seller.query();
    };

    $scope.create = function() {
      $scope.loading = true;
      var seller = new Seller({
        company_name: $scope.seller.company_name,
        is_trader: $scope.seller.is_trader,
        is_affiliated: $scope.seller.is_affiliated,
        phone: $scope.seller.phone,
        email: $scope.seller.email,
        web: $scope.seller.web,
        address: $scope.seller.address,
        city: $scope.seller.city,
        country: $scope.seller.country,
        latitude: $scope.seller.latitude,
        longitude: $scope.seller.longitude,
        industry: $scope.seller.industry,
        total_annual_sales: $scope.seller.total_annual_sales,
        preferred_trading_term: $scope.seller.preferred_trading_term,
        preferred_payment_term: $scope.seller.preferred_payment_term,
        purchasing_countries: $scope.seller.purchasing_countries,
        description: $scope.seller.description 
      });

      seller.$save(function(response) {
        $state.go('lead.seller');
        // $('#createSellerModal').modal('hide');
        // $('.modal-backdrop').hide();
        $scope.find();
        $scope.loading = false;
      });
    };

    $scope.openModalNewSeller = function () {
      
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/seller/create.view.seller.html',
        scope: $scope,
        controller: 'CreateSellerModalController'
      });
    };

    $scope.createSupply = function() {
      $scope.loading = true;

      var supply = new Product($scope.supply);

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
            if($scope.sellers[key].id === $scope.seller.id){
              $scope.sellers[key] = $scope.seller;
              break;
            }
          }
          $state.go('lead.seller');
        }else{
          $state.go('lead.seller');
        }
        $scope.loading = false;
      }, function(response){
        $state.go('lead.seller');
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

    $scope.findOne = function(id) {
      if(id !== undefined) {
        $scope.sellerId = id;
      } else {
        $scope.sellerId = $stateParams.id;
      }

      $scope.seller = Seller.get({ id: $scope.sellerId });

      $scope.lastOrders = Order.query({ option: 'lastOrders' , type: 'seller', id: $scope.sellerId });
      
      //$scope.products = Product.query({ option: 'seller' , sellerId: id });

      $timeout(function() {
        $scope.render = true;
      }, 1000);
    };

    $scope.findConcessionBySeller = function(id) {
      $scope.concessions = Concession.query({ action: 'seller', sellerId: id });
    };
    
    $scope.goToUpdatePopup = function(id){
      $scope.findOne(id);
      // $('#sellerModal').modal('hide');
      // $('#updateSellerModal').modal('show');
    };
    
    $scope.goToProductions = function(id){
      //$state.go('product');
      // $('#sellerModal').modal('hide');
    };
    
    $scope.goToFulfillment = function(id){
      $state.go('order-fulfillment.historySeller', { sellerId: id });
      // $('#sellerModal').modal('hide');
    };
    
    $scope.goToLastOrders = function(id){
      $state.go('history-order.index');
      // $('#sellerModal').modal('hide');
    };
    
    $scope.addConcession = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/concession/create-from-seller.view.html',
        controller: 'CreateConcessionModalController',
        scope: $scope,
      });
    };
    
    $scope.deleteConcession = function(concession){
      Concession.delete({ id: concession.id }, function (response) {
        $scope.concession = response;
        
        $scope.seller.concession.splice($scope.seller.concession.indexOf(concession), 1);
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
        controller: 'CreateContactModalFromSellerController',
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
        controller: 'CreateProductModalFromSellerController',
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
  }
]);

angular.module('seller').controller('CreateSellerModalController', function ($scope, $filter, $location, $uibModalInstance, Seller) {
  
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

  $scope.createSeller = function () {
    $scope.seller.license_expiry_date = $filter('date')($scope.seller.license_expiry_date, 'yyyy-MM-dd');
    var seller = new Seller($scope.seller);

    seller.$save(function(response) {
      $location.path('lead/seller/setup-concession-seller/'+response.id).search({new: 'true'});
      $uibModalInstance.close('success');
      $scope.loading=false;
    });
  };
  
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});


angular.module('seller').controller('CreateContactModalFromSellerController', function ($scope, $filter, $uibModalInstance, Contact, Authentication) {
  
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

angular.module('seller').controller('CreateProductModalFromSellerController', function ($scope, $location, $stateParams, $filter, $uibModalInstance, Product, Authentication) {
  
  $scope.product = new Product();
    
  $scope.createProduct= function(){
    
    $scope.success = $scope.error = null;
    //$scope.product.license_expired_date = $filter('date')($scope.product.license_expired_date, 'yyyy-MM-dd');

    var product = $scope.product;
    product.seller_id = $scope.seller.id;
    
    product.$save(function (response) {
      $scope.product = response;
      $location.path('lead/port/seller/'+$stateParams.id).search({new: $scope.new});
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

angular.module('seller').controller('CreateConcessionModalController', function ($scope, $filter, $uibModalInstance, Concession, Authentication, NgMap) {
  
  $scope.concession = new Concession();
  
  $scope.initMap = function(){
    NgMap.getMap().then(function(map) {
      $scope.map = map;
    });
  };
  
  $scope.resetMap = function(){
    $scope.map.shapes.foo.setMap(null);
  };
  
  $scope.resetPolygon = function(e){
    $scope.initMap();
    $scope.polygon = {
      polygonString: '',
      array: [],
    };
  };
  
  $scope.resetPolygon();
  
  /*$scope.addMarkerAndPath = function(event) {
    $scope.polygon.push([event.latLng.lat(), event.latLng.lng()]);
  };*/
  
  $scope.updatePolygonString = function(polygonString){
    $scope.polygon.polygonString = polygonString;
    if($scope.polygon.polygonString !== ''){
      $scope.polygon.array = JSON.parse($scope.polygon.polygonString);
    }else{
      $scope.polygon.array = [];
    }
  };
  
  $scope.onMapOverlayCompleted = function(e){
    
    e.overlay.setMap(null);
    
    var coordinates = e.overlay.getPath().getArray();
    
    $scope.polygon.array = [];
    
    for(var idx=0; idx < coordinates.length; idx++){
      $scope.polygon.array.push([coordinates[idx].lat(), coordinates[idx].lng()]);
    }
    
    $scope.map.shapes.foo.setMap($scope.polygon.array);
    
    $scope.polygon.polygonString = createStringByArray($scope.polygon.array);
    
    //$scope.polygon = e;
  };
  
  function createStringByArray(array) {
    var output = '[';
    angular.forEach(array, function (object, keyObj) {
      output += '[';
      angular.forEach(object, function (value, key) {
        if(key === 0){
          output += value + ',';
        }else{
          output += value + '';
        }
      });
      if(keyObj === (array.length-1)){
        output += ']';
      }
      else{
        output += '],';
      }
    });
    output += ']';
    return output;
  }
  
  $scope.createConcession = function(){
    
    $scope.success = $scope.error = null;
    $scope.concession.license_expiry_date = $filter('date')($scope.concession.license_expiry_date, 'yyyy-MM-dd');
    $scope.concession.seller_id = $scope.seller.id;
    
    if($scope.polygon.array.length === 0){
      $scope.concession.polygon = createStringByArray($scope.polygon.array);
    }else{
      $scope.concession.polygon = '';
    }

    var concession = $scope.concession;
    
    concession.$save(function (response) {
      $scope.concession = response;
      
      $scope.seller.concession.push($scope.concession);
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