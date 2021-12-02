<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<!DOCTYPE html>
<html ng-app="TestApp" ng-controller="TestCtrl">
<head>
    <!-- <link href="../contents/bootstrap.css" rel="stylesheet" /> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" />
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular.min.js" integrity="sha512-7oYXeK0OxTFxndh0erL8FsjGvrl2VMDor6fVqzlLGfwOQQqTbYsGPv4ZZ15QHfSk80doyaM0ZJdvkyDcVO7KFA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-route/1.8.2/angular-route.min.js" integrity="sha512-5zOAub3cIpqklnKmM05spv4xttemFDlbBrmRexWiP0aWV8dlayEGciapAjBQWA7lgQsxPY6ay0oIUVtY/pivXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Sweet Alert Scripts-->


    <meta charset="utf-8" />
    <base href="/" />
    <title></title>
</head>
<body>
    <select ng-model="selectedOption" ng-change="testchange()" wb-select2 select-width="300px">
        <option ng-repeat="(k, v) in optionList" value="{{k}}">{{v}}</option>
    </select>
    <button ng-click="changeModelOutside()">Click me</button>
    {{selectedOption}}
    <br/> <br/> <br/> <br/>
</body>
</html>

  <script>
var app = angular.module('TestApp',[]);

app.controller('TestCtrl', function ($scope) {
        $scope.optionList = {
            '1': 'parthi',
            '2': 'parthisri',
            '3': 'parthiban',
            '4': 'riya24'
        };
        $scope.testchange = function(){
           console.log("Select Clicked"+$scope.selectedOption);
        }
        $scope.selectedOption = '1';
        $scope.changeModelOutside = function () {
           console.log("BTN CLICKED");
            $scope.selectedOption = '4';
        };
   
});

app.directive('wbSelect2', function () {
    return {
        restrict: 'A',
        scope: {
            'selectWidth': '@',
            'ngModel': '='
        },
        link: function (scope, element, attrs) {
            //Setting default values for attribute params
            scope.selectWidth = scope.selectWidth || 200;
            element.select2({
                width: scope.selectWidth,
            });

            scope.$watch('ngModel', function (newVal, oldVal) {
                window.setTimeout(function () {
                    element.select2("val", newVal);
                });
            });
        }
    };
});

app.directive('wbSelect3', function () {
    return {
        restrict: 'A',
        scope: {
            'selectWidth': '@',
            'ngModel': '='
        },
        link: function (scope, element, attrs) {
            //Setting default values for attribute params
            scope.selectWidth = scope.selectWidth || 200;
            element.select2({
                width: scope.selectWidth,
            });

            scope.$watch('ngModel', function (newVal, oldVal) {
                window.setTimeout(function () {
                    element.select2("val", newVal);
                });
            });
        }
    };
});
  </script>
</body>
</html>