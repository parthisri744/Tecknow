const DEFAULT_URL = "File/";
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
                $mdDialog.cancel();
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
                $mdDialog.cancel();
            }
        }
        $scope.fileupload = function(ev){
            $mdDialog.show({
                contentElement: '#fileupload',
                parent: angular.element(document.body),
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
          console.log("url"+DEFAULT_URL);
          $scope.getfiles = function(filename){  
            var filename = "img";          
          //  alert(fileurl+"Ajax Working");
            $http({
                url: "GetData.php",  
                dataType: 'json', 
                method: 'POST',
                data : {fileurl : filename}
            }).then(function (response) {
                console.log(response);
                $scope.files = response.data;
                console.log("reloading Successfully");
            })
        }
        $scope.fileclicked = function(filename){
           // alert(filename);
            var fileurl = DEFAULT_URL+filename;
            alert(fileurl);
        }
        // $scope.fileupload = function(ev){
        //     $mdDialog.show({
        //         templateUrl: 'Fileupload.html',
        //         parent: angular.element(document.body),
        //         targetEvent: ev,
        //         clickOutsideToClose: false
        //       }).then(function (answer) {
        //         $scope.status = 'You said the information was "' + answer + '".';
        //       }, function () {
        //         $scope.status = 'You cancelled the dialog.';
        //       });
        // }
        $scope.filecopy = function(){
            alert(" copy Clicked");
        }
        $scope.filecut = function(){
            alert(" cut Clicked");
        }
        $scope.filepaste = function(){
            alert(" paste Clicked");
        }
        // $scope.dircancel = function(){
        //     alert("cancel Clicked");
        // }
    
  }])
  
