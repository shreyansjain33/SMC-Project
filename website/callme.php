<?php
namespace my_app;
 
use backendless\Backendless;
use backendless\model\BackendlessUser;
use my_app\Complaint;

include "backendless/autoload.php";
include 'constant.php';
include 'Complaint.php';

Backendless::initApp( $id , $rest , $version );
function Callme( $complaint )
{
	echo $complaint['name'];
}
?>