'use strict';

angular.module('order').controller('EditOrderDetailModalController', ['$uibModalInstance', '$scope', '$uibModal', 'Lead', 'Environment', 'Term', 'data', 
  function($uibModalInstance, $scope, $uibModal, Lead, Environment, Term, data) {
    $scope.lead = data;
    $scope.tradingTerm = Term.trading;
    $scope.paymentTerm = Term.payment;
    $scope.productQuality = Environment.productQuality;

    if(Environment.productQuality !== 'typical'){
      $scope.lead.gcv_adb_min = data.gcv_adb_min;
      $scope.lead.gcv_adb_max = data.gcv_adb_max;
      $scope.lead.gcv_arb_min = data.gcv_arb_min;
      $scope.lead.gcv_arb_max = data.gcv_arb_max;
      $scope.lead.ncv_min = data.ncv_min;
      $scope.lead.ncv_max = data.ncv_max;
      $scope.lead.tm_min = data.tm_min;
      $scope.lead.tm_max = data.tm_max;
      $scope.lead.im_min = data.im_min;
      $scope.lead.im_max = data.im_max;
      $scope.lead.vm_min = data.vm_min;
      $scope.lead.vm_max = data.vm_max;
      $scope.lead.ash_min = data.ash_min;
      $scope.lead.ash_max = data.ash_max;
      $scope.lead.fc_min = data.fc_min;
      $scope.lead.fc_max = data.fc_max;
      $scope.lead.ts_min = data.ts_min;
      $scope.lead.ts_max = data.ts_max;
      $scope.lead.hgi_min = data.hgi_min;
      $scope.lead.hgi_max = data.hgi_max;
      $scope.lead.size_min = data.size_min;
      $scope.lead.size_max = data.size_max;
      $scope.lead.fe2o3_min = data.fe2o3_min;
      $scope.lead.fe2o3_max = data.fe2o3_max;
      $scope.lead.aft_min = data.aft_min;
      $scope.lead.aft_max = data.aft_max;
      $scope.lead.na2o_min = data.na2o_min;
      $scope.lead.na2o_max = data.na2o_max;
    }else{
      $scope.lead.gcv_adb_min = data.gcv_adb_min;
      $scope.lead.gcv_adb_max = $scope.lead.gcv_adb_min;
      $scope.lead.gcv_arb_min = data.gcv_arb_min;
      $scope.lead.gcv_arb_max = $scope.lead.gcv_arb_min;
      $scope.lead.ncv_min = data.ncv_min;
      $scope.lead.ncv_max = $scope.lead.ncv_min;
      $scope.lead.tm_min = data.tm_min;
      $scope.lead.tm_max = $scope.lead.tm_min;
      $scope.lead.im_min = data.im_min;
      $scope.lead.im_max = $scope.lead.im_min;
      $scope.lead.vm_min = data.vm_min;
      $scope.lead.vm_max = $scope.lead.vm_min;
      $scope.lead.ash_min = data.ash_min;
      $scope.lead.ash_max = $scope.lead.ash_min;
      $scope.lead.fc_min = data.fc_min;
      $scope.lead.fc_max = $scope.lead.fc_min;
      $scope.lead.ts_min = data.ts_min;
      $scope.lead.ts_max = $scope.lead.ts_min;
      $scope.lead.hgi_min = data.hgi_min;
      $scope.lead.hgi_max = $scope.lead.hgi_min;
      $scope.lead.size_min = data.size_min;
      $scope.lead.size_max = $scope.lead.size_min;
      $scope.lead.fe2o3_min = data.fe2o3_min;
      $scope.lead.fe2o3_max = $scope.lead.fe2o3_min;
      $scope.lead.aft_min = data.aft_min;
      $scope.lead.aft_max = $scope.lead.aft_min;
      $scope.lead.na2o_min = data.na2o_min;
      $scope.lead.na2o_max = $scope.lead.na2o_min;
    }

    $scope.submitEdit = function () {
      var f = document.getElementsByTagName('form')[0];
      if(f.checkValidity()) {
        var lead = new Lead($scope.lead);

        lead.$update(function(res) {
          console.log(res);
          $uibModalInstance.close(res);
        });

      }
    };

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);