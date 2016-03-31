/**
 * Created by stefvangils on 14/11/15.
 */
(function(){
    var app = angular.module('thesis', []);

    app.controller("RegisterController", ['$scope', '$http', function($scope, $http) {
        $scope.submitForm = function () {
            var email = $scope.emailValue;
            var password = $scope.passwordValue;
            data = {
                'email' : email,
                'password' : password
            };
            $http.post('../php/authentication/register.php', data)
                .success(function(data, status)
                {
                    console.log(data);
                })
        }

    }]);




})();