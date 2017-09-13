<?php
namespace my_app;
 
use backendless\Backendless;
use backendless\model\BackendlessUser;
use my_app\Complaint;
use my_app\Callme;

include "backendless/autoload.php";
include 'Complaint.php';
include 'Constant.php';
//include 'callme.php';
session_start();
//$complaint = new complaint();
if(!isset($_COOKIE[$cookie_name]))
    {
        header("Location: login.php");
    }
Backendless::initApp( $id , $rest , $version );

$class_name='Complaint';
    $ice= $_SESSION["var"];
    for($j=1; $j<=$ice; $j++)
    {
      $string= 'submit'.$j;
      if(isset($_POST[$string]))
      {
        $complaint= Backendless::$Persistence->of( $class_name )->findById($_POST[$string]);
      }
    }

  $mil = $complaint['created'];
  $seconds = $mil / 1000;
  $date = date("d-M-Y", $seconds);
  $words = explode('-', $date);
  $year = array_pop($words);
  $month = array_pop($words);
  $day = array_pop($words);
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Dashboard - CMS</title>

    <!--[if IE]>
    <script src="js/ie.js"></script>
    <![endif]-->

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
<!--header start-->
<div class="container">
<div class="row">
    <div class="navbar-fixed-top header">
    	<div class="col-md-1"> </div>
        <div class="col-md-5"><h2>Solapur Municipal Coorporation</h2></div>
        <div class="col-md-5"><h2>Complaint Management System</h2></div>
    	<div class="col-md-1"><form action="logout.php"><button class="btn logout">Log Out</button></form></div>
    </div>
</div>
</div>
<!--header end-->

<br><br><br>
<br><br><br>

<!--main-start-->
<div class="container">
<div class="row">
<div class="col-md-12">

  <div id="short-comp" class="short-comp">
    <div class="row">
      <div class="col-md-2">
        <div class="date-wrap">
          <span class="date"><?php echo $day ?></span><span class="month"><?php echo $month ?></span><span><?php echo $year ?></span>
        </div><!--date--><br><br>
        <div class="date-wrap">
        	<span class="date">OPEN</span><span class="month">Status</span>
        </div><!--status-->
      </div>
      <div class="col-md-10 row">
        <div class="com-img"><img src="<?php echo $complaint['URL'] ?>" alt="complaint-image"/></div>
		<div class="img-detail">
            <div class="row">
				<div class="col-md-1"></div>
           		<div class="col-md-4 img-cap">Complaint No: <a href="#">AVF-83490 </a></div>
				<div class="col-md-6 img-cap">Location: <a href="#"><?php echo $complaint['address'] ?><i class="fa fa-arrow-circle-right"></i></a></div>
            </div>
            <div class="row">
				<div class="col-md-1"></div>
                <div class="col-md-4 img-cap">By User:<?php echo '<a id="name" href=" Callme( $complaint )">';?><i><?php echo $complaint['name'] ?></i></a></div>
				<div class="col-md-6 img-cap">Mob. No: <a id="mobile" href="#"><i><?php echo $complaint['phone']; ?></i></a></div>
            </div>
        </div><!--image-detail-->
        </div><!--image-->
      </div><!--row-end-->
    <div class="row">
      <div class="col-md-2 col-md-2 text-right"><!--days & views-->
        <div class="side-view">
          <ul class="list-unstyled">
            <li><a style="color:#891416" href="#">209 Days</a></li>
            <li><a style="color:#CF1F22" href="#">209 Repeats</a></li>
          </ul>
        </div><!--side-view-->
      </div>
      <div class="col-md-10">
        <h1><a href="blog-detail.html"><?php echo $complaint['title']; ?></a></h1>
        <p><?php echo $complaint['description'] ?></p>
      </div><!--content-->
    </div><!--row-end-->
    </div><!--short-comp-->
</div>
</div>

	<div class="media">
      <h3>Comments</h3><hr>

      <div id="usr-cmnt">
          <a class="pull-left"><img class="media-object" src="img/person.png" alt="user-image"></a>
          <div class="media-body">
            <h4 class="media-heading">Maria Joli <span> | </span><span> 12 July 2014, 10:20</span></h4>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>
          </div>
          <hr>
      </div>

      <div id="usr-cmnt1">
          <a class="pull-left"><img class="media-object" src="img/person.png" alt="user-image"></a>
          <div class="media-body">
            <h4 class="media-heading">Maria Joli <span> | </span><span> 12 July 2014, 10:20</span></h4>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>
          </div>
          <hr>
      </div>

    </div><!--media/ comments-->
<br>
    <div id="post-comment">
      <h3 class="comment">Comment</h3>
      <form class="form-horizontal" role="form">
        <div class="form-group">
          <div class="col-md-6"><input type="txt" placeholder="Name" class="col-md-12 form-control"></div>
          <div class="col-md-6"><input type="txt" placeholder="Subject" class="col-lg-12 form-control"></div>
        </div>
        <div class="form-group">
          <div class="col-md-12"><textarea placeholder="Message" rows="8" class=" form-control"></textarea></div>
        </div>
<br>
        <p><button type="submit" class="btn btn-info pull-left">Post Comment</button></p>
        <p><button type="submit" class="btn btn-info pull-right">Close Complaint</button></p>
      </form>
    </div>
<br><br>
    <div class="text-center">
        <ul class="pagination">
          <li><a href="#">«</a></li>
          <li class="active"><a href="#">1</a></li>
          <li class="active"><a href="#">2</a></li>
          <li class="active"><a href="#">3</a></li>
          <li class="active"><a href="#">4</a></li>
          <li><a href="#">»</a></li>
        </ul>
    </div>
<br>
</div>
<!--main-end-->

<!--footer-start-->
<div class="footer">
<div class="container row">
    <div class="col-md-8 bt-logo"><a href="complaints.html"> <img src="img/logo.png" alt="smc-logo"></a></div>
    <div class="col-md-4">
    <p>Developed by : &nbsp;<a href="http://tiny.cc/brainwavetechs">Brain<span>Wave</span> Techs</a></p>
    </div>
</div>
</div>
<!--footer-end--

<script src="assets/jquery.min.js"></script>
<script src="js/backendless.min.js"></script>
<script src="js/new_3.js"></script>-->

</body>
</html>