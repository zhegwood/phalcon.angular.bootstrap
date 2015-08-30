app.controller("Login",["$scope","CallCenter","Util",function($scope,CallCenter,Util){

	$scope.user = {};
	$scope.loggingIn = false;
	
	$scope.login = function() {
		if (validLogin()) {
			$scope.loggingIn = true;
			CallCenter.post("/ajax/login",$scope.user, true).then(
				function(data){
					location.href = "/";
				},
				function(error) {
					$scope.loggingIn = false;
					Util.showError(error);
				}
			);
		}
	};
	
	function validLogin() {
		Util.showError("");
		var u = $scope.user;
		if (!u.email || u.email == "") {
			Util.showError("Email Address is required.");
			return false;
		}
		if (!u.password || u.password == "") {
			Util.showError("Password is required.");
			return false;
		}
		return true;
	}
}]);