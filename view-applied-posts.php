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

$appid=get_appid_by_username( $_SESSION['username']);


$sql = "SELECT *  FROM jobapplies where applicantid='$appid'";	
$rs = $con->query($sql);

?>
<!--header ends here-->
		<section class="applicant-banner" style="margin: 10px 0px;">
			<h1>My Applied Posts</h1>
		</section>

<?php function h_thumb_item($japp,$job_record,$faculty) { ?>
	<div class="row recent-jobs" >
		<div class="col-lg-4 rj-title">
		<h4><?php echo $job_record['title'] ?></h4>
		</div>
		<div class="col-lg-2 rj-location">
		<span class="glyphicon glyphicon"> <h4><?php echo $faculty ?></h4></span>
		</div>
		<div class="col-lg-2 rj-posted">
		<span class="glyphicon glyphicon-time"> <h4> <?php $date=date_create($japp['requestdate']); echo date_format($date,"d.m.y");?> </h4></span>
		</div>
		<div class="col-lg-2 rj-location">
		<span class="glyphicon glyphicon"> <h4>
		<?php 

		if($japp['accepted']==0)
			echo "Pending";
		if($japp['accepted']==1)
			echo "Accepted";
		if($japp['accepted']==2)
			echo "Rejected";
			?></h4></span>
		</div>

	</div>
<?php } ?>


<section class="recent" style="min-height: 350px;">
<div class="container">
	<?php
	if(row_count($rs) >=1){
	?>
		<div class="row recent-jobs-title" >
		<div class="col-lg-4 rj-title">
		<h4>title</h4>
		</div>
		<div class="col-lg-2 rj-location">
		 <h4>Faculty</h4>
		</div>
		<div class="col-lg-2 rj-posted">
		 <h4> Applied on </h4>
		</div>
		<div class="col-lg-2 rj-posted">
		 <h4> Status </h4>
		</div>
	</div>
	<?php
		while($japp = $rs->fetch_array())
		{
			$postid=$japp['jobid'];
			
			$sql_userid="select * from joboffer where id=$postid";
			$res=$con->query($sql_userid);
			$job_record=$res->fetch_assoc();
			$fid = $job_record['facultyid'];

			$sql2="select name from faculty where ID_faculty=$fid";
			$result2=$con->query($sql2);
			$p_record=$result2->fetch_assoc();
			h_thumb_item($japp,$job_record,$p_record['name']);
		}
	}
	else{
		echo"<center> <strong>	<p> No posts applied yet </p> </strong> </center>";
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
