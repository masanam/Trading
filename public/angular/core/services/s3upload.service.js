'use strict';

angular.module('index').service('S3Upload', ['$http', 'Upload',
  function ($http, Upload) {
    var self = this;

    this.signing = function (filename, folder, type, callback){
      var request = {
        filename: filename,
        folder: folder,
        type: type
      };

      //get signing from server side
      $http.post('api/signing', request).success(function(signing) {
        return callback(undefined, signing);
      }).error(function(err) {
        return callback(err, undefined);
      });
    };

    this.send = function (signing, files, callback){
      Upload.upload({
        url: signing.url, //s3Url
        fields: signing.fields, //credentials
        transformRequest: function(data, headersGetter) {
          var headers = headersGetter();
          delete headers.Authorization;
          return data;
        },
        skipAuthorization: true,
        method: 'POST',
        file: files
      }).success(function(data, status, headers, config) {
        // file is uploaded successfully, return no error
        return callback(undefined, data, config);
      }).error(function(err) {
        //file upload failed, return no data
        return callback(err, undefined, undefined);
      });
    };
    
    //upload = sign, then send
    this.upload = function (files, filename, folder, callback){
      //sign file before uploading
      this.signing(filename, folder, files.type, function(err, signing){
        //return error message if failed to get signing
        if(err) return callback(err);

        //upload if no error
        return self.send(signing, files, callback);
      });
    };

    this.replace = function (files, url, folder, callback){
      //get filename
      var filename = url.substr(url.lastIndexOf('/')+1);

      //sign the file before uploading
      this.signing(filename, folder, function(err, signing, files){
        //return error message if failed to get signing
        if(err) return callback(err);
        
        //upload if no error
        return self.send(signing, files, callback);
      });
    };
  }
]);