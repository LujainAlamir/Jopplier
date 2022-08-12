
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
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button {  

   opacity: 1;

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



$sql = "SELECT ID_location, city  FROM location";
$locationList = $conn->query($sql);

$sql2 = "SELECT ID_faculty, name  FROM faculty";
$facultyList = $conn->query($sql2);

if( $_SESSION['usertype']==1)
{
$id=get_appid_by_username( $_SESSION['username']);
$sql_userid="select * from applicant where id=$id";
$res1=$con->query($sql_userid);
$app_record=$res1->fetch_assoc();
$userid = $app_record['user_id'];
$reslocation = $app_record['locationid'];
$resyearExp = $app_record['yearExperience'];
$resimgname = $app_record['image_name'];
$cvid = $app_record['cvid'];
}
if( $_SESSION['usertype']==2)
{
$id=get_hrid_by_username( $_SESSION['username']);
$sql_userid="select * from hr_manager where id=$id";
$res1=$con->query($sql_userid);
$hr_record=$res1->fetch_assoc();
$userid = $hr_record['user_id'];
$reslocation = $hr_record['locationid'];
$resimgname = $hr_record['image_name'];
$resfacultyid=$hr_record['facultyid']; 	
}
$sql_userinfo="select * from users where id=$userid";
$res2=$con->query($sql_userinfo);
$user_record=$res2->fetch_assoc();
$resfirstname=$user_record['first_name'];
$reslastname=$user_record['last_name'];
$resusername=$user_record['username'];
$resemail=$user_record['email'];
$resphoneNumber=$user_record['phoneNumber'];
$resactive=$user_record['active'];






?>
<!--header ends here-->
		  <section class="applicant-banner" style="margin: 10px 0px;">
			<h1>Base information</h1>
		 </section>
<section class="signup-portal">
<div class=" signup-inner" style="padding-left:20%;">


<?php validate_user_editprofile($_SESSION['usertype'],$resusername,$resemail); ?>	

<?php display_message(); ?>




<form action="edit-profile.php?id=<?php echo $id; ?>" method="post" role="form" >
<input type="hidden" name="id" value="<?php echo (isset($id))?$id:'';?>"/>
<input type="hidden" name="user_id" value="<?php echo (isset($userid))?$userid:'';?>"/>
<input type="hidden" name="utype" value="1"/>
<div class="container">
<div class="row">
<div class="col-lg-4 form-group">
<label class="control-label">First Name: </label><input type="text" value="<?php echo (isset($_POST['first_name']))?$_POST['first_name']:$resfirstname;?>" name="first_name" class="form-control"/></div>
<div class="col-lg-4 form-group">
<label class="control-label">Last Name: </label><input type="text" value="<?php echo (isset($_POST['last_name']))?$_POST['last_name']:$reslastname;?>" name="last_name" class="form-control"/></div>
</div>
<div class="row">
<div class="col-lg-4 form-group">
<label class="control-label">Phone number: </label><input type="text" value="<?php echo (isset($_POST['phone_number']))?$_POST['phone_number']:$resphoneNumber;?>" name="phone_number" class="form-control"/></div>
<div class="col-lg-4 form-group">
<label class="control-label">Email Address: </label><input type="email" value="<?php echo (isset($_POST['email']))?$_POST['email']:$resemail;?>" name="email" class="form-control"/></div>
</div>
<div class="row">
<div class="col-lg-4 form-group">
<label class="control-label">Username: </label><input type="text" value="<?php echo (isset($_POST['username']))?$_POST['username']:$resusername;?>" name="username" class="form-control"/></div>

<div class="col-lg-4 form-group">
<label class="control-label">Location: </label>
		<select name="location" id="location" class="form-control" style="color:black; width:360px;">
			<?php 
			while($row = $locationList->fetch_array())
			{
				if(isset($_POST['location'])){
					$state=$_POST['location'] == $row['ID_location'] ? true : false;
				}
				else{
					$state=$reslocation == $row['ID_location'] ? true : false;
				}
				
				if($state==true)
				  echo "<option value=".$row['ID_location']." selected='selected' >" . $row['city'] . "</option>";
				else						
				  echo "<option value=".$row['ID_location'].">" . $row['city'] . "</option>";
			}
			?>
		</select>
</div>


</div>
<?php if($_SESSION['usertype']==1){ ?>
<div class="row">
<div class="col-lg-4 form-group" id="exp_num_div">
<label class="control-label">Number of years Experience: </label>

<input type="number" name="num_exp" value="<?php echo (isset($_POST['num_exp']))?$_POST['num_exp']:$resyearExp;?>"  min="1" max="100" class="form-control"/>
</div>
</div>
<?php }else{?>
<div class="row">
<div class="col-lg-4 form-group">
<label class="control-label">Faculty: </label>
		<select name="faculty" id="faculty" style="color:black;" class="form-control">
			<?php 
			while($row = $facultyList->fetch_array())
			{
				if(isset($_POST['faculty'])){
					$state=$_POST['faculty'] == $row['ID_faculty'] ? true : false;
				}
				else{
					$state=$reslocation == $row['ID_faculty'] ? true : false;
				}
				
				if($state==true)
				  echo "<option value=".$row['ID_faculty']." selected='selected' >" . $row['name'] . "</option>";
				else						
				  echo "<option value=".$row['ID_faculty'].">" . $row['name'] . "</option>";
					
			}
			?>
		</select>
</div>
</div>
<?php }?>

<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-lg-push-3 col-sm-push-3 col-md-push-3 col-xs-push-3 form-group">
<br /><input type="submit" value="Update" name="basesubmit" class="form-control" style="width:200px;"/>
</div>
</div>
</div>
</form>
</div>
</section>
		  <section class="applicant-banner" id="sectionpass" style="margin: 10px 0px;">
			<h1>Password</h1>
		 </section>
<section class="signup-portal">
<div class=" signup-inner" style="padding-left:20%;">

<?php validate_user_editPass(); ?>	




<form action="edit-profile.php?id=<?php echo $id; ?>#sectionpass" method="post" role="form">
<input type="hidden" name="app_id" value="<?php echo (isset($id))?$id:'';?>"/>
<input type="hidden" name="user_id" value="<?php echo (isset($userid))?$userid:'';?>"/>
<input type="hidden" name="utype" value="1"/>
<div class="container">
<div class="row">

<div class="row">
<div class="col-lg-4 form-group">
<label class="control-label">Old Password: </label><input type="password" name="oldpassword" class="form-control"/></div>
</div>
<div class="row">

<div class="col-lg-4 form-group">
<label class="control-label">New Password: </label><input type="password" name="password" class="form-control"/></div>
</div>
<div class="row">

<div class="col-lg-4 form-group">
<label class="control-label">Confirm Password: </label><input type="password" name="confirm_password" class="form-control"/></div>

</div>

<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-lg-push-3 col-sm-push-3 col-md-push-3 col-xs-push-3 form-group">
<br /><input type="submit" value="Update" name="submitpass" class="form-control" style="width:200px;"/>
</div>
</div>
</div>
</form>
</div>
</section>
      <section class="applicant-banner" id="sectionimage" style="margin: 10px 0px;">
			<h1>Profile Picture</h1>
		 </section>
<section class="signup-portal">
<div class=" signup-inner" style="padding-left:20%;">

<?php validate_user_editimageprofile($_SESSION['usertype']); ?>	



<form action="edit-profile.php?id=<?php echo $id; ?>#sectionimage" method="post" role="form" enctype="multipart/form-data">
<input type="hidden" name="app_id" value="<?php echo (isset($id))?$id:'';?>"/>
<input type="hidden" name="user_id" value="<?php echo (isset($userid))?$userid:'';?>"/>
<input type="hidden" name="utype" value="1"/>
<div class="container">
<div class="row">

<div class="row">
<div class="col-lg-6 form-group">
<label class="control-label" style="color:black;">* Profile Image: </label> <input type="file" name="fileToUpload" id="fileToUpload" size="50"  class="form-control">
 </div>

</div>

<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-lg-push-3 col-sm-push-3 col-md-push-3 col-xs-push-3 form-group">
<br /><input type="submit" value="Update" name="imgsubmit" class="form-control" style="width:200px;"/>
</div>
</div>
</div>
</form>
</div>
</section>
<?php if($_SESSION['usertype']==1){ ?>

<section class="applicant-banner" id="sectionimage" style="margin: 10px 0px;">
		<h1>Curriculum Vitae(CV)</h1>
</section>
<section class="signup-portal">
<div class=" signup-inner" style="padding-left:20%;">
<div class="container">	
<div class="row">
<div class="col-lg-12 form-group">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-lg-push-3 col-sm-push-3 col-md-push-3 col-xs-push-3 form-group">
<?php if($cvid == null){
		echo '<a href="addCV.php"><button  class="form-control" style="width:200px;"> Add </button> </a> ';
      }
	  else {
		echo '<a href="UpdateCV.php"><button  class="form-control" style="width:200px;"> Update </button> </a> ';
	  }
?>
</div>
</div>
</div>
</div>
</section>
<?php }?>
<!--footer section starts here-->
<?php
include_once 'footer.php';
?>
<!--footer section ends here-->

</body>
</html>
