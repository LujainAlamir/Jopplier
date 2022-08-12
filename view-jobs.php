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

$id=get_hrid_by_username( $_SESSION['username']);
$sql_userid="select * from hr_manager where id=$id";
$res1=$con->query($sql_userid);
$hr_record=$res1->fetch_assoc();

$resfacultyid = $hr_record['facultyid']; 	
$sql2="select * from faculty where ID_faculty=$resfacultyid";
$res2=$con->query($sql2);
$fac_record=$res2->fetch_assoc();

$sql = "SELECT *  FROM joboffer where facultyid='$resfacultyid'";	
$rs = $con->query($sql);

function getCategory($catid){
	switch ($catid){
		case 1: return "Education"; break;
		case 2: return "Accounting"; break;
		case 3: return "Software"; break;
		case 4: return "Marketing"; break;
		case 5: return "Customer Service"; break;
		case 6: return "Mechanical"; break;
	}
}
?>
<!--header ends here-->
		<section class="applicant-banner" style="margin: 10px 0px;">
			<h1>All <?php echo $fac_record['name'] ?> Faculty Jobs</h1>
		</section>

<?php function h_thumb_item($j) { ?>
	<div class="row recent-jobs" >
		<div class="col-lg-4 rj-title">
		<h4><?php echo $j['title'] ?></h4>
		</div>
		<div class="col-lg-2 rj-location">
		<span class="glyphicon glyphicon"> <h4><?php echo getCategory($j['category']) ?></h4></span>
		</div>
		<div class="col-lg-2 rj-posted">
		<span class="glyphicon glyphicon-time"> <h4> <?php $date=date_create($j['posted']); echo date_format($date,"d.m.y");?> </h4></span>
		</div>
		<div class="col-lg-2 rj-location">
		<span class="glyphicon glyphicon"> <h4><?php echo $j['applied'] ?></h4></span>
		</div>
		<a  href="view-applicants.php?id=<?php echo $j['id'] ?>"> <button>Show Applicants </button></a>
	</div>

<?php } ?>


<section class="recent" style="min-height: 350px;">
<div class="container">
	<?php
	if(row_count($rs) >=1){
	?>
		<div class="row recent-jobs-title" >
		<div class="col-lg-4 rj-title">
		<h4>Title</h4>
		</div>
		<div class="col-lg-2 rj-location">
		 <h4>Category</h4>
		</div>
		<div class="col-lg-2 rj-posted">
		 <h4> Posted </h4>
		</div>
		<div class="col-lg-2 rj-posted">
		 <h4> Number of Appliers </h4>
		</div>
	</div>
	<?php
		while($j = $rs->fetch_array())
		{	
			h_thumb_item($j);
		}
	}
	else{
		echo "<center> <strong>	<p> No posts for faculty ".$fac_record['name']." </p> </strong> </center>";
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
