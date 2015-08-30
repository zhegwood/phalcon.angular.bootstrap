app.controller("CreateAccount",["$scope","Util","CallCenter",function($scope,Util,CallCenter){
	
	$scope.user = {};
	$scope.signupSuccess = false;
	$scope.saving = false;
	
	$scope.createAccount = function() {
		if (validUser()) {
			$scope.saving = true;
			CallCenter.post("/ajax/create-account",$scope.user,true).then(
				function(){
					$scope.signupSuccess = true;
				},
				function(error) {
					$scope.saving = false;
					Util.showError(error);
				}
			);
		}
	};
	
	$scope.validEmail = function() {
		var u = $scope.user;
		if (u.email && u.email != "") {
			CallCenter.post("/ajax/valid-email",u).then(
				function(data){
					if (data.user) {
						Util.showError("Email Address is taken.");
					}
				}
			);
		}
	}
	
	function validUser() {
		var u = $scope.user;

		if (!u.email || u.email == "") {
			Util.showError("Email Address is required.");
			return false;
		}
		if (!u.password || u.password == "") {
			Util.showError("Password is required.");
			return false;
		}
		if (!u.confirm || u.password != u.confirm) {
			Util.showError("Passwords do not match.");
			return false;
		}
		if ($scope.randomNum != $scope.sliderValue) {
			Util.showError("Please prove your humanity.");
			$scope.newRandom();
			return false;
		}
		if (!u.agree) {
			Util.showError("You must agree to the terms of service.");
			return false;
		}

		return true;
	}
}]);