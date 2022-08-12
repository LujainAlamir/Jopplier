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
<th>JOB TITLE</th>
<th>Faculty</th>
<th>Category</th>
<th>Posted on</th>
<th>Applied</th>
<th></th>
</tr>
<?php
$sql="select id,title,facultyid,category,applied,posted from joboffer";
$result=$con->query($sql);
while($record=$result->fetch_assoc()){
$fid=$record['facultyid'];
$sql2="select name from faculty where ID_faculty=$fid";
$result2=$con->query($sql2);	
$record2=$result2->fetch_assoc()
?>
<tr>
<td><?php echo $record['title'];?></td>
<td><?php echo $record2['name'];?></td>
<td><?php echo $record['category'];?></td>
<td><?php $date=date_create($record['posted']); echo date_format($date,"d.m.y");?></td>
<td><?php echo $record['applied'];?></td>
<td>
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
