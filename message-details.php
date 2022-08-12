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


if(!empty($_GET['id']))
{
	$id=$_GET['id'];
	$sql="SELECT * FROM messages where msg_id=".$id;
	$result=$con->query($sql);
	$record=$result->fetch_assoc();
	$uid=$record['from_id'];
	
	$name = $record['name'];
	$email = $record['email'];
	$subject = $record['subject'];
	$msg_date = $record['msg_date'];
	$msg = $record['msg'];
	$isread = $record['isread'];

	
	$sql2="select username from users where id=$uid";
	$result2=$con->query($sql2);	
	$record2=$result2->fetch_assoc();
	$msgfrom=$record2['username'];

	if($_SERVER['REQUEST_METHOD'] == "POST"){
		 if(isset($_POST["markread"]))  {
			
			$sql3  ="UPDATE `messages` SET `isread` = '1' WHERE `msg_id` = $id";
			$result3 = $con->query($sql3);
			if($result3 ==true){					
				$notification = "Message marked as read successfully !";
				echo "<div class='notif'>".validation_success($notification)."</div>";
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
			

	<h2> <?php echo $subject; ?> </h2>
	<h5> <?php echo $name.", ".date("d.m.Y", strtotime($msg_date)); ?> </h5>
	
	<h3> Email </h3>
	<p> <?php echo $email; ?> </p>

	<h3> Message </h3>
	<p> <?php echo $msg; ?>  </P>
	

	<?php if(  (isset($_SESSION['usertype']) && $_SESSION['usertype']==0)) { ?>
	<form  method="post" role="form" >
	<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-lg-push-4 col-sm-push-4 col-md-push-5 col-xs-push-5 form-group">
	<br /><input type="submit" value="Mark as read" name="markread" class="form-control" style="width:200px;"/>
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
