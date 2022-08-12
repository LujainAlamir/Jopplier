<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jopplier</title>
<link rel="stylesheet" href="bootstrap.min.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<link rel="stylesheet" href="style.css" />
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>

<header>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-md-3 logo" > 
	  <a href="index.php"><img src="images/logo2.png"/> </a>
      </div>


      <?php
if(empty($_SESSION['username'])){?>


<div class=" signin" style="text-align:right; padding-right:8%;">  <a href="login.php">Login</a> <a href="signup.php">Sign up</a>  </div>


<?php } else {
	
	if($_SESSION['usertype']==0){?>
	   <div class="col-md-6 col-lg-6 nav-menu">
		  <div class="dropdown">
		<img class="nav-images" src="images/dashboard-icon.jpg"/>
		<a href="admin-index.php">
          <button class="dropbtn">Dashboard</button>
          </a> </div>
        <div class="dropdown">
		<img class="nav-images" src="images/post-icon.png"/>
		<a  href="post-job.php">
          <button class="dropbtn">Post</button>
          </a> </div>
	   <div class="dropdown">
		<img class="nav-images" src="images/view-icon.png"/>
		<a href="view-all.php">
          <button class="dropbtn">View</button>
          </a> </div>
        <div class="dropdown">
		<img class="nav-images" src="images/manage-icon.png"/>
          <button class="dropbtn">Manage <span class="glyphicon glyphicon-triangle-bottom"></span></button>
          <div class="dropdown-content" > <a href="manage-job-posts.php">Manage Job Posts</a> <a href="manage-applicants.php">Manage Applicants</a></div>
        </div>
		<div class="dropdown"> <a href="logout.php">
		<img class="nav-images" src="images/logout-icon.png"/>
          <button class="dropbtn">logout</button>
          </a> </div>
      </div>
	 <?php } ?>
     <?php if($_SESSION['usertype']==1){?>
	       <div class="col-md-6 col-lg-6 nav-menu">
        <div class="dropdown">
		<img class="nav-images" src="images/home-icon.png"/>
		<a href="index.php">
          <button class="dropbtn">HOME</button>
          </a> </div>
	   <div class="dropdown">
		<img class="nav-images" src="images/search-icon.png"/>
		<a href="search.php">
          <button class="dropbtn">Search</button>
          </a> </div>
        <div class="dropdown">
		<img class="nav-images" src="images/profile-icon.png"/>
          <button class="dropbtn">Profile <span class="glyphicon glyphicon-triangle-bottom"></span></button>
          <div class="dropdown-content" > 
		  <a href="edit-profile.php">Edit Profile</a> 
		  <a href="view-applied-posts.php"> View Applied Posts </a>
		  <a href="view-meetings.php"> View Meetings </a></div>
        </div>
        <div class="dropdown"> <a href="about_us.php">
		  <img class="nav-images" src="images/about-icon.png"/>
          <button class="dropbtn">About US</button>
          </a> </div>
        <div class="dropdown"> <a href="contact-us.php">
		<img class="nav-images" src="images/contact-icon.png"/>
          <button class="dropbtn">CONTACT US</button>
          </a> </div>
		 <div class="dropdown"> <a href="logout.php">
		<img class="nav-images" src="images/logout-icon.png"/>
          <button class="dropbtn">logout</button>
          </a> </div>
      </div>
	 <?php } ?>
	 <?php if($_SESSION['usertype']==2){?>
	       <div class="col-md-6 col-lg-6 nav-menu">
        <div class="dropdown">
		<img class="nav-images" src="images/home-icon.png"/>
		<a href="index.php">
          <button class="dropbtn">HOME</button>
          </a> </div>
	   <div class="dropdown">
		<img class="nav-images" src="images/view-icon.png"/>
		<a href="view-jobs.php">
          <button class="dropbtn">View</button>
          </a> </div>
        <div class="dropdown">
		<img class="nav-images" src="images/profile-icon.png"/>
          <button class="dropbtn">Profile <span class="glyphicon glyphicon-triangle-bottom"></span></button>
          <div class="dropdown-content" > <a href="edit-profile.php">Edit Profile</a> <a href="view-meetings.php">View Meetings</a></div>
        </div>
        <div class="dropdown"> <a href="about_us.php">
		  <img class="nav-images" src="images/about-icon.png"/>
          <button class="dropbtn">About US</button>
          </a> </div>
        <div class="dropdown"> <a href="contact-us.php">
		<img class="nav-images" src="images/contact-icon.png"/>
          <button class="dropbtn">CONTACT US</button>
          </a> </div>
		  		 <div class="dropdown"> <a href="logout.php">
		<img class="nav-images" src="images/logout-icon.png"/>
          <button class="dropbtn">logout</button>
          </a> </div>
      </div>
	 <?php } ?>

         <?php if($_SESSION['usertype']==1 || $_SESSION['usertype']==2){
			 $imagename="baseprofile.svg.png";
			 $servername = "localhost";
			$username = "root";
			$password = "";
			$con = new mysqli($servername, $username, $password, "jopplier_db");
			if ($con->connect_error) {
				die("Connection failed: " . $con->connect_error);
			} 
			
			if($_SESSION['usertype']==1 ){
				$appid=get_appid_by_username( $_SESSION['username']);
				 $sql="SELECT image_name FROM applicant where id=".$appid;
				$result=$con->query($sql);
				if(row_count($result) >=1){
					$record=$result->fetch_assoc();	
					if($record['image_name']!==null)
					   $imagename=$record['image_name'];			
				}
			}
			else{
				$hrid=get_hrid_by_username( $_SESSION['username']);
				$sql="SELECT image_name FROM hr_manager where id=".$hrid;
				$result=$con->query($sql);
				if(row_count($result) >=1){
					$record=$result->fetch_assoc();
					if($record['image_name']!==null)					
					   $imagename=$record['image_name'];			
				}

			}
			 ?>
		  <div class="col-lg-3 col-md-3 profile-img" > 
		  
		  <!--<a href="index.php"><img src="profiles/baseprofile.svg.png"/> </a>-->
		  <a href="index.php"><img src="profiles/<?php echo $imagename ?>"/> </a>
		  </div>
		 <?php } ?>
		<?php if($_SESSION['usertype']==0){ ?>
			<div class="col-lg-1 col-md-3 messages-img"  > 
		  <a href="view-messages.php"><img src="images/messages.png"/> </a>
		  </div>
		 <?php } ?>
		
<?php } ?>



    </div>
  </div>
</header>
</body>
      <?php if(!empty($_SESSION['username'])){?>
		  <?php if($_SESSION['usertype']==0){?>
			<section class="admin-banner">
			<h1>Welcome Zainab</h1>
			</section>
		 <?php } ?>
	 
	  <?php } ?>
</html>
