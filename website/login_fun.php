<?php
namespace my_app;
 
use backendless\Backendless;
use backendless\model\BackendlessUser;

include "backendless/autoload.php";
include 'constant.php';

	Backendless::initApp( $id , $rest , $version );
	$user= new BackendlessUser();
	$usr = $_POST["user"];
	$pass = $_POST["pass"];
	setcookie($cookie_name, $cookie_val );

	if ($user = Backendless::$UserService->login( $usr, $pass)) {
		$cookie_val=true;
		setcookie($cookie_name, $cookie_val);
		header("Location: complaints.php"); /* Redirect browser */
	}
	else
	{
		$cookie_val=false;
		setcookie($cookie_name, $cookie_val);
		header("Location: login.php"); /* Redirect browser */
	}	
?>