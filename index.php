<?php

define( "day", 60*60*24); // define constant
if(isset($_COOKIE['count'])){
	setcookie( "count", $_COOKIE['count']+1, time() + day );
}else{
	setcookie( "count", 1 , time() + day );
}

?>
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
</head>
<body>
<!--header starts here-->
<?php 
include("functions/init.php");
?>
<?php
include_once 'header.php';
?>
      <?php if(!empty($_SESSION['username'])){?>
         <?php if($_SESSION['usertype']==1 || $_SESSION['usertype']==2){?>
		  <section class="applicant-banner" style="margin: 10px 0px;">
			<h1>Welcome <?php echo $_SESSION['username'] ?></h1>
		 </section>
		 <?php } ?>
 
	  <?php } ?>




<!--header ends here-->

<!--slider section starts here-->
<section style="height: 500px">
  <div class="container-fluid" >
    <div class="row">
      <div id="myCarousel" class="carousel slide" data-ride="carousel" >
        <!---carousel content--->
        <div class="carousel-content">
          <h1>Your Future Begins Here</h1>
          <p> More than 10000+ Jobs Available </p>
          <div class="col-lg-10 col-lg-push-1">
            <form action="search.php" method="post">
              <div class="form-group">
                <div class="col-lg-12">
                  <div class="row">
                    <input type="text" class="form-control" name="search1" placeholder="Looking for a Job" style="border:none; border-radius: 10px 10px; margin: 15px 0px"/>
                  </div>
                </div>
              </div>
			
              <div class="form-group">
                <div class="col-lg-5 col-lg-push-5">
                  <div class="col">
                    <input type="submit" name="outbtn" class="slider-btn" value="Search" />
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
          <div class="item active" > <img  src="images/header_background.jpg" style="opacity: 0.6;"> </div>
		  </div>
      </div>
    </div>
  </div>
</section>
<!--slider section ends here-->


<!--find job by category section starts here-->
<section class="category">
<div class="container">
<div class="row">
<h1>Find jobs by category</h1>
<div class="col-lg-4 category-content">
<span class="glyphicon glyphicon-briefcase"></span><br />
<a href="search.php?cat=3">Software</a>
</div>
<div class="col-lg-4 category-content">
<span class="glyphicon glyphicon-wrench"></span><br />
<a href="search.php?cat=6">Mechanical</a>
</div>
<div class="col-lg-4 category-content">
<span class="glyphicon glyphicon-heart"></span><br />
<a href="search.php?cat=5">Customer Service</a>
</div>
</div>
<div class="row">
<div class="col-lg-4 category-content">
<span class="glyphicon glyphicon-credit-card"></span><br />
<a href="search.php?cat=2">Accounting</a>
</div>
<div class="col-lg-4 category-content">
<span class="glyphicon glyphicon-education"></span><br />
<a href="search.php?cat=1">Education</a>
</div>
<div class="col-lg-4 category-content">
<span class="glyphicon glyphicon-usd"></span><br />
<a href="search.php?cat=4">Marketing</a>
</div>
</div>
<div class="row">
<div class="col-lg-4 col-lg-push-5">
<a href="search.php" class="thm-btn">Browse all category</a>
</div>
</div>
</div>
</div>
</section>
<!--find job by category section ends here-->

<?php function h_thumb_item($j,$faculty) { ?>
	<div class="row recent-jobs" >
		<div class="col-lg-4 rj-title">
		<h4><?php echo $j['title'] ?></h4>
		</div>
		<div class="col-lg-2 rj-location">
		<span class="glyphicon glyphicon"> <h4><?php echo $faculty ?></h4></span>
		</div>
		<div class="col-lg-2 rj-posted">
		<span class="glyphicon glyphicon-time"> <h4> <?php $date=date_create($j['posted']); echo date_format($date,"d.m.y");?> </h4></span>
		</div>
		<div class="col-lg-3">
		<a href="post-details.php?id=<?php echo $j['id'] ?>" class="thm-btn">view details</a>
		</div>
	</div>
<?php } ?>
<!--recent jobs starts here-->
<section class="recent">
<div class="container">
<h1>Recently Posted</h1>
<?php 
#order by posted ASC
$sql = "SELECT *  FROM joboffer order by posted DESC";
$res = $con->query($sql);
	
if(row_count($res) >=1){
?>
	<div class="row recent-jobs-title" >
		<div class="col-lg-4 rj-title">
		<h4>title</h4>
		</div>
		<div class="col-lg-2 rj-location">
		 <h4>Faculty</h4>
		</div>
		<div class="col-lg-2 rj-posted">
		 <h4> Posted on </h4>
		</div>
	</div>
	<?php
		$count=0;	
		while($j = $res->fetch_array() )
		{
			if($count<2){
				$fid=$j['facultyid'];
				$sql2="select name from faculty where ID_faculty=$fid";
				$result2=$con->query($sql2);
				$p_record=$result2->fetch_assoc();
				h_thumb_item($j,$p_record['name']);
			}
			else 
				break;
			$count=$count+1;
		}
?>


<?php }else{
		echo"<center> <strong>	<p> No Posts yet .. </p> </strong> </center>";
	} ?>
</div>
</div>
</div>
</section>
<!--recent jobs ends here-->

<!--Top Applicant starts here-->
<section class="top-emp">
<div class="container">
<div class="row top-employers">
<h1>Our Top Applicant </h1>
<h4 align="center">coming soon</h4>
</div>
</div>
</section>
<!--Top employers ends here-->

<!--footer section starts here-->
<?php
include_once 'footer.php';
?>
<!--footer section ends here-->

</body>
</html>
