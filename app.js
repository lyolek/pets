var app = angular.module('store', []);

app.controller('LoginCtrl', function ($scope, $http) {

    angular.element(document).ready(function () {
      $('.form-phone').mask('+38(000)000-00-00');
      $scope.initFill();
    });

    $scope.clickToLogout = function () { 
        $http.get('./services/doLogout.php').success(function(data, status) {
	  $scope.isLogged = false;
        })
    };
    $scope.clickToDoLogin = function () {
      $http.post('./services/doLogin.php', {login:$scope.inputLogin, pass:$scope.inputPassword})
      .success(function(data, status) {
	if(!data.error) {
	  $scope.initFill();
	}
      })
      .error(function(data, status) {
	console.log("error");
	console.log(data);
      });
    };
    $scope.initFill = function () {
      $http.get('./services/isLogged.php').success(function(data, status) {
	if(data.error) {
	  $scope.isLogged = false;
	} else {
	  $scope.isLogged = true;
	  $scope.clientName = data.name;
	}
      })
    };
});

app.controller('NavPanelController', function(){
  this.tab = 1;
  this.selectTab = function (setTab) {
    this.tab = setTab;
  };
  this.isSelected = function (checkTab) {
    return this.tab === checkTab;
  };
});

app.controller('ClientController', function($scope, $http, $q){
  $scope.mode = "search";
  $scope.setMode = function (setMode) {
    $scope.mode = setMode;
  };
  $scope.isSelected = function (checkMode) {
    return $scope.mode === checkMode;
  };
  $scope.submitSearch = function () {
    $http.post('./services/getClients.php', $scope.clientSearch)
    .success(function(data, status) {
      if(!data.error) {
	$scope.clientsFound = data;
      } else {
	console.log("not found");
	console.log(data.error);
      }
    })
    .error(function(data, status) {
      console.log("2-" + data.error);
    });
  };
  
  $scope.submitClient = function () {
    $http.post('./services/saveClient.php',$scope.saveClient)
    .success(function(data, status) {
      if(!data.error) {
	$scope.saveClient = {};
	$scope.showClientCard(data.id);
      } else {
	console.log("not saved");
	console.log(data.error);
      }
    })
    .error(function(data, status) {
      console.log("2-" + data.error);
    });
  };
  
  $scope.showClientCard = function (id) {
    console.log("showClientCard id=");
    console.log(id);
    $scope.setMode("clientCard");
    $scope.clientID = id;
    $http.post('./services/getClients.php', {"id" : id})
    .success(function(data, status) {
      if(!data.error) {
	$scope.clientID = data[0].id;
	$scope.clientFirstName = data[0].firstName + " " + data[0].lastName;
	$scope.clientPhone = data[0].phone1 + " " + data[0].phone2 + " " + data[0].phone3;
      } else {
	console.log("not found");
	console.log(data.error);
      }
    })
    .error(function(data, status) {
      console.log("2-" + data.error);
    });
  }
  
  $scope.editClientCard = function (id) {
    $scope.setMode('add');
    $http.post('./services/getClients.php', {"id" : id})
    .success(function(data, status) {
      if(!data.error) {
	
	$scope.client = {};
	$scope.saveClient = data[0];

      } else {
	console.log("not found");
	console.log(data.error);
      }
    })
    .error(function(data, status) {
      console.log("2-" + data.error);
    });
  }
});