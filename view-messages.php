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
$sql="delete from joboffer where id=$id";
$con->query($sql);
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
<th>SUBJECT</th>
<th>From</th>
<th>Name</th>
<th>Message Date</th>
<th>Email</th>
<th></th>
</tr>
<?php
$sql="select * from messages where isread='0'";
$result=$con->query($sql);
while($record=$result->fetch_assoc()){
$msgid=$record['msg_id'];
$uid=$record['from_id'];
$msgfrom='';
if($uid==-1){
	$msgfrom='Guest';
}
else{
	$sql2="select username from users where id=$uid";
	$result2=$con->query($sql2);	
	$record2=$result2->fetch_assoc();
	$msgfrom=$record2['username'];
}

?>
<tr>
<td><?php echo $record['subject'];?></td>
<td><?php echo $msgfrom;?></td>
<td><?php echo $record['name'];?></td>
<td><?php $date=date_create($record['msg_date']); echo date_format($date,"d/m/y");?></td>
<td><?php echo $record['email'];?></td>
<td>
<a  href="message-details.php?id=<?php echo $msgid ?>" target="_blank"> <button>Details </button></a>
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
