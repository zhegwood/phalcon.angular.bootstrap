app.controller("LoginController",["$scope","UserService",function($scope,UserService){

	$scope.user = {};
	
	$scope.login = function() {
		UserService.login($scope.user).then(
			function(data) {
				location.href = "/secure";
			}
		);
	};

}]);