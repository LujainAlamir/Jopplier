<?php
session_start();
if($_SESSION['username']!="admin"){
$_SESSION['msg']="1";
header("location:login.php");
exit();
}
?>

<body>
<?php 
include_once 'header.php';
$servername = "localhost";
$username = "root";
$password = "";
$con = new mysqli($servername, $username, $password, "jopplier_db");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 
if(!empty($_GET['id']))
{
$id=$_GET['id'];
$sql_userid="select * from applicant where id=$id";
$res1=$con->query($sql_userid);
$app_record=$res1->fetch_assoc();
$userid = $app_record['user_id'];

$sql="delete from applicant where id=$id";
$con->query($sql);
$sql2="delete from users where id=$userid";
$con->query($sql2);
}
?>


<section class="admin-section" style="min-height: 400px;">
<div class="container-fluid">
<div class="row">
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 dashboard" id="demo">
<div class="container">
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
<table class="table table-hover" >
<tr>
<th>USER NAME</th>
<th>EMAIL</th>
<th>Phone Number</th>
<th>Location</th>
<th></th>
</tr>
<?php
$sql="select * from applicant";
$result=$con->query($sql);

while($record=$result->fetch_assoc()){
?>
<tr>
<?php
$uid=$record['user_id'];
$locid=$record['locationid'];

$sql2="select username,email,phoneNumber from users where id=$uid";
$result2=$con->query($sql2);

$sql3="select city from location where ID_location=$locid";
$result3=$con->query($sql3);
$u_record=$result2->fetch_assoc();
$l_record=$result3->fetch_assoc();
 ?>
<td><?php echo $u_record['username'];?></td>
<td><?php echo $u_record['email'];?></td>
<td><?php echo $u_record['phoneNumber'];?></td>
<td><?php echo $l_record['city'];?></td>
<td>
<p>
<a href="edit-applicant-details.php?id='<?php echo $record['id']; ?>'" target="_blank">edit</a>
<a href="manage-applicants.php?id=<?php echo $record['id']; ?>" onclick="return confirm('are you sure you want to delete this record?')">delete</a>
</p>
</td>
</tr>


<?php
}?>
</table>
</div>
</div>
</div>
</div>
</div>
</section>



<?php
include_once 'footer.php';


?>



</body>
</html>
