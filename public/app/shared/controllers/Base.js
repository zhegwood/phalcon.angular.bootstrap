app.controller("Base", ["$rootScope", "$scope", "CallCenter", function($rootScope, $scope, CallCenter) {
	$scope.errorMessage = "";
	$scope.successMessage = "";

	$rootScope.$on("ajax_error", function(e, error) {
		$scope.errorMessage = error;
	});

	$rootScope.$on("ajax_success", function(e, success) {
		$scope.successMessage = success;
	});

	function getUser() {
		CallCenter.get("/ajax/user").then(function(data) {
			$rootScope.$broadcast("user", data.user);
		});
	}
	getUser();
	
}]);