/**
 * Created by stefvangils on 14/11/15.
 */
(function(){
    var app = angular.module('thesis', []);

    app.controller("CreationController", ['$scope', '$http', function($scope, $http) {


        var login = this;
        login.alreadyExists = false;
        $scope.submitForm = function () {
            var name = $scope.nameValue;
            data = {
                'name' : name
            };
            $http.post('../php/create.php', data)
                .success(function(data, status)
                {
                    console.log(data);
                    var status = data[0];

                    if(status == "SUCCESS"){
                        var appCode = data[1];
                        alert("The code of your app is: " + appCode);
                        window.location.replace('index.html');
                    }else {
                        login.alreadyExists = true;
                    }
                })
        }

    }]);




})();