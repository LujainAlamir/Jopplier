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
$sql = "SELECT ID_faculty, name  FROM faculty";
$facultyList = $con->query($sql);

$status=false;

if($_SERVER['REQUEST_METHOD'] == "POST"){
	 if(isset($_POST["searchbtn"]))  {
		 
			$status=true;
			$fac = $_POST['faculty'];
			$search = $_POST['search'];
			$search="%".$search."%";
			if($fac=="*"){			
			$sql = "SELECT *  FROM joboffer where  title like '$search'";
			}
			else{
			$sql = "SELECT *  FROM joboffer where facultyid='$fac' and title like '$search'";	
			}
			$rs = $con->query($sql);
	 }
	 elseif( isset($_POST["outbtn"]))  {
		 $status=true;
		$search = $_POST['search1'];
		$search="%".$search."%";
		$sql = "SELECT *  FROM joboffer where  title like '$search'";
		$rs = $con->query($sql);		
	 }
	 
}

if(!empty($_GET['key']))
{
	$search=$_GET['key'];
	$search="%".$search."%";
	$sql = "SELECT *  FROM joboffer ";
	$rs = $con->query($sql);
}
if(!empty($_GET['cat']))
{
	 $status=true;
	$cat_id=$_GET['cat'];
	$sql = "SELECT *  FROM joboffer where  category = '$cat_id'";
	$rs = $con->query($sql);
}

?>
<!--header ends here-->
<div class="carousel search-banner">
  <div class="col-lg-10 col-lg-push-1">
	<form method="post">
	  <div class="form-group">
		<div class="col-lg-8">
		  <div class="row">
			<input type="text" class="form-control" name="search" placeholder="Looking for a Job" style="border-style: outset; border:none; border-radius: 20px 0px 0px 20px; border-width: 5px;"/>
		  </div>
		</div>
	  </div>
	  <div class="form-group">
		<div class="col-lg-4">
		  <div class="row">
			<select name="faculty" class="form-control" style="border:none; border-radius: 0px 10px 10px 0px;">
			  <option value='*'>All Faculties</option>
				<?php 
				while($row = $facultyList->fetch_array())
				{
					$state=$resfaculty == $row['ID_faculty'] ? true : false;
					if($state==true)
					  echo "<option value='".$row['ID_facluty']."' selected = 'selected' >" . $row['name'] . "</option>";
					else						
					  echo "<option value=".$row['ID_faculty'].">" . $row['name'] . "</option>";
				}
				?>
			</select>
			<br />
		  </div>
		</div>
	  </div>
	  <div class="form-group">
		<div class="col-lg-4 col-lg-push-2">
		  <div class="row">
			<input type="submit" name="searchbtn"  class="search-btn" value="Search" />
		  </div>
		</div>
	  </div>
	</form>
  </div>
</div>

<?php function h_thumb_item($p,$faculty) { ?>
	<div class="row recent-jobs" >
		<div class="col-lg-4 rj-title">
		<h4><?php echo $p['title'] ?></h4>
		</div>
		<div class="col-lg-2 rj-location">
		<span class="glyphicon glyphicon"> <h4><?php echo $faculty ?></h4></span>
		</div>
		<div class="col-lg-2 rj-posted">
		<span class="glyphicon glyphicon-time"> <h4> <?php $date=date_create($p['posted']); echo date_format($date,"d.m.y");?> </h4></span>
		</div>
		<div class="col-lg-3">
		<a href="post-details.php?id=<?php echo $p['id'] ?>" class="thm-btn">view details</a>
		</div>
	</div>
<?php } ?>


<section class="recent">
<div class="container">
<h1>Results</h1>
	
	<?php
	if($status==true && row_count($rs) >=1){
	?>
		<div class="row recent-jobs-title" >
		<div class="col-lg-4 rj-title">
		<h4>title</h4>
		</div>
		<div class="col-lg-2 rj-location">
		 <h4>Faculty</h4>
		</div>
		<div class="col-lg-2 rj-posted">
		 <h4> Posted on </h4>
		</div>
	</div>
	<?php
		while($p = $rs->fetch_array())
		{
			$fid=$p['facultyid'];
			$sql2="select name from faculty where ID_faculty=$fid";
			$result2=$con->query($sql2);
			$p_record=$result2->fetch_assoc();
			h_thumb_item($p,$p_record['name']);
		}
	}
	else{
		echo"<center> <strong>	<p> No results found </p> </strong> </center>";
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
