
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
$userid = $app_record['user_id'];
$sql_userinfo="select * from users where id=$userid";
$res2=$con->query($sql_userinfo);
$user_record=$res2->fetch_assoc();
$appusername=$user_record['username'];

$hrid=get_hrid_by_username( $_SESSION['username']);


}
else{
	header("location:index.php");
	exit();
}
?>
<!--header ends here-->
		  <section class="applicant-banner" style="margin: 10px 0px;">
			<h1>Schedule Meeting with <strong style="font-size:30px; background-color:#3c5bba;"># <?php echo $appusername ?> </strong> </h1>
		 </section>
<section class="signup-portal">
<div class=" signup-inner" style="padding-left:20%;">
<?php 
if($_SERVER['REQUEST_METHOD'] == "POST"){
   if(isset($_POST["conf"]))  {
	  $place=$_POST['place'];
	  $meetingtime = $_POST['date'];
	  $duration=$_POST['duration'];
	  $attendees=$_POST['attendees'];
	  $errors = [];
	  
	   if(empty($place)){
		$errors[] = "place cannot be empty";
	   }
	   if(empty($meetingtime)){
		$errors[] = "meeting time cannot be empty";
	   }
	   if(empty($duration)){
		$errors[] = "duration cannot be empty";
	   }
	   if(empty($attendees)){
		$errors[] = "attendees cannot be empty";
	   }
	   if(!empty($errors)) {
			foreach ($errors as $error) {
				echo validation_errors($error);
			}
	   }else{	  
		  $sql3="INSERT INTO `meeting`(`place`, `mtime`, `duration`, `attendees`, `hrid`, `applicantid`) VALUES ('$place','$meetingtime',$duration,'$attendees',$hrid,$appid)";
		  $res=$conn->query($sql3);
		  if($res){
				$notification = "Meeting has been set successfully ...";
				echo validation_success($notification);
		  }
	   }
   }
}

?>

<form method="post" role="form" >
<input type="hidden" name="id" value="<?php echo (isset($id))?$id:'';?>"/>
<input type="hidden" name="user_id" value="<?php echo (isset($userid))?$userid:'';?>"/>
<input type="hidden" name="utype" value="1"/>
<div class="container">
<div class="row">
<div class="col-lg-8 form-group">
<label class="control-label">Place: </label>
 <textarea rows="4" name="place"  class="form-control" > </textarea> 
</div>
</div>
<div class="row">
<div class="col-lg-4 form-group">
<label class="control-label">Date and Time: </label><input type="datetime-local"  name="date" class="form-control"/></div>

</div>
<div class="row">
<div class="col-lg-4 form-group" id="exp_num_div">
<label class="control-label">Duration (in minutes): </label>
<input type="number" name="duration" value="15"  min="10" max="100" class="form-control"/>
</div>
</div>


<div class="row">
<div class="col-lg-8 form-group">
<label class="control-label" style="width:780px;" > Attendees: 
 <input type="text" id="attname" name="attname"  class="form-control" />
 <input type="button" style="margin:10px 0px;" onClick="addAttendees()" value="add Attendee" /> 

 <input type="text"  id="attendeesinput" name="attendees"  class="form-control"  readonly/>
 </label>
 </div>
</div>

<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-lg-push-3 col-sm-push-3 col-md-push-3 col-xs-push-3 form-group">
<br /><input type="submit" value="Confirm" name="conf" class="form-control" style="width:200px;"/>
</div>
</div>
</div>
</form>
</div>
</section>


<script>
function addAttendees(){
	var att = document.getElementById('attname').value;

	document.getElementById('attendeesinput').value += att+"; ";
	document.getElementById('attname').value="";
}
 
</script>
<!--footer section starts here-->
<?php
include_once 'footer.php';
?>
<!--footer section ends here-->

</body>
</html>
