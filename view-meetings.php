<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jopplier - metings</title>
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

if( ! isset($_SESSION['username']) ) {
	
header("location:login.php");
exit();
} 

$servername = "localhost";
$username = "root";
$password = "";
$conn = new mysqli($servername, $username, $password, "jopplier_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if( $_SESSION['usertype']==1)
{
$appid=get_appid_by_username( $_SESSION['username']);
$sql = "SELECT *  FROM meeting where applicantid='$appid' order by mtime DESC";	
$rs = $con->query($sql);
}
if( $_SESSION['usertype']==2)
{
	$hrid=get_hrid_by_username( $_SESSION['username']);
	$sql = "SELECT *  FROM meeting where hrid='$hrid' order by mtime DESC";	
	$rs = $con->query($sql);
}

?>
<!--header ends here-->
		<section class="applicant-banner" style="margin: 10px 0px;">
			<h1>My Meetings</h1>
		</section>

<?php function h_thumb_item($m) { ?>
	<div class="row recent-jobs" >
		<div class="col-lg-3 rj-title">
		<h4><?php echo $m['place'] ?></h4>
		</div>
		<div class="col-lg-3 rj-posted">
		<span class="glyphicon glyphicon-time"> <h4> <?php $date=date_create($m['mtime']); echo date_format($date,"M,d,Y h:i:s A");?> </h4></span>
		</div>
		<div class="col-lg-2 rj-location">
		<span class="glyphicon glyphicon"> <h4><?php echo $m['duration']." minutes" ?></h4></span>
		</div>

		<div class="col-lg-3 rj-location">
			<?php echo $m['attendees'] ?>
		</div>

	</div>
<?php } ?>


<section class="recent" style="min-height: 350px;">
<div class="container">
	<?php
	if(row_count($rs) >=1){
	?>
		<div class="row recent-jobs-title" >
		<div class="col-lg-3 rj-title">
		<h4>Place</h4>
		</div>
		<div class="col-lg-3 rj-posted">
		 <h4>Time</h4>
		</div>
		<div class="col-lg-2 rj-location">
		 <h4> Duration</h4>
		</div>
		<div class="col-lg-3 rj-location">
		 <h4> attendees </h4>
		</div>
	</div>
	<?php
		while($m = $rs->fetch_array())
		{
			

			h_thumb_item($m);
		}
	}
	else{
		echo"<center> <strong>	<p> There are No Meetings yet ..</p> </strong> </center>";
	}
	
	?>



</div>

</section>
		 
<!--footer section starts here-->
<?php
include_once 'footer.php';
?>
<!--footer section ends here-->

</body>
</html>
