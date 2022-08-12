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

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">	
<style>
body{
	padding:0px;
}

</style>
</head>
<body>
<?php 
include("functions/init.php");
?>
<?php
include_once 'header.php';
$userid=-1;
$result=false;
if( isset($_SESSION['usertype'])&&$_SESSION['usertype']==1)
{
$id=get_appid_by_username( $_SESSION['username']);
$sql_userid="select * from applicant where id=$id";
$res1=$con->query($sql_userid);
$app_record=$res1->fetch_assoc();
$userid = $app_record['user_id'];

}
if( isset($_SESSION['usertype'])&&$_SESSION['usertype']==2)
{
$id=get_hrid_by_username( $_SESSION['username']);
$sql_userid="select * from hr_manager where id=$id";
$res1=$con->query($sql_userid);
$app_record=$res1->fetch_assoc();
$userid = $app_record['user_id'];

}
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
		if(isset($_POST["sendmsg"]))  
		{	
			$name =$_POST['name']; 
			$email=$_POST['email'];
			$subject=$_POST['subject'];
			$message=$_POST['message'];
			$sql  ="INSERT INTO messages ( from_id, name, email, subject, msg)";
			$sql .= " VALUES('$userid','$name','$email','$subject','$message')";			
			$result = $con->query($sql);
			confirm($result);
		}
	}
?>


<section class="body-section">

  <div class="content">
    
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10">
          

          <div class="row justify-content-center">
            <div class="col-md-6">
              
              <h3 class="heading mb-4">Let's talk about everything!</h3>
              <p>Feel free to submit your feedback,we appreciate your message and we are here to help you ...</p>

              <p><img src="images/undraw-contact.svg" alt="Image" class="img-fluid"></p>


            </div>
            <div class="col-md-6">
              
              <form class="mb-5" method="post" id="contactForm" name="contactForm">
                <div class="row">
                  <div class="col-md-12 form-group">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Your name">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 form-group">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 form-group">
                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 form-group">
                    <textarea class="form-control" name="message" id="message" cols="30" rows="7" placeholder="Write your message" required></textarea>
                  </div>
                </div>  
                <div class="row">
                  <div class="col-12">
                    <input type="submit" name="sendmsg" value="Send Message" class="btn btn-primary rounded-0 py-2 px-4">
                  <span class="submitting"></span>
                  </div>
                </div>
              </form>

              <div id="form-message-warning mt-4"></div> 
			  <?php if($result == true)
			  {
				echo '<div id="form-message-success">
						Your message was sent, thank you!
					  </div>';
			    }
				  ?>
             
			  
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>


</section> 
<script src="js/jquery.validate.min.js"></script>

<?php
include_once 'footer.php';
?>
</body>
</html>
