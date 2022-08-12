
<?php
session_start();
if($_SESSION['username']!="admin"){
$_SESSION['msg']="1";
header("location:login.php");
exit();
}
?>

<body >

<?php 
include_once 'header.php';
$servername = "localhost";
$username = "root";
$password = "";
$con = new mysqli($servername, $username, $password, "jopplier_db");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 

?>



<section class="admin-section">
<div class="container-fluid">
<div class="row">
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 dashboard" id="demo">
<h2>Dashboard</h2>
<div class="col-lg-4 col-md-4 col-sm-2 col-xs-2 dashboard-pannel">
<div class="row">
<div class="pannel-content"><span class="fa fa-building"></span>
<h4><?php $sql="select * from joboffer"; $result=$con->query($sql); echo $result->num_rows;?></h4></div>
<div class="pannel-footer" style="background-color: #fe9426">
<p>Total Jobs</p>
</div>
</div>
</div>
<div class="col-lg-4 col-md-4 col-sm-2 col-xs-2 dashboard-pannel">
<div class="row">
<div class="pannel-content"><span class="fa fa-vcard"></span>
<h4><?php $sql="select * from applicant"; $result=$con->query($sql); echo $result->num_rows;?></h4></div>
<div class="pannel-footer" style="background-color: #fb3157">
<p>Registered Applicants</p>
</div>
</div>
</div>
<div class="col-lg-4 col-md-4 col-sm-2 col-xs-2 dashboard-pannel" >
<div class="row">
<div class="pannel-content"><span class="fa fa-briefcase"></span>
<h4><?php $sql="select * from hr_manager"; $result=$con->query($sql); echo $result->num_rows;?></h4></div>
<div class="pannel-footer" style="background-color: #157efb">
<p>Total HR Managers</p>
</div>
</div>
</div>
<div class="col-lg-4 col-md-4 col-sm-2 col-xs-2 dashboard-pannel">
<div class="row">
<div class="pannel-content"><span class="fa fa-user-circle"></span>
<h4><?php echo ($_COOKIE['count']+1); ?></h4>
</div>

<div class="pannel-footer" style="background-color:#53d769">
<p>Total Visitors</p>
</div>
</div>

</div>
</div>
</div>
</div>
</section>



<?php
include_once 'footer.php';


?>
<script>
function link(sub) {
	var page=sub;
  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", page, false);
  xhttp.send();
  document.getElementById("demo").innerHTML = xhttp.responseText;
}
</script>
</body>
</html>
