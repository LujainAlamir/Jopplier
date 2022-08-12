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
<?php 
include("functions/init.php");
?>
<?php
include_once 'header.php';
if(isset($_SESSION['usertype'])&& $_SESSION['usertype']==1)
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
?>
<section class="body-section">
<div class="container-fluid">
<div class="row">
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
<img src="images/about_us.jpg" alt="job_search" width="100%">
</div>
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
<h4>About Us</h4>
<p>jopplier is a website that offer to connect between applicants and HR Managers.  </p>
<p>our website provides weekly job offers specifically for Princess Noura University to all our applicants, whilse also providing HR managers with quality candidates</p>
<p><strong> Jopplier</strong> services are all free of charge which makes this experience more pleasent and accesibale to everyone.
</p>
</div>
</div>
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-lg-push-5 col-md-push-3 col-xs-push-3 col-sm-push-3">
<?php if(isset($_SESSION['usertype'])&&$_SESSION['usertype']==1 && $cvid == null){ ?>
<br><br><a href="addCV.php" class="thm-btn">Upload your Resume Now</a><br><br>
<?php } ?>
</div>
</div>
</div>
</section> 
<?php
include_once 'footer.php';
?>
</body>
</html>
