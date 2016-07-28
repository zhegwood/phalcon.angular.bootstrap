var app = angular.module("Bootstrap",[
	"Bootstrap.directives",
	"ngSanitize"
]);

app.run(function($rootScope,CallCenter){
	$rootScope.processing = false;
	$rootScope.errorMessage = "";
	$rootScope.successMessage = "";
	$rootScope.user_loaded = false;
	
	CallCenter.get("/ajax/user").then(function(data) {
		$rootScope.user = data.user;
		$rootScope.user_loaded = true;
	});
});