app.controller("CreateAccount",["$scope","UserService",function($scope,UserService){
	
	$scope.user = {};
	$scope.signupSuccess = false;
	
	$scope.createAccount = function() {
		$scope.user.randomNum = $scope.randomNum;
		$scope.user.sliderValue = $scope.sliderValue;
		UserService.createAccount($scope.user,true).then(
			function(){
				$scope.signupSuccess = true;
			},
			function(error){
				$scope.newRandom();
			}
		);
	};
	
	$scope.validEmail = function() {
		UserService.validEmail($scope.user);
	};

}]);