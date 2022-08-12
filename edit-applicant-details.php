<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Applicant details</title>
<link rel="stylesheet" href="bootstrap.min.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<link rel="stylesheet" href="style.css" />
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
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
<?php
#include_once 'header.php';
?>
<?php 
include("functions/init.php");

$servername = "localhost";
$username = "root";
$password = "";
$conn = new mysqli($servername, $username, $password, "jopplier_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT ID_location, city  FROM location";
$locationList = $conn->query($sql);
$sql2 = "SELECT ID_company, name  FROM company";
$companyList = $conn->query($sql2);

if(!empty($_GET['id']))
{
$id=$_GET['id'];
$sql_userid="select * from applicant where id=$id";
$res1=$con->query($sql_userid);
$app_record=$res1->fetch_assoc();
$userid = $app_record['user_id'];
$reslocation = $app_record['locationid'];
$resyearExp = $app_record['yearExperience'];
$resimgname = $app_record['image_name'];

$sql_userinfo="select * from users where id=$userid";
$res2=$con->query($sql_userinfo);
$user_record=$res2->fetch_assoc();
$resfirstname=$user_record['first_name'];
$reslastname=$user_record['last_name'];
$resusername=$user_record['username'];
$resemail=$user_record['email'];
$resphoneNumber=$user_record['phoneNumber'];
$resactive=$user_record['active'];

}
?>

<section class="signup-banner">
<h2>Update Applicant Details</h2>
</section>

<section class="signup-portal">
<div class=" signup-inner" style="padding-left:20%;">
<?php

if(isset($_SESSION['msg']))
{
if($_SESSION['msg']==1)
echo "please login";
else
echo $_SESSION['msg'];
session_unset($_SESSION['msg']);
}
?>

<?php validate_user_updating($resusername,$resemail); ?>	

<?php display_message(); ?>




<form method="post" role="form" enctype="multipart/form-data">
<input type="hidden" name="app_id" value="<?php echo (isset($id))?$id:'';?>"/>
<input type="hidden" name="user_id" value="<?php echo (isset($userid))?$userid:'';?>"/>
<input type="hidden" name="utype" value="1"/>
<div class="container">
<div class="row">
<div class="col-lg-4 form-group">
<label class="control-label">First Name: </label><input type="text" value="<?php echo (isset($resfirstname))?$resfirstname:'';?>" name="first_name" class="form-control"/></div>
<div class="col-lg-4 form-group">
<label class="control-label">Last Name: </label><input type="text" value="<?php echo (isset($reslastname))?$reslastname:'';?>" name="last_name" class="form-control"/></div>
</div>
<div class="row">
<div class="col-lg-4 form-group">
<label class="control-label">Phone number: </label><input type="text" value="<?php echo (isset($resphoneNumber))?$resphoneNumber:'';?>" name="phone_number" class="form-control"/></div>
<div class="col-lg-4 form-group">
<label class="control-label">Email Address: </label><input type="email" value="<?php echo (isset($resemail))?$resemail:'';?>" name="email" class="form-control"/></div>
</div>
<div class="row">
<div class="col-lg-4 form-group">
<label class="control-label">Username: </label><input type="text" value="<?php echo (isset($resusername))?$resusername:'';?>" name="username" class="form-control"/></div>
<div class="col-lg-4 form-group">
<label class="control-label">Password: </label><input type="password" name="password" class="form-control"/></div>
</div>
<div class="row">
<div class="col-lg-4 form-group">
<label class="control-label">Location: </label>
					<select name="location" id="location" class="form-control" style="color:black; width:290px;">
						<?php 
						while($row = $locationList->fetch_array())
						{
							$state=$reslocation == $row['ID_location'] ? true : false;
							if($state==true)
							echo "<option value=".$row['ID_location']." selected='selected'>" . $row['city'] . "</option>";
							else						
							echo "<option value=".$row['ID_location'].">" . $row['city'] . "</option>";
						}
						?>
					</select>
</div>

<div class="col-lg-4 form-group">
<label class="control-label">Confirm Password: </label><input type="password" name="confirm_password" class="form-control"/></div>
</div>
<div class="row">
<div class="col-lg-4 form-group">
<label class="control-label" style="color:black;">* Profile Image: </label> <input type="file" name="fileToUpload" id="fileToUpload" size="50" id="" class="form-control"/>
 </div>

<div class="col-lg-4 form-group" id="exp_num_div">
<label class="control-label">Number of years Experience: </label>

<input type="number" name="num_exp" value="<?php echo (isset($resyearExp))?$resyearExp:'';?>"  min="1" max="100" class="form-control"/>
</div>
</div>
<div class="row">
<div class="col-lg-4 form-group" id="active_app_div" style="color:black;">
<input type="checkbox" name="active_elem" <?php echo (isset($resactive) && $resactive==1)?'checked':''; ?>> <strong>Active </strong><br />
</div>
</div>

<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-lg-push-3 col-sm-push-3 col-md-push-3 col-xs-push-3 form-group">
<br /><input type="submit" value="Update" class="form-control" style="width:200px;"/>
</div>
</div>
</div>
</form>
</div>
</section>
<?php
include_once 'footer.php';
?>
</body>
</html>
