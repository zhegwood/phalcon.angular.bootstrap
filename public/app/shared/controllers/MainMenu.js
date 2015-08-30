app.controller("MainMenu",["$scope","$rootScope",function($scope,$rootScope){
	$scope.user_loaded = false;
	
	$rootScope.$on("login",function(e,user){
		$scope.user = user;
	});
	
	$rootScope.$on("user",function(e,user){
		$scope.user_loaded = true;
		$scope.user = user;
	});
}]);