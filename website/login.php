<?php
namespace my_app;
use backendless\Backendless;
use backendless\model\BackendlessUser;
include "backendless/autoload.php";
include 'constant.php';

    if(isset($_COOKIE[$cookie_name]))
    {
        header("Location: complaints.php");
    } 
?>


<html>
<head>
	<title>SMC - Complaint Management System</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

   
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
	<link href="css/style.css" rel="stylesheet"/>
</head>

<body style="background:url(img/bg.jpg) no-repeat 0px 0px; background-size:cover;">

<div class="container row main">
	<!--login-head-start-->
    <div class="login-head"><h2>Solapur Municipal Coorporation</h2></div>
    <div class="sub-head"><h3>Complaint Management System</h3></div>
	<!--login head end-->

	<div class="col-md-12">
        <form action='login_fun.php' method="post">
        <input id="login" type="text" class="form" placeholder="Username" name="user">
        <input id="password" type="password" class="form" placeholder="Password" name="pass">

        <div class="submit">
            <button id="user_login" class="btnsk">LOG IN</button>
        </div>
        </form>
    </div>
        
</div>


<br><br>
<!--footer-start-->
<div class="footer">
<div class="container row">
    <div class="col-md-8 bt-logo"><a href="complaints.html"> <img src="img/logo.png" alt="smc-logo"></a></div>
    <div class="col-md-4 col-md-push-2">
    <p>Developed by : &nbsp;<a href="https://www.facebook.com/brainwavetechs/">Brain<span>Wave</span> Techs</a></p>
    </div>
</div>
</div>
<!--footer-end-->

</body>
</html>