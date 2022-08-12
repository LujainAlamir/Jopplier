<?php

if(  (isset($_SESSION['usertype']) && $_SESSION['usertype']==2)) {
	
header("location:login.php");
exit();
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jopplier - Add CV</title>
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
.chkboxcontainer { border:2px solid #ccc; width:750px; height: 100px; overflow-y: scroll;}
.langdiv{
	padding-left:20px;
	display: inline-block;
    visibility : hidden ;
}
#cvbody{
	margin: 0px 0px;
 background-color:#fcfcfc;

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

$sql = "SELECT ID_location, city  FROM location";
$locationList = $conn->query($sql);

#----------------------------------------------#
$id=get_appid_by_username( $_SESSION['username']);
$sql_userid="select * from applicant where id=$id";
$res1=$con->query($sql_userid);
$app_record=$res1->fetch_assoc();
$userid = $app_record['user_id'];
$reslocation = $app_record['locationid'];






?>
<!--header ends here-->
		<section class="applicant-banner" style="margin: 10px 0px;">
			<h1>Curriculum Vitae(cv)</h1>
		</section>
<section  >
<div class=" signup-inner" style="padding-left:20%;" id="cvbody">


<?php validate_cv_info($id); ?>	


<form  method="post" role="form" >
<input type="hidden" name="app_id" value="<?php echo (isset($id))?$id:'';?>"/>
<input type="hidden" name="utype" value="1"/>
<div class="container">
<div class="row">
<div class="col-lg-8 form-group">
<label class="control-label">Education Info: </label> 
 <textarea rows="6"  name="eduinfo"  class="form-control" required > </textarea> 
</div>
</div>
<div class="row">
<div class="col-lg-8 form-group">
<label class="control-label">Experience Info: </label>
 <textarea rows="6" name="expinfo"  class="form-control"  required > </textarea> 
</div>
</div>
<div class="row">
<div class="col-lg-8 form-group">
<label class="control-label">Contact: </label>
 <input type="text" name="contact"  class="form-control" required />
</div>
</div>
<div class="row">
<div class="col-lg-8 form-group">
<label class="control-label">Email: </label>
 <input type="text" name="email"  class="form-control" required />
</div>
</div>
<div class="row">
<div class="col-lg-8 form-group">
<label class="control-label" style="width:780px;" > skills: 
<div class="chkboxcontainer">
    <input type="checkbox" name="skill" value="Algorithm Coding"/> Algorithm Coding <br />
    <input type="checkbox" name="skill" value="Data Structure"/> Data Structure <br />
    <input type="checkbox" name="skill" value="SQL"/> SQL <br />
    <input type="checkbox" name="skill" value="API"/> API <br />
    <input type="checkbox" name="skill" value="Communication"/> Communication <br />
    <input type="checkbox" name="skill" value="Teamwork"/> Teamwork<br />
    <input type="checkbox" name="skill" value="Accountability"/> Accountability <br />
    <input type="checkbox" name="skill" value="Problem-Solving"/> Problem-Solving<br />
    <input type="checkbox" name="skill" value="Git"/> Git <br />
    <input type="checkbox" name="skill" value="Front End Developer"/> Front End Developer <br />
	<input type="checkbox" name="skill" value="Back End Developer"/> Back End Developer <br />
	<input type="checkbox" name="skill" value="Full Stack Developer"/> Full Stack Developer <br />
	<input type="checkbox" name="skill" value="Cloud Developer"/> Cloud Developer <br />
	<input type="checkbox" name="skill" value="Tools and Enterprise Developer"/> Tools and Enterprise Developer <br />
	<input type="checkbox" name="skill" value="Linux Kernal and OS Developer"/> Linux Kernal and OS Developer <br />
	<input type="checkbox" name="skill" value="DevOps Engineer"/> DevOps Engineer <br />
</div>
 <input type="button" style="margin:10px 0px;" onClick="addskills()" value="add skills"/> 

 <input type="text"  id="skillsinput" name="skills"  class="form-control"  readonly/>
 </label>
 </div>
</div>
<div class="row">
<div class="col-lg-8 form-group">
<label class="control-label" style="width:780px;" > Languages: 
<div class="chkboxcontainer">

    <input type="checkbox" class="langclass" name="lang"  value="Arabic"/> Arabic 
	<div id="Arabic" class="langdiv"> <input type="radio" name="Arabic"  value="Intermediate" checked /> Intermediate <input type="radio" name="Arabic"  value="Proficient"/> Proficient <input type="radio" name="Arabic"  value="Fluent"/> Fluent 
	</div><br />
    
	<input type="checkbox" class="langclass" name="lang" value="English"/> English 
	<div id="English" class="langdiv"> <input type="radio" name="English"  value="Intermediate" checked /> Intermediate <input type="radio" name="English"  value="Proficient"/> Proficient <input type="radio" name="English"  value="Fluent"/> Fluent 
	</div><br />

	<input type="checkbox" class="langclass" name="lang" value="German"/> German 
	<div id="German" class="langdiv"> <input type="radio" name="German"  value="Intermediate" checked /> Intermediate <input type="radio" name="German"  value="Proficient"/> Proficient <input type="radio" name="German"  value="Fluent"/> Fluent 
	</div><br />

	<input type="checkbox" class="langclass" name="lang" value="French"/> French 
	<div id="French" class="langdiv"> <input type="radio" name="French"  value="Intermediate" checked /> Intermediate <input type="radio" name="French"  value="Proficient"/> Proficient <input type="radio" name="French"  value="Fluent"/> Fluent 
	</div><br />

	<input type="checkbox" class="langclass" name="lang" value="Spanish"/> Spanish 
	<div id="Spanish" class="langdiv"> <input type="radio" name="Spanish"  value="Intermediate" checked /> Intermediate <input type="radio" name="Spanish"  value="Proficient"/> Proficient <input type="radio" name="Spanish"  value="Fluent"/> Fluent 
	</div><br />

	<input type="checkbox" class="langclass" name="lang" value="Portuguese"/> Portuguese 
	<div id="Portuguese" class="langdiv"> <input type="radio" name="Portuguese"  value="Intermediate" checked /> Intermediate <input type="radio" name="Portuguese"  value="Proficient"/> Proficient <input type="radio" name="Portuguese"  value="Fluent"/> Fluent 
	</div><br />	
	
	<input type="checkbox" class="langclass" name="lang" value="Japanese"/> Japanese 
	<div id="Japanese" class="langdiv"> <input type="radio" name="Japanese"  value="Intermediate" checked /> Intermediate <input type="radio" name="Japanese"  value="Proficient"/> Proficient <input type="radio" name="Japanese"  value="Fluent"/> Fluent 
	</div><br />		

	<input type="checkbox" class="langclass" name="lang" value="Chinese"/> Chinese 
	<div id="Chinese" class="langdiv"> <input type="radio" name="Chinese"  value="Intermediate" checked /> Intermediate <input type="radio" name="Chinese"  value="Proficient"/> Proficient <input type="radio" name="Chinese"  value="Fluent"/> Fluent 
	</div><br />	

	<input type="checkbox" class="langclass" name="lang" value="Korean"/> Korean 
	<div id="Korean" class="langdiv"> <input type="radio" name="Korean"  value="Intermediate" checked /> Intermediate <input type="radio" name="Korean"  value="Proficient"/> Proficient <input type="radio" name="Korean"  value="Fluent"/> Fluent 
	</div><br />	


	<input type="checkbox" class="langclass" name="lang" value="Hindi"/> Hindi 
	<div id="Hindi" class="langdiv"> <input type="radio" name="Hindi"  value="Intermediate" checked /> Intermediate <input type="radio" name="Hindi"  value="Proficient"/> Proficient <input type="radio" name="Hindi"  value="Fluent"/> Fluent 
	</div><br />		

	<input type="checkbox" class="langclass" name="lang" value="Russian"/> Russian 
	<div id="Russian" class="langdiv"> <input type="radio" name="Russian"  value="Intermediate" checked /> Intermediate <input type="radio" name="Russian"  value="Proficient"/> Proficient <input type="radio" name="Russian"  value="Fluent"/> Fluent 
	</div><br />

</div>
 <input type="button" style="margin:10px 0px;" onClick="addlanguages()" value="add Languages"/> 

 <input type="text"  id="langsinput" name="languages"  class="form-control"  readonly/>
 </label>
 </div>
</div>



<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-lg-push-3 col-sm-push-3 col-md-push-3 col-xs-push-3 form-group">
<br /><input type="submit" value="Add" name="submit" class="form-control" style="width:200px;"/>
</div>
</div>
</div>
</form>
</div>
</section>

<script>
function addskills(){
	var checkboxes = document.querySelectorAll("input[name='skill']:checked");

	var skills="";
	for (var i = 0; i < checkboxes.length; i++) {
    skills+=(checkboxes[i].value)+"; ";
   }
	document.getElementById('skillsinput').value = skills;
}
function addlanguages(){
	var checkboxes = document.querySelectorAll("input[name='lang']:checked");

	var langs="";
	for (var i = 0; i < checkboxes.length; i++) {
		var prof = document.querySelector('input[name="'+checkboxes[i].value+'"]:checked').value;
    langs+=(checkboxes[i].value)+"("+prof+")"+"; ";
   }
	document.getElementById('langsinput').value = langs;
}
$(".langclass").on("click", function(){
  if($(this).prop('checked')){
	  document.getElementById($(this).val()).style.visibility = "visible" ;
	  
	  
    } else {
		document.getElementById($(this).val()).style.visibility = "hidden" ;
       
    }
}); 
</script>

		 
<!--footer section starts here-->
<?php
include_once 'footer.php';
?>
<!--footer section ends here-->

</body>
</html>
