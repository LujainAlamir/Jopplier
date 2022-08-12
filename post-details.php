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
.notif{
	margin:0% 24%;
}
#post-container{
	 background-color:#e8eaed;
	 padding:20px;
    margin:2% 24%;
 
}
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
function already_applied($jobid, $appid){

	$sql = "SELECT * FROM jobapplies WHERE jobid ='$jobid' and applicantid ='$appid'";

	$result = query($sql);

	if(row_count($result) ==1){
		return true;

	}else {
		return false;
	}
}
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

if(!empty($_GET['id']))
{
	$id=$_GET['id'];
	$sql="SELECT * FROM joboffer where id=".$id;
	$postres=$con->query($sql);
	$record=$postres->fetch_assoc();
	$rescat = $record['category'];
	$restitle = $record['title'];
	$resdesc = $record['description'];
	$ressalary = $record['salary'];
	$resskills = $record['skills'];
	$resyearExp = $record['yearExperience'];
	$resfaculty = $record['facultyid'];
	$posttime = $record['posted'];
    $applied = $record['applied'];
	
	$sql2="select name from faculty where ID_faculty=$resfaculty";
	$result2=$con->query($sql2);
	$p_record=$result2->fetch_assoc();

	if($_SERVER['REQUEST_METHOD'] == "POST"){
	 if(isset($_POST["applybtn"]))  {
		$appid=get_appid_by_username( $_SESSION['username']);		
		if(already_applied($id,$appid)){
			$notification = "You have already applied to this jop ..!";
			echo "<div class='notif'>".validation_errors($notification)."</div>";
		}
		else{
				
			$sql  ="INSERT INTO jobapplies (jobid, applicantid)";
			$sql .= " VALUES('$id','$appid')";
			$result = $con->query($sql);
			if($result ==true){
				$newapplied=$applied+1;
				$sql3  ="UPDATE `joboffer` SET `applied` = '$newapplied' WHERE `id` = $id";
				$result3 = $con->query($sql3);
				if($result3 ==true){					
					$notification = "You have applied to the post successfully !";
					echo "<div class='notif'>".validation_success($notification)."</div>";
				}
			} else 
			{
				echo "Error: " . $sql . $con->error;
			}	
		}
	 }
	}
}
else{
	header("location:index.php");
	exit();
}



?>

<!--header ends here-->
<div id="post-container">
			

	<h2> <?php echo $restitle; ?> </h2>
	<h5> <?php echo $p_record['name'].", ".getCategory($rescat).", ".date("d.m.Y", strtotime($posttime)); ?> </h5>
	
	<h3> Description </h3>
	<p> <?php echo $resdesc; ?> </p>

	<h3> Category </h3>
	<p> <?php echo getCategory($rescat); ?>  </P>
	
	<h3> Skills </h3>
	<ul>
	<?php 
		$arr=explode(";",$resskills);
		$count = count($arr);
		foreach($arr as $item){
			if (--$count <= 0) {
				break;
            }
			echo "<li> $item </li>";
		}
	?>
	</ul>
	<h3> Salary </h3>
	<p> <?php echo $ressalary; ?>  </P>
	<h3> Year Experience </h3>
	<p> <?php echo $resyearExp; ?>  </P>
	
	<?php if(  (isset($_SESSION['usertype']) && $_SESSION['usertype']==1)) { ?>
	<form  method="post" role="form" >
	<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-lg-push-4 col-sm-push-4 col-md-push-5 col-xs-push-5 form-group">
	<br /><input type="submit" value="Apply" name="applybtn" class="form-control" style="width:200px;"/>
	</div>
	</div>
	</form>
	<?php } ?>
</div>
<!--footer section starts here-->
<?php
include_once 'footer.php';
?>
<!--footer section ends here-->

</body>
</html>
