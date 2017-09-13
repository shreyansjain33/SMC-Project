<?php
namespace my_app;
 
use backendless\Backendless;
use backendless\model\BackendlessUser;
use my_app\Complaint;
use backendless\services\persistence\BackendlessDataQuery;

include "backendless/autoload.php";
include 'Complaint.php';
include 'constant.php';
include 'backendless\src\services\persistence\BackendlessDataQuery.php';
session_start();

//$complaints= new complaint();
Backendless::initApp( $id , $rest, $version );
$class_name='Complaint';
    if(!isset($_COOKIE[$cookie_name]))
    {
        header("Location: login.php");
    }
$query = new BackendlessDataQuery();
$query->setWhereClause("phone > 1");
$complaints = Backendless::$Persistence->of('Complaint')->find($query)->getAsArray();


?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - CMS</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" />
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
<div id="complaints" class="container">
<div class="row">
<!--main-start-->
<div class="col-md-9 ">

<?php foreach( $complaints as $complaint )
{
  $i=1;
  $mil = $complaint['created'];
  $seconds = $mil / 1000;
  $date = date("d-M-Y", $seconds);
  $words = explode('-', $date);
  $year = array_pop($words);
  $month = array_pop($words);
  $day = array_pop($words);
  

        echo '<div class="short-comp"><div class="row"><div class="col-md-2"><div class="date-wrap">';
        echo '<span class="date">'.$day.'</span><span class="month">'.$month.'</span><span>'.$year.'</span></div><!--date--><br><br><div class="date-wrap"><span class="date">OPEN</span><span class="month">Status</span></div><!--status--></div><div class="col-md-10 row"><div class="com-img"><img src='.$complaint['URL'] .' alt="complaint-image"/></div><div class="img-detail"><div class="row"><div class="col-md-6 img-cap">Complaint No: <a href="#">'.$complaint['objectId'] .'</a></div><div class="col-md-6 img-cap">Location: <a href="#">'.$complaint['address'] .'<i class="fa fa-arrow-circle-right"></i></a></div></div><div class="row"><div class="col-md-6 img-cap">By User: <a href="#"><i>'.$complaint['name'] .'</i></a></div><div class="col-md-6 img-cap">Mob. No: <a href="#"><i>'.$complaint['phone'] .'</i></a></div></div></div><!--image-detail--></div><!--image--></div><!--row-end-->';

        echo '<div class="row"><div class="col-md-2 text-right"><!--days & views--><div class="side-view"><ul class="list-unstyled"><li><a style="color:#891416" href="#">209 Days</a></li><li><a style="color:#CF1F22" href="#">209 Repeats</a></li></ul></div><!--side-view--></div><div class="col-md-10"><!--content--><h1><a href="blog-detail.php">'.$complaint['title'] .'</a></h1><p>'.$complaint['description'] .'</p>';
        //$s= $complaint['objectId']."_".$i;
        $i=$i+1;
        echo '<form action="blog-detail.php" method="post"><button type="submit" name="submit'.$i.'" value='.$complaint['objectId'] .' class="btn btn-primary">Continue Reading</button></form></div></div><!--row-end--></div><!--short-comp--><br><hr><br>';
        
}
    $const = $i;
    $_SESSION["var"] =$i;
    
 ?>


<br>
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
<!--main-ends-->

<!--sidebar section-->
<div id="sidebr" class="col-lg-3 sidebr">
      <div class="blog-side-item">
<br>
        <div class="search-row">
          <input type="txt" class="search-form fa fa-search" placeholder="Search">
          <button type="submit" class="search-btn"><span class="fa fa-search search-butn"></span></button>
        </div><!--search-row-->
<br>
        <div class="category">
          <h2>Areas</h2>
          <ul class="list-unstyled">
            <li><a class="area" href="#"><i class="fa fa-angle-right pr-10"></i>Ashok Chowk</a></li>
            <li><a class="area" href="#"><i class="fa fa-angle-right pr-10"></i>Manik Chowk</a></li>
            <li><a class="area" href="#"><i class="fa fa-angle-right pr-10"></i>Navi Peth</a></li>
            <li><a class="area" href="#"><i class="fa fa-angle-right pr-10"></i>Ward No. 32</a></li>
          </ul>
        </div><!--Area/category-->
<br><br>

        <div class="blog-post">
          <h2>Top Complaints</h2>
          <div class="media">
            <a class="pull-left thmb" href="#"><img src="img/thumb.jpg" alt="thumbnail"></a>
            <div class="media-body">
              <h5 class="media-heading"><a class="area" href="#">02 May 2014</a></h5>
              <p>Donec id elit non mi porta gravida at eget metus amet int</p>
            </div>
          </div>
          <div class="media">
            <a class="pull-left thmb" href="#"><img src="img/thumb.jpg" alt="thumbnail"></a>
            <div class="media-body">
              <h5 class="media-heading"><a class="area" href="#">02 May 2014</a></h5>
              <p>Donec id elit non mi porta gravida at eget metus amet int</p>
            </div>
          </div>
          <div class="media">
            <a class="pull-left thmb" href="#"><img src="img/thumb.jpg" alt="thumbnail"></a>
            <div class="media-body">
              <h5 class="media-heading"><a class="area" href="#">02 May 2014</a></h5>
              <p>Donec id elit non mi porta gravida at eget metus amet int</p>
            </div>
          </div>
          <div class="media">
            <a class="pull-left thmb" href="#"><img src="img/thumb.jpg" alt="thumbnail"></a>
            <div class="media-body">
              <h5 class="media-heading"><a class="area" href="#">02 May 2014</a></h5>
              <p>Donec id elit non mi porta gravida at eget metus amet int</p>
            </div>
          </div>
        </div><!--blog-post-->
<br><br>

        <div class="archive">
          <h2>Archive</h2>
          <ul class="list-unstyled">
            <li><a class="area" href="#"><i class="fa fa-angle-double-right pr-10"></i>May 2014</a></li>
            <li><a class="area" href="#"><i class="fa fa-angle-double-right pr-10"></i>May 2014</a></li>
            <li><a class="area" href="#"><i class="fa fa-angle-double-right pr-10"></i>May 2014</a></li>
            <li><a class="area" href="#"><i class="fa fa-angle-double-right pr-10"></i>May 2014</a></li>
          </ul>
        </div>
<br><br>

      </div><!--blog-side-item-->
    </div>
<!--sidebr-end-->

</div>
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
<!--footer-end-->

</body>
</html>