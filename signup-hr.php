<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>sign up</title>
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
include_once 'header.php';
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
$sql2 = "SELECT ID_faculty, name  FROM faculty";
$facultyList = $conn->query($sql2);
?>

<section class="signup-banner">
<h2>HR signup</h2>
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

<?php validate_user_registration(); ?>	

<?php display_message(); ?>




<form method="post" role="form" enctype="multipart/form-data">
<input type="hidden" name="utype" value="2"/>
<div class="container">
<div class="row">
<div class="col-lg-4 form-group" >
<label class="control-label">First Name: </label><input type="text" name="first_name" class="form-control" required /></div>
<div class="col-lg-4 form-group">
<label class="control-label">Last Name: </label><input type="text" name="last_name" class="form-control" required /></div>
</div>
<div class="row">
<div class="col-lg-4 form-group">
<label class="control-label">Phone number: </label><input type="text" name="phone_number" class="form-control" required /></div>
<div class="col-lg-4 form-group">
<label class="control-label">Email Address: </label><input type="email" name="email" class="form-control" required /></div>
</div>
<div class="row">
<div class="col-lg-4 form-group">
<label class="control-label">Username: </label><input type="text" name="username" class="form-control" required /></div>
<div class="col-lg-4 form-group">
<label class="control-label">Password: </label><input type="password" name="password" class="form-control" required /></div>
</div>
<div class="row">
<div class="col-lg-4 form-group">
<label class="control-label">Location: </label>
					<select name="location" id="location" class="form-control" style="color:black; width:360px;">
						<?php 
						while($row = $locationList->fetch_array())
						{
							echo "<option value=".$row['ID_location'].">" . $row['city'] . "</option>";
						}
						?>
					</select>
</div>
<div class="col-lg-4 form-group">
<label class="control-label">Confirm Password: </label><input type="password" name="confirm_password" class="form-control" required /></div>
</div>
<div class="row">
<div class="col-lg-4 form-group">
<label class="control-label" style="color:black;">* Profile Image: </label> <input type="file" name="fileToUpload" id="fileToUpload" size="50"  class="form-control">
 </div>
<div class="col-lg-4 form-group" id="comp_div" >
<label class="control-label">Faculty: </label>
					<select name="faculty" id="faculty" style="color:black;" class="form-control">
						<?php 
						while($row = $facultyList->fetch_array())
						{
							echo "<option value=".$row['ID_faculty'].">" . $row['name'] . "</option>";
						}
						?>
					</select>
</div>

</div>

<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-lg-push-3 col-sm-push-3 col-md-push-3 col-xs-push-3 form-group">
<br /><input type="submit" value="Sign Up" class="form-control" style="width:200px;" />
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
