<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jopplier</title>
<link rel="stylesheet" href="bootstrap.min.css" />
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<link rel="stylesheet" href="style.css" />
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link rel="stylesheet" href="style.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>


</style>
</head>
<body>
<!--header starts here-->
<?php 


include("functions/init.php");
?>
<?php
include_once 'header.php';

$servername = "localhost";
$username = "root";
$password = "";
$conn = new mysqli($servername, $username, $password, "jopplier_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if( ! isset($_SESSION['username']) || $_SESSION['usertype']==1) {
	
header("location:login.php");
exit();
} 

if(!empty($_GET['id']))
{
$id=$_GET['id'];
$sql_userid="SELECT *  FROM joboffer where id='$id'";
$res1=$conn->query($sql_userid);
$jop_record=$res1->fetch_assoc();


$sql = "SELECT *  FROM jobapplies where jobid='$id'";	
$rs = $conn->query($sql);

function printAcceptedStatus($status)
{
	if($status==1)
		echo  "<p style='display:inline-block; color:green'> accepted </p>";
	else if($status==2)
		echo  "<p style='display:inline-block; color:red'> rejected </p>";
}

  if($_SERVER['REQUEST_METHOD'] == "POST"){
	  if(isset($_POST["accept"]))  {
		  $app_id=$_POST['app_id'];
		  $sql3="UPDATE `jobapplies` SET `accepted`=1 WHERE `jobid`=$id and `applicantid`=$app_id";
		  $conn->query($sql3);
	  }
	  if(isset($_POST["reject"]))  {
		  $app_id=$_POST['app_id'];
		  $sql3="UPDATE `jobapplies` SET `accepted`=2 WHERE `jobid`=$id and `applicantid`=$app_id";
		  $conn->query($sql3);
	  }
	  echo "<meta http-equiv='refresh' content='0'>";
  }
}
?>
<!--header ends here-->
		<section class="applicant-banner" style="margin: 10px 0px;">
			<h1>All  <strong style="font-size:30px; background-color:#3c5bba;"># <?php echo $jop_record['title'] ?> </strong>  Applicants</h1>
		</section>

<?php function h_thumb_item($res,$conn) {
	$appid=$res['applicantid'];
	$sql2="select * from applicant where id=$appid";
	$res2=$conn->query($sql2);
	$app_record=$res2->fetch_assoc();
	$userid = $app_record['user_id'];
    $imagename="baseprofile.svg.png";
	if($app_record['image_name']!==null)
	   $imagename=$app_record['image_name'];
    $sql_userinfo="select * from users where id=$userid";
	$res2=$conn->query($sql_userinfo);
	$user_record=$res2->fetch_assoc();
	$firstname=$user_record['first_name'];
	$lastname=$user_record['last_name'];
    $phoneNumber=$user_record['phoneNumber'];
	

?>
	<div class="row recent-jobs" >
		
		<div class="col-lg-3 " >
		<img src="profiles/<?php echo $imagename ?>" style="width:100px; height:100px;  border-radius: 50%;"/>
		</div>
		<div class="col-lg-2 rj-location">
		<span class="glyphicon glyphicon"> <h4><?php echo $firstname." ".$lastname ?></h4></span>
		<span> <h5> <?php echo $phoneNumber; ?> </h5></span>
		</div>
		<div class="col-lg-2 rj-posted">
		<span class="glyphicon glyphicon-time"> <h4> <?php $date=date_create($res['requestdate']); echo date_format($date,"d.m.y");?> </h4></span>
		</div>
		<div class="col-lg-5 rj-location">
		<form method="post">
		<p>
		<?php if ( $res['accepted'] == 0) { ?>
		 <input type="hidden" name="app_id" value="<?php echo (isset($appid))?$appid:'';?>"/>
		 <input type="submit" name="accept" value="Accept"  />
		 <input type="submit" name="reject" value="Reject" />
		<?php }else{   printAcceptedStatus($res['accepted']); }?>
		</p>
		</form>
		<p>

		<a  href="schedule-meeting.php?id=<?php echo $appid ?>" target="_blank"> <button>Schedule Meeting </button></a>
		<a  href="vew-CV.php?id=<?php echo $appid ?>" target="_blank" target="_blank"> <button>View CV File </button></a>

		</p>		
		
		</div>
		
	</div>

<?php } ?>


<section class="recent" style="min-height: 350px;">
<div class="container">
	<?php
	if(row_count($rs) >=1){
	?>

	<?php
		while($res = $rs->fetch_array())
		{	
			h_thumb_item($res,$conn);
		}
	}
	else{
		echo "<center> <strong>	<p> No Applicants for this jop </p> </strong> </center>";
	}
	
	?>





</section>
		 
<!--footer section starts here-->
<?php
include_once 'footer.php';
?>
<!--footer section ends here-->

</body>
</html>
