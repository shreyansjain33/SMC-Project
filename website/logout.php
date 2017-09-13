<?php
namespace my_app;
 
use backendless\Backendless;
use backendless\model\BackendlessUser;


include "backendless/autoload.php";
include 'constant.php';


	Backendless::initApp( $id , $rest , $version );

	Backendless::$UserService->logout($user);
	setcookie($cookie_name, false);
	header("Location: login.php"); /* Redirect browser */
	

?>