var app = angular.module('codedrive', ['ngMaterial', 'ngMessages'])
.config(['$mdThemingProvider', function ($mdThemingProvider) {
    'use strict';
    $mdThemingProvider
    // .registerStyles('Style.css')
    .theme('default')
    .primaryPalette('blue')
    .accentPalette('blue')
    .warnPalette('blue')
    .backgroundPalette('grey');
}])
.controller('codedriveCtrl', ['$scope', '$mdSidenav','$mdDialog','$mdToast','$http',function($scope, $mdSidenav,$mdDialog,$mdToast,$http){
    $scope.navbar = [{
      title: "About",
      href : "#/about",
      icon : "public"
    },{
      title: "Contact",
      href : "#/contact",
      icon : "contacts"
    },{
      title: "Account",
      href : "#/service",
      icon : "account_circle"
    }];
    app.config(function($routeProvider) {
      $routeProvider.when("/", {
          templateUrl : "Home.html"
      });
    });
    $scope.toggleRight = function(navID){
      $mdSidenav(navID)
            .toggle()
            .then(function () {
              console.log("toggle " + navID + " is done");
            });
    };
        $scope.toggleSidenav = function(){
          $mdSidenav('left').toggle();
        }
        // $scope.status = '  ';
        // $scope.customFullscreen = true;
        $scope.createfolder = function(ev){
            $mdDialog.show({
                contentElement: '#createfolder',
                parent: angular.element(document.body),
                targetEvent: ev,
                clickOutsideToClose: false,
                escapeToClose:true,
              });
              $scope.dircancel = function(){
                $scope.foldername="";
                $mdDialog.cancel();
            }
              $scope.createnewfolder =  function(){
                $mdDialog.parent-$scope.foldername;
                console.log($scope.foldername);
                console.log($scope.currentdir);
                var message = '';
                $http({
                  url: "New.php?actionname=createfolder",  
                  dataType: 'json', 
                  method: 'POST',
                  data : {foldername : $scope.foldername,currentdir : $scope.currentdir}
              }).then(function (response) {
                console.log(response.data);
                if(response.data=='true'){
                  $scope.getfiles($scope.currentdir)
                  $scope.foldername="";
                  $scope.message='';
                  $scope.SimpleToast('Folder Created Successfully');
                  $mdDialog.cancel(); 
                }else{
                  $scope.message = "Folder Name Already Exists";
                  $scope.ErrorToast('Folder Name Already Exists');
                }
                $scope.messg = response.data;
              });
             }
        }
        $scope.createfile = function(ev){
            $mdDialog.show({
                contentElement: '#createfile',
                parent: angular.element(document.body),
                targetEvent: ev,
                clickOutsideToClose: false,
                escapeToClose:true,
              });
              $scope.dircancel = function(){
                $scope.filename="";
                $mdDialog.cancel();
            }  
            $scope.createnewfile =  function(){
              $mdDialog.parent-$scope.filename;
              console.log($scope.foldername);
              console.log($scope.currentdir);
              $http({
                url: "New.php?actionname=createfile",  
                dataType: 'json', 
                method: 'POST',
                data : {filename : $scope.filename,currentdir : $scope.currentdir}
            }).then(function (response) {
              console.log(response.data);
              var message = '';
              if(response.data=='true'){
                $scope.getfiles($scope.currentdir);
                $scope.filename="";
                $scope.SimpleToast('File Created Successfully');
                $scope.message='';
                $mdDialog.cancel(); 
              }else{
                $scope.message = "File Name Already Exists";
                $scope.ErrorToast('File Name Already Exists');
              }
            });
           }

        }
        $scope.deletefile =  function(){
          var checkedUsers = [];
          $scope.files.forEach(function(file) {
             if (file.option) {
               if(checkedUsers != ''){
               }
                checkedUsers.push(file.path);
             }
          });
           $scope.result = checkedUsers;
           var confirm = $mdDialog.confirm()
           .title('Would you like to delete ?')
           .textContent('Note : Once You Delete Your File/Directory It will Not Retrive for later use.')
           .ariaLabel('Lucky day')
           .ok('Delete!')
           .cancel('Cancel');
          $mdDialog.show(confirm).then(function () {
          $http({
            url: "New.php?actionname=deletefiles",  
            dataType: 'json', 
            method: 'POST',
            data : {deletepath : checkedUsers}
          }).then(function (response) {
            console.log(response.data);
            if(response.data=='true'){
              $scope.SimpleToast('File Deleted Successfully');
              $scope.getfiles($scope.currentdir);
            }else{
              $scope.ErrorToast('File Not Deleted ');
            }
          });
         }, function () {
           $scope.status = 'You decided to keep your debt.';
         });
            console.log(checkedUsers);
          }
          $scope.showConfirm = function(ev) {
          };
        $scope.fileupload = function(ev){
            $mdDialog.show({
                contentElement: '#fileupload',
                targetEvent: ev,
                clickOutsideToClose: false,
                escapeToClose:true,
              });
              $scope.dircancel = function(){
                $mdDialog.cancel();
            }
        }
        $scope.SimpleToast = function(msg) {
            $mdToast.show(
                $mdToast.simple()
                .textContent(msg+'!')
                .theme('success-toast')
                .position('top right')
                .hideDelay(3000));
          };
          $scope.ErrorToast = function(msg) {
            $mdToast.show(
                $mdToast.simple()
                .textContent(msg+'!')
                .theme('error-toast')
                .position('top right')
                .hideDelay(3000));
          };
          $scope.getfiles = function(filename){ 
            var arr = [];
            var currentdir='';
            $scope.currentdir = filename;
            var breadcrumb  = filename.split('/');
            var count  =  breadcrumb.length;
             link = "";
            for(var i=0;i<count;i++){
              if(!angular.isUndefined(breadcrumb[i]) && angular.isString(breadcrumb[i])){                
                arr.push({
                  link : link+=breadcrumb[i]+"/",
                  name : breadcrumb[i]
              });
              }
            }
            $scope.breadcrumb = arr.slice(4, 100);
            $scope.arr = arr.slice(5, 100);    
            console.log(arr);        
            $http({
                url: "New.php?actionname=getfolder",  
                dataType: 'json', 
                method: 'POST',
                data : {fileurl : filename}
            }).then(function (response) {
                console.log(response);
                $scope.files = response.data;
            });

        }
        $scope.filecopy = function(){
            alert(" copy Clicked");
        }
        $scope.filecut = function(){
            alert(" cut Clicked");
        }
        $scope.filepaste = function(){
            alert(" paste Clicked");
        }
        $scope.selectedRow = null;
        $scope.setClickedRow = function(index){  
        $scope.selectedRow = index;
        console.log("SELECTED :"+index);
        }
  }])
  
