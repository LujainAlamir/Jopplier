
<?php
session_start();
if($_SESSION['username']!="admin"){
header("location:login.php");
exit();
}
?>
<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button {  

   opacity: 1;

}
.skillscontainer { border:2px solid #ccc; width:400px; height: 100px; overflow-y: scroll;}
</style>
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
$sql = "SELECT ID_faculty, name  FROM faculty";
$facultyList = $con->query($sql);

?>

<?php
function validation_errors($error_message){

	$error_message = <<<DELIMITER

        <div class="alert alert-danger alert-dismissible" role="alert" style="margin:0px 400px;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong=Warning</Strong> $error_message 
        </div>

DELIMITER;
        
return $error_message;
}
function validation_success($success_message){

	$success_message = <<<DELIMITER

        <div class="alert alert-success alert-dismissible" role="alert" style="margin:0px 400px;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong=Success</Strong> $success_message 
        </div>

DELIMITER;
        
return $success_message;
}
if($_SERVER['REQUEST_METHOD']=='POST')
{
$errors = [];

$cat_type =$_POST['cat_type']; 
$title=$_POST['title'];
$job_description=$_POST['description'];
$salary=$_POST['salary'];
$skills=$_POST['skills'];
$experience=$_POST['experience'];
$facultyid= $_POST['pfaculty'];
$adminid=$_SESSION['adminid'];

   if(empty($title)){
   	$errors[] = "Post title cannot be empty";
   }
   if(empty($job_description)){
   	$errors[] = "Post job_description cannot be empty";
   }
   if(empty($salary)){
   	$errors[] = "Post salary cannot be empty";
   }
   if(empty($skills)){
   	$errors[] = "Post skills cannot be empty";
   }
   if(!empty($errors)) {
		foreach ($errors as $error) {
			echo validation_errors($error);
		}
   } else {
	$sql  ="INSERT INTO joboffer (category, title, description, salary, skills, yearExperience, facultyid, adminid)";
	$sql .= " VALUES('$cat_type','$title','$job_description','$salary','$skills','$experience','$facultyid','$adminid')";
	$result = $con->query($sql);
	if($result ==true){
			$notification = "The Job Offer has been posted!";
			echo validation_success($notification);
	} else 
	{
		echo "Error: " . $sql . $con->error;
	}

   }
}
?>




<section class="admin-section">
<div class="container-fluid">
<div class="row">

<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 dashboard" style="margin-left:15%;">
<section class="body-section">
<div class="container">
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-lg-push-3 col-sm-push-3 col-md-push-3 col-xs-push-3 inner-body">
<div class="container">
<h2>Post a Job</h2>
<br />
<form  method="post">
<label class="control-label" style="width:400px;">Category: 
					<select  name="cat_type" id="cat_type" style="color:black;" class="form-control">
					<option value="1">Education</option>
					<option value="2">Accounting</option>
					<option value="3">Software</option>
					<option value="4">Marketing</option>
					<option value="5">Customer Service</option>
					<option value="6">Mechanical</option>
					</select>
					</label> <br />
<label class="control-label" style="width:400px;">Faculty: 
					<select name="pfaculty" id="pfaculty" style="color:black;" class="form-control">
						<?php 
						while($row = $facultyList->fetch_array())
						{
							echo "<option value=".$row['ID_faculty'].">" . $row['name'] . "</option>";
						}
						?>
					</select>
</label>  <br />
<label class="control-label" style="width:400px;">Job title: <input type="text" name="title"  class="form-control" /> </label> <br/>
<label class="control-label" style="width:400px;"> Job description:  <textarea rows="6" name="description"  class="form-control" > </textarea>  </label> <br/>

<label class="control-label" style="width:400px;">Salary:  <input type="text" name="salary"  class="form-control" /></label><br />
<label class="control-label" style="width:400px;">skills: 
<div class="skillscontainer">
    <input type="checkbox" value="Algorithm Coding"/> Algorithm Coding <br />
    <input type="checkbox" value="Data Structure"/> Data Structure <br />
    <input type="checkbox" value="SQL"/> SQL <br />
    <input type="checkbox" value="API"/> API <br />
    <input type="checkbox" value="Communication"/> Communication <br />
    <input type="checkbox" value="Teamwork"/> Teamwork<br />
    <input type="checkbox" value="Accountability"/> Accountability <br />
    <input type="checkbox" value="Problem-Solving"/> Problem-Solving<br />
    <input type="checkbox" value="Git"/> Git <br />
    <input type="checkbox" value="Front End Developer"/> Front End Developer <br />
	<input type="checkbox" value="Back End Developer"/> Back End Developer <br />
	<input type="checkbox" value="Full Stack Developer"/> Full Stack Developer <br />
	<input type="checkbox" value="Cloud Developer"/> Cloud Developer <br />
	<input type="checkbox" value="Tools and Enterprise Developer"/> Tools and Enterprise Developer <br />
	<input type="checkbox" value="Linux Kernal and OS Developer"/> Linux Kernal and OS Developer <br />
	<input type="checkbox" value="DevOps Engineer"/> DevOps Engineer <br />
</div>
 <input type="button" style="margin:10px 0px;" onClick="addskills()" value="add skills"/> 

 <input type="text" id="skillsinput" name="skills"  class="form-control"  readonly/>
 </label>
 <br />
<label class="control-label" style="width:400px;">year Experience: <input type="number" name="experience" value="1" min="1" max="50" class="form-control" /> </label> <br />
<br />
<br />
<label class="control-label" style="margin-left:6%;width:250px;">
<input type="submit" value="Post" class="form-control"/>
</label>
</form>
</div>
</div>
</div>
</div>
</section>
</div>
</div>
</div>
</section>

<script>
function addskills(){
	var array = []
	var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')

	for (var i = 0; i < checkboxes.length; i++) {
	  array.push(checkboxes[i].value)
	}
	var skills="";
	for (var i = 0; i < checkboxes.length; i++) {
    skills+=(checkboxes[i].value)+"; ";
   }
	document.getElementById('skillsinput').value = skills;
}
</script>

<?php
include_once 'footer.php';


?>

</body>

</html>
