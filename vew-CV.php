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
#cvsection{
min-height: 350px;
}
#post-container{
	 
	 background-color:#e8eaed;
	 padding:60px;
    margin:2% 24%;
 
}
#imgsection{
	display: inline-block;
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
if( ! isset($_SESSION['username']) || $_SESSION['usertype']==1) {
	
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
if(!empty($_GET['id']))
{
$appid=$_GET['id'];
$sql_userid="select * from applicant where id=$appid";
$res1=$con->query($sql_userid);
$app_record=$res1->fetch_assoc();
$imagename="baseprofile.svg.png";
if($app_record['image_name']!==null)
	$imagename=$app_record['image_name'];
$userid = $app_record['user_id'];
$cvid = $app_record['cvid'];

$sql_userinfo="select * from users where id=$userid";
$res2=$con->query($sql_userinfo);
$user_record=$res2->fetch_assoc();
$appusername=$user_record['username'];

if($cvid!=null){
$sql_cvinfo="select * from cvfile where id=$cvid";
$res3=$con->query($sql_cvinfo);
$cv_record=$res3->fetch_assoc();
$educationInfo=$cv_record['educationInfo'];	
$experienceInfo=$cv_record['experienceInfo'];	
$skills=$cv_record['skills'];
$languages=$cv_record['languages'];
$contact=$cv_record['contact'];
$email=$cv_record['email'];	
}
}
else{
	header("location:index.php");
	exit();
}






?>

<!--header ends here-->
		<section class="applicant-banner" style="margin: 10px 0px;">
			<h1>Curriculum Vitae	</h1>
		</section>
<div id="cvsection">
<div id="post-container">

	<?php if($cvid==null){
		echo "Applicant hasn't have CV yet .."; 
	}else{	?>

	<div  id="imgsection" >
		<img src="profiles/<?php echo $imagename ?>" style="width:100px; height:100px;  border-radius: 50%; float:left; "/>
		<h5 style="float:left; padding-top:20%; padding-left:20px;"> <?php echo $appusername; ?> </h5>
		<br>
	</div>
	

	<h3> Education Information </h3>
	<p> <?php echo $educationInfo; ?>  </P>
	<h3> Experience Information </h3>
	<p> <?php echo $experienceInfo; ?>  </P>
	<h3> Contact </h3>
	<p> <?php echo $contact; ?>  </P>
	<h3> Email </h3>
	<p> <?php echo $email; ?>  </P>
	
	<h3> Skills </h3>
	<ul>
	<?php 
		$arr=explode(";",$skills);
		$count = count($arr);
		foreach($arr as $item){
			if (--$count <= 0) {
				break;
            }
			echo "<li> $item </li>";
		}
	?>
	</ul>
	<h3> Languages </h3>
	<ul>
	<?php 
		$arr=explode(";",$languages);
		$count = count($arr);
		foreach($arr as $item){
			if (--$count <= 0) {
				break;
            }
			echo "<li> $item </li>";
		}
	?>
	</ul>
	<?php }?>
</div>
</div>
<!--footer section starts here-->
<?php
include_once 'footer.php';
?>
<!--footer section ends here-->

</body>
</html>
