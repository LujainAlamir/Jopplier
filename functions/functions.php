<?php


/* HeLper Functions for cleaning htmltags and dislay he messages and setting the session message to be displayed in the session and generating a token */
function clean($string){

	return htmlentities($string);

}

function redirect($location){

	return header("Location: {$location}");

}



function set_message($message) {

  if(!empty($message)){
   
   $_SESSION['message']	= $message;
   
   }else {

	$message = "";
   }

}

function display_message(){

	if(isset($_SESSION['message'])){

		echo $_SESSION['message'];

		unset($_SESSION['message']);
	}
}


function token_generator(){

	$token =$_SESSION['token'] = md5(uniqid(mt_rand(),true));
	return $token;
  
}


function validation_errors($error_message){

	$error_message = <<<DELIMITER

        <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong=Warning</Strong> $error_message 
        </div>

DELIMITER;
        
return $error_message;
}
function validation_success($success_message){

	$success_message = <<<DELIMITER

        <div class="alert alert-success alert-dismissible" role="alert" style="width:500px;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong=Success</Strong> $success_message 
        </div>

DELIMITER;
        
return $success_message;
}


function email_exists($email){

	$sql = "SELECT id FROM users WHERE email ='$email'";

	$result = query($sql);

	if(row_count($result) ==1){
		return true;

	}else {
		return false;
	}
}


function username_exists($username){

	$sql = "SELECT id FROM users WHERE username ='$username'";

	$result = query($sql);

	if(row_count($result) ==1){
		return true;

	}else {
		return false;
	}
}
function admin_exists($username,$password){

	$sql = "SELECT id FROM admin WHERE username ='$username' and password = '$password'";

	$result = query($sql);

	if(row_count($result) ==1){
		return true;

	}else {
		return false;
	}
}

function get_admin_id($username,$password){
	$sql = "SELECT id FROM admin WHERE username ='$username' and password='$password'";
	$result = query($sql);
	
	if(row_count($result) ==1){
		$row = $result->fetch_array();	
	return $row['id'];

	}else {
		return -1;
	}
}

function get_appid_by_username($username){

	$sql = "SELECT id FROM users WHERE username ='$username' ";
	$result = query($sql);
	
	if(row_count($result) ==1){
		$row = $result->fetch_array();	
		$uid=$row['id'];
			$sql2 = "SELECT id FROM applicant WHERE user_id ='$uid' ";
			$result2 = query($sql2);
			$res = $result2->fetch_array();	
	return $res['id'];

	}else {
		return -1;
	}
}

function get_hrid_by_username($username){

	$sql = "SELECT id FROM users WHERE username ='$username' ";
	$result = query($sql);
	
	if(row_count($result) ==1){
		$row = $result->fetch_array();	
		$uid=$row['id'];
			$sql2 = "SELECT id FROM hr_manager WHERE user_id ='$uid' ";
			$result2 = query($sql2);
			$res = $result2->fetch_array();	
	return $res['id'];

	}else {
		return -1;
	}
}


function get_userid_by_username($username){

	$sql = "SELECT id FROM users WHERE username ='$username' ";
	$result = query($sql);
	
	if(row_count($result) ==1){
		$row = $result->fetch_array();	
	return $row['id'];

	}else {
		return -1;
	}
}


function send_email($email, $subject, $msg, $headers) {


return (mail($email, $subject, $msg, $headers));




}




/* Validation Functions*/

function validate_user_registration(){
  
   $errors = [];

   $min = 3;
   $max = 20;
   
  if($_SERVER['REQUEST_METHOD'] == "POST"){

  	$first_name = clean($_POST['first_name']);
  	$last_name = clean($_POST['last_name']);
	$phone_number = clean($_POST['phone_number']);
  	$username = clean($_POST['username']);
  	$email = clean($_POST['email']);
  	$password = clean($_POST['password']);
  	$confirm_password = clean($_POST['confirm_password']);
	$utype = clean($_POST['utype']);
	$location = clean($_POST['location']); 
	#----------------------------------------------
	$target_dir = "profiles/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
	#----------------------------------------------
	if($utype==1){
	$num_exp = clean($_POST['num_exp']);
	}else{
	#----------------------------------------------
	$facultyid = clean($_POST['faculty']); 
	}
	
   if(strlen($first_name) < $min) {

   	$errors[] = "Your first name cannot be less than {$min} characters ";

   }

   if(strlen($first_name) > $max) {

   	$errors[] = "Your first name cannot be greater than {$max} characters ";

   }


    if(empty($first_name)){

   	$errors[] = "Your Firstname cannot be empty";
   }


   if(strlen($last_name) < $min) {

   	$errors[] = "Your last name cannot be less than {$min} characters ";

   }

   if(strlen($last_name) > $max) {

   	$errors[] = "Your last name cannot be greater than {$max} characters ";

   }
   
   if(strlen($phone_number) != 10 ) {

   	$errors[] = "invalid phone Number ";

   }


    if(strlen($username) > $max) {

   	$errors[] = "Your username cannot be greater than {$max} characters ";

   }

   if(strlen($username) < $min) {

   	$errors[] = "Your user name cannot be less than {$min} characters ";

   }


    if(email_exists($email)){

     $errors[] = "Sorry that email is already registered ";

   }
    if(username_exists($username)){

     $errors[] = "Your that username is already registered ";

   }





   if(strlen($email) < $min) {

   	$errors[] = "Your email cannot be less than {$min} characters ";

   }

   if($password !== $confirm_password) {
 
    $errors[] = "Your passwords do not match";

   }
   if(isset($_FILES["fileToUpload"]["name"])){
	 $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	  if($check == false) {
		  $errors[] = "File is not an image.";
	}

	// Check if file already exists
	if (file_exists($target_file)) {
	  $errors[] =  "Sorry, file already exists.";
	}

	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
	  $errors[] =  "Sorry, your file is too large.";
	}

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	  $errors[] =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	}  
   }	


	 



   
   if(!empty($errors)) {

   	foreach ($errors as $error) {
   		

   		echo validation_errors($error);
   	}
   } else {
	   if(isset($_FILES["fileToUpload"]["name"])){
	     if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			 
			echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
		  } else {
			validation_errors( "Sorry, there was an error uploading your file.");
		  }
	   }
        if(register_user($first_name, $last_name,$phone_number, $username, $email, $password, $utype)){
			
			#check utype and insert according...
			if($utype==1){
				$uid=get_userid_by_username($username);
				if($uid!=-1){
					$mgname=htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));
			 	$sql  ="INSERT INTO applicant(image_name, locationid, yearExperience, user_id)";
				$sql .= " VALUES('$mgname','$location','$num_exp','$uid')";
				$result = query($sql);
				confirm($result);
				}
			}
			else{
				$uid=get_userid_by_username($username);
				if($uid!=-1){
					$mgname=htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));
			 	$sql  ="INSERT INTO hr_manager(image_name, locationid, 	facultyid, user_id)";
				$sql .= " VALUES('$mgname','$location','$facultyid','$uid')";
				$result = query($sql);
				confirm($result);
				}	
			}
			
			set_message("<p class='bg-success text-center'> Please Check Your Email for Activation Link</p>");
        	echo "Users Registered";
        	redirect("login.php");
			

        } else {

        	set_message("<p class='bg-danger text-center'> we could not register the user</p>");
        }

   }



  }//post request



} //function


/* ****************** Register user function**************  */
function register_user($first_name, $last_name, $phone_number, $username, $email, $password,$utype) {


	$first_name = escape($first_name);
	$last_name  = escape($last_name);
	$phone_number  = escape($phone_number);
    $username   = escape($username);
    $email      = escape($email);
    $password   = escape($password);
	$utype   = escape($utype);


	if(email_exists($email)) {

		return false;
	
	} else if (username_exists($username)) {

	   return false;

	 } else {
         
         $dbpassword        = md5($password);
           
         $validation_code = md5($username . microtime());  

	 	$sql  ="INSERT INTO users(first_name, last_name, phoneNumber, username, email, password, validation_code, active, utype)";
	    $sql .= " VALUES('$first_name','$last_name','$phone_number','$username','$email','$dbpassword','$validation_code', 0,'$utype')";
	    $result = query($sql);
	    confirm($result);



	    $subject = "Activation of Account";
	    $msg = "Please Click the link below to activate your account
        http://localhost/jopplier/activate.php?email=$email&code=$validation_code";

        $headers = "From: jopplier_pnu@yahoo.com";


        send_email($email, $subject, $msg, $headers);


        

	    return true;




	 }  

} 


/* ****************** Activate user function**************  */


function activate_user(){

	if($_SERVER['REQUEST_METHOD'] == "GET") {

		if(isset($_GET['email'])){


			echo $email = clean($_GET['email']);

			echo $validation_code = clean($_GET['code']);
		  
            $sql = "SELECT id FROM users WHERE email = '".escape($_GET['email'])."' AND validation_code ='".escape($_GET['code'])."' ";
            $result = query($sql);
            confirm($result);

            if(row_count($result) ==1) {

            $sql2 = "UPDATE users SET active =1, validation_code = 0 WHERE email ='".escape($email)."' AND validation_code ='" .escape($validation_code) ."' ";
            $result2 = query($sql2);
            confirm($result2);

            set_message("<p class='bg-success'>Your Account has been activated please login </p>");

            redirect("login.php");


          } else {


          	set_message("<p class='bg-danger'>Sorry Ur account is not activated</p>");
             redirect("login.php");
          }  

            
        }
	}

} //fucntion 


/*****************Validate user login Functions************** */
function validate_user_login() {
  
   $errors = [];

   $min = 3;
   $max = 20;
   
  if($_SERVER['REQUEST_METHOD'] == "POST"){

      


   $username    = clean($_POST['username']);
   $password = clean($_POST['password']); 
   $remember = isset($_POST['remember']);

   
  if(empty($username)) {

  	$errors[] = "Username Field cannot be empty";

  }

   if(empty($password)) {

  	$errors[] = "Password Field cannot be empty";
  	
  }


    
   if(!empty($errors)) {

   	foreach ($errors as $error) {
   		
        
   		echo  validation_errors($error);
   	}
   } else {

     
     if(login_user($username, $password, $remember)){
     	redirect("index.php");
     } else {

     	echo validation_errors("Your Credenials are not correct");

     }
      

   }


 }
 


}//function



/********User Login Functions*************/


function login_user($username, $password, $remember) {

if(admin_exists($username, $password)){
	 $_SESSION['username'] = $username;
	$_SESSION['usertype']= 0;
	$_SESSION['adminid']= get_admin_id($username,$password);
    if($remember == "on") {

    	setcookie('username', $username, time() + 86400);
    }

     redirect("admin-index.php");
}
else{

$sql = "SELECT password, utype ,id FROM users WHERE username = '".escape($username)."' AND active =1";

$result =query($sql);

if(row_count($result) ==1){
	
   $row = fetch_array($result);

   $db_password = $row['password'];
   $usertype = $row['utype'];
   if(md5($password) == $db_password){


    if($remember == "on") {

    	setcookie('username', $username, time() + 86400);
    }


	
    $_SESSION['username'] = $username;
	$_SESSION['usertype']= $usertype;

   	return true;

   } else {

   	return false;
   }




	return true;
   } else {

   	return false;

   }

}

} ////end of function.


/**********Logged in Function*******/

function logged_in(){


	if(isset($_SESSION['username']) || isset($_COOKIE['username'])){

		return true;

	}else{

		return false;
	}


}  //funcion


/******* recover function ******/

function recover_password() {

	if($_SERVER['REQUEST_METHOD'] == "POST") {

       if(isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'])  {

         
        $email = clean($_POST['email']);


        if(email_exists($email)){

         $validation_code = md5($email . microtime());

         setcookie('temp_access_code', $validation_code, time() + 900);


        $sql = "UPDATE users SET validation_code ='".escape($validation_code)."' WHERE email = '".escape($email)."'";
        $result = query($sql);
        confirm($result);
         	





        


         $subject = "please reset your password";
         $msg = "Here is the your password reset code {$validation_code}
           Click Here to reset your password http://localhost/jopplier/code.php?email=$email&code=$validation_code";

         $headers = "From: jopplier_pnu@yahoo.com";


        	if(!send_email($email, $subject, $msg, $headers)) {

              // sending email via localhost
                 echo validation_errors("email could not be sent");
        	
        	}

        	set_message("<p class='bg-success text-center'>Please Check your Spam folder for a password reset</p>");

        	redirect("recover.php");



        }else {

        	echo validation_errors("This email doesnot exists");
        }



         



       }else{  //token checking  if fails

       	redirect("index.php");
       }
        

     if(isset($_POST['cancel_submit'])){

        redirect("login.php");

     }  
     

    }// post request


     

}//functions 



/****** Code Validation****////
 
function validate_code(){

	if(isset($_COOKIE['temp_access_code'])) {

         
          if(!isset($_GET['email']) && !isset($_GET['code'])) {

                redirect("index.php");

         	} else if (empty($_GET['email']) || empty($_GET['code'])) {


                redirect("index.php");


         	}else {


         		if(isset($_POST['code'])){

                 
                 $email = clean($_GET['email']);

         		 $validation_code = clean($_POST['code']);

         		 $sql = "SELECT id FROM users WHERE validation_code ='".escape($validation_code)."' AND email ='".escape($email)."'";
         		 $result = query($sql);
         		 confirm($result);

         		 if(row_count($result) == 1){
                     
                    setcookie('temp_access_code', $validation_code, time() + 300);


         		 	redirect("reset.php?email=$email&code=$validation_code");

         		 }else {

         		 	echo validation_errors("Sorry wrong validation code");
         		 }
         		





         		}
         	}
         


	







	}else {

        set_message("<p class='bg-danger text-center'>Sorry Your Validation cookie was expired</p>");

         redirect("recover.php");
	}


} //function


/***********Password Reset*********/

function password_reset() {



	if(isset($_COOKIE['temp_access_code'])) {

      
        if(isset($_GET['email']) && isset($_GET['code'])) {


	        if(isset($_SESSION['token']) && isset($_POST['token']))  {


	         if($_POST['token'] === $_SESSION['token']) {


                
                if($_POST['password'] === $_POST['confirm_password']){

                  
                 $updated_password =md5($_POST['password']);



                $sql = "UPDATE users SET password ='".escape($updated_password)."', validation_code = 0 WHERE email = '".escape($_GET['email'])."' ";

                query($sql);


                set_message("<p class = 'bg-success text-center'> Your Password has been updated</p> ");

                redirect("login.php");

	        	    echo "Passwords Match";
                  }else {

                  	echo "Passwords donot Match";
                  }

	        	}


              }

	   
	    }
    

    }else {



    	set_message("<p class='bg-danger text-center'>Sorry Your Time has expired </p>");
        


          redirect("recover.php");
    

          }



     }

/********************************/
function validate_user_updating($oldusername,$oldemail){
   $errors = [];
   $min = 3;
   $max = 20;
   
  if($_SERVER['REQUEST_METHOD'] == "POST"){
  	$app_id = clean($_POST['app_id']);
  	$user_id = clean($_POST['user_id']);

  	$first_name = clean($_POST['first_name']);
  	$last_name = clean($_POST['last_name']);
	$phone_number = clean($_POST['phone_number']);
  	$username = clean($_POST['username']);
  	$email = clean($_POST['email']);
  	$password = clean($_POST['password']);
  	$confirm_password = clean($_POST['confirm_password']);
	$utype = clean($_POST['utype']);
	$location = clean($_POST['location']);
	$active_value=1; 
	if(isset($_POST['active_elem'])){	
		$active_value =1; 
	}
	else{
		$active_value =0;
	}
	#----------------------------------------------
	$imgname = (isset($_FILES['fileToUpload']['name'])?$_FILES['fileToUpload']['name']:'');
	$dir = 'profiles';
	$file = $dir. '\\' . basename($imgname);

	#----------------------------------------------
	$num_exp = clean($_POST['num_exp']);
	#----------------------------------------------

	
   if(strlen($first_name) < $min) {

   	$errors[] = "Your first name cannot be less than {$min} characters ";
   }
   if(strlen($first_name) > $max) {
   	$errors[] = "Your first name cannot be greater than {$max} characters ";
   }
    if(empty($first_name)){
   	$errors[] = "Your Firstname cannot be empty";
   }
   if(strlen($last_name) < $min) {
   	$errors[] = "Your last name cannot be less than {$min} characters ";
   }

   if(strlen($last_name) > $max) {
   	$errors[] = "Your last name cannot be greater than {$max} characters ";
   }
   
   if(strlen($phone_number) != 10 ) {
   	$errors[] = "invalid phone Number ";
   }
    if(strlen($username) > $max) {
   	$errors[] = "Your username cannot be greater than {$max} characters ";
   }
   if(strlen($username) < $min) {
   	$errors[] = "Your user name cannot be less than {$min} characters ";
   }
    if(($oldemail!=$email) && email_exists($email)){
     $errors[] = "Sorry that email is already registered ";
   }
    if(($oldusername!=$username) && username_exists($username)){
     $errors[] = "Your that username is already registered ";
   }
   if(strlen($email) < $min) {
   	$errors[] = "Your email cannot be less than {$min} characters ";
   }
   if($password !== $confirm_password) {
    $errors[] = "Your passwords do not match";
   }

   
   if(!empty($errors)) {

   	foreach ($errors as $error) {
   		

   		echo validation_errors($error);
   	}
   } else {
	   if(isset($_FILES['fileToUpload']['name'])){
		   if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			   
			$sql  ="UPDATE applicant SET image_name='".$imgname."'  where id=".$app_id;
			$result1 = query($sql);
			confirm($result1);	  		 
			echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
			
		  } else {
			validation_errors( "Sorry, there was an error uploading your file.");
		  }
	  
 
	   }
		$sql  ="UPDATE applicant SET  locationid=".$location.", yearExperience=".$num_exp." where id=".$app_id;
	    $result1 = query($sql);
        confirm($result1);
         	

		$dbpassword        = md5($password);
		$sql2  ="UPDATE users SET first_name='".$first_name."' , last_name='".$last_name."', username='".$username."', email='".$email."', phoneNumber='".$phone_number."', password='".$dbpassword."', active=".$active_value." where id=".$user_id;
	    $result2 = query($sql2);
        confirm($result2);
		
		if($result1 ==true && $result2 ==true){
			
				set_message("<p class='bg-success text-center'> Applicant Updated successfully ....</p>");
		} else 
		{
			echo "Error: " . $sql . $con->error;
		}
		
	

   }



  }//post request



} //function


/********************************/
function validate_user_editprofile($usertype,$oldusername,$oldemail){
  
   $errors = [];
   $min = 3;
   $max = 20;
   
  if($_SERVER['REQUEST_METHOD'] == "POST"){
	  if(isset($_POST["basesubmit"]))  {
	   $id = clean($_POST['id']);
		if($usertype==1){
		$num_exp = clean($_POST['num_exp']);
		}
		else{
		$facultyid = clean($_POST['faculty']);
		}
	   $user_id = clean($_POST['user_id']);

		$first_name = clean($_POST['first_name']);
		$last_name = clean($_POST['last_name']);
		$phone_number = clean($_POST['phone_number']);
		$username = clean($_POST['username']);
		$email = clean($_POST['email']);
		$utype = clean($_POST['utype']);
		$location = clean($_POST['location']);
		
		
		#----------------------------------------------
		$num_exp = clean($_POST['num_exp']);
		#----------------------------------------------

		
	   if(strlen($first_name) < $min) {

		$errors[] = "Your first name cannot be less than {$min} characters ";
	   }
	   if(strlen($first_name) > $max) {
		$errors[] = "Your first name cannot be greater than {$max} characters ";
	   }
		if(empty($first_name)){
		$errors[] = "Your Firstname cannot be empty";
	   }
	   if(strlen($last_name) < $min) {
		$errors[] = "Your last name cannot be less than {$min} characters ";
	   }

	   if(strlen($last_name) > $max) {
		$errors[] = "Your last name cannot be greater than {$max} characters ";
	   }
	   
	   if(strlen($phone_number) != 10 ) {
		$errors[] = "invalid phone Number ";
	   }
		if(strlen($username) > $max) {
		$errors[] = "Your username cannot be greater than {$max} characters ";
	   }
	   if(strlen($username) < $min) {
		$errors[] = "Your user name cannot be less than {$min} characters ";
	   }
		if(($oldemail!=$email) && email_exists($email)){
		 $errors[] = "Sorry that email is already registered ";
	   }
		if(($oldusername!=$username) && username_exists($username)){
		 $errors[] = "Your that username is already registered ";
	   }
	   if(strlen($email) < $min) {
		$errors[] = "Your email cannot be less than {$min} characters ";
	   }

	   
	   if(!empty($errors)) {

		foreach ($errors as $error) {
			

			echo validation_errors($error);
		}
	   } else {
			if($usertype==1){
			$sql  ="UPDATE applicant SET  locationid=".$location.", yearExperience=".$num_exp." where id=".$id;
			$result1 = query($sql);
			confirm($result1);
			}
			else{
			$sql  ="UPDATE hr_manager SET  locationid=".$location.", facultyid=".$facultyid." where id=".$id;
			$result1 = query($sql);
			confirm($result1);
			}
			$sql2  ="UPDATE users SET first_name='".$first_name."' , last_name='".$last_name."', username='".$username."', email='".$email."', phoneNumber='".$phone_number."' where id=".$user_id;
			$result2 = query($sql2);
			confirm($result2);
			
			if($result1 ==true && $result2 ==true){				    
				echo validation_success("Updated successfully ....");					
			} else 
			{
				echo "Error: " . $sql . $con->error;
			}
			
	   }
	  }
  }//post request

} //function
function validate_user_editPass(){
     $errors = [];
   $min = 3;
   $max = 20;
   
  if($_SERVER['REQUEST_METHOD'] == "POST" ){
	if(isset($_POST["submitpass"]))  {	

		$user_id = clean($_POST['user_id']);
		$oldpassword = clean($_POST['oldpassword']);
		 $password = clean($_POST['password']);
		$confirm_password = clean($_POST['confirm_password']);
		$sql = "SELECT password FROM users WHERE id ='$user_id'";
		$result = query($sql);
		$row = $result->fetch_array();
		if($row['password']!== md5($oldpassword)){
			$errors[] = "Incorrect Old Password ..";	
		}
		
	   if($password !== $confirm_password) {
		$errors[] = "Your passwords do not match";
	   }
		if(!empty($errors)) {

		foreach ($errors as $error) {
			

			echo validation_errors($error);
		}
	   } else {
		   
			$dbpassword        = md5($password);
			$sql = "UPDATE users SET password ='".escape($dbpassword)."' WHERE id =".$user_id;
			$result = query($sql);
			confirm($result);
			echo validation_success("Password has been updated successfully ..");
	   }
	}
  }//post request

} //function

function validate_user_editimageprofile($usertype){
  $errors = [];
   $min = 3;
   $max = 20;
   
  if($_SERVER['REQUEST_METHOD'] == "POST"){
	 if(isset($_POST["imgsubmit"]))  {	
		$app_id = clean($_POST['app_id']);
		$user_id = clean($_POST['user_id']);

	    if(isset($_FILES["fileToUpload"]["name"])){
			$target_dir = "profiles/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));	   
			$mgname=htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));   
			   
			 $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			  if($check == false) {
				  $errors[] = "File is not an image.";
			}

			// Check if file already exists
			if (file_exists($target_file)) {
			  $errors[] =  "Sorry, file already exists.";
			}

			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 500000) {
			  $errors[] =  "Sorry, your file is too large.";
			}

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			  $errors[] =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			}  
			
			if(!empty($errors)) {

				foreach ($errors as $error) {			
					echo validation_errors($error);
				}
			} else {
				   if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					if($usertype==1){   
					$sql  ="UPDATE applicant SET image_name='".$mgname."'  where id=".$app_id;
					$result1 = query($sql);
					confirm($result1);  		 
					}
					else{
					$sql  ="UPDATE hr_manager SET image_name='".$mgname."'  where id=".$app_id;
					$result1 = query($sql);
					confirm($result1);					
					}
					echo validation_success("Profile Image has been updated successfully ..");
					echo "<meta http-equiv='refresh' content='0'>";
				  } else {
					validation_errors( "Sorry, there was an error uploading your file.");
				  }
				
				
				
			
				
				
			}
		
	    }	
	}

  }//post request
}

/********************************/
function validate_cv_info($id){
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
		if(isset($_POST["submit"]))  
		{	
			$errors = [];

			$eduinfo =$_POST['eduinfo']; 
			$expinfo=$_POST['expinfo'];
			$contact=$_POST['contact'];
			$email=$_POST['email'];
			$skills=$_POST['skills'];
			$languages=$_POST['languages'];

		   if(empty($eduinfo)){
			$errors[] = "Education info cannot be empty";
		   }
		   if(empty($expinfo)){
			$errors[] = "Experience Info cannot be empty";
		   }
		   if(empty($contact)){
			$errors[] = "contact cannot be empty";
		   }
		   if(empty($email)){
			$errors[] = "email cannot be empty";
		   }
		   if(empty($skills)){
			$errors[] = "skills cannot be empty";
		   }
		   if(empty($languages)){
			$errors[] = "languages cannot be empty";
		   }
		   if(!empty($errors)) {
				foreach ($errors as $error) {
					echo validation_errors($error);
				}
		   } else {
			$sql  ="INSERT INTO cvfile ( educationInfo, experienceInfo, skills, languages, contact, email)";
			$sql .= " VALUES('$eduinfo','$expinfo','$skills','$languages','$contact','$email')";
			
			$result = query($sql);
			confirm($result);
			$sql2 ="SELECT  LAST_INSERT_ID()";
			$result2 = query($sql2);
			confirm($result2);
			$row = $result2->fetch_assoc();
			$lastcvid=$row['LAST_INSERT_ID()'];
			
			if($result ==true){
				    $sql3  ="UPDATE applicant SET cvid='".$lastcvid."'  where id=".$id;
					$result3 = query($sql3);
					confirm($result3);  		 
					
					
					$notification = "The CV has been Added successfully ...";
					echo validation_success($notification);
					
					
			} else 
			{
				echo "Error: " . $sql . $con->error;
			}

		   }
	   }
   }
}
#--------------------------------------------
function validate_cv_update($cvid){
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
		if(isset($_POST["updatesubmit"]))  
		{	
			$errors = [];

			$eduinfo =$_POST['eduinfo']; 
			$expinfo=$_POST['expinfo'];
			$contact=$_POST['contact'];
			$email=$_POST['email'];
			$skills=$_POST['skills'];
			$languages=$_POST['languages'];

		   if(empty($eduinfo)){
			$errors[] = "Education info cannot be empty";
		   }
		   if(empty($expinfo)){
			$errors[] = "Experience Info cannot be empty";
		   }
		   if(empty($contact)){
			$errors[] = "contact cannot be empty";
		   }
		   if(empty($email)){
			$errors[] = "email cannot be empty";
		   }
		   if(empty($skills)){
			$errors[] = "skills cannot be empty";
		   }
		   if(empty($languages)){
			$errors[] = "languages cannot be empty";
		   }
		   if(!empty($errors)) {
				foreach ($errors as $error) {
					echo validation_errors($error);
				}
		   } else {
			$sql  ="UPDATE cvfile SET educationInfo='".$eduinfo."', experienceInfo='".$expinfo."' ,skills='".$skills."' ,languages='".$languages."' ,contact='".$contact."' ,email='".$email."'  where id=".$cvid;
			$result = query($sql);
			confirm($result);  
			   
			if($result ==true){			
					$notification = "The CV has been UPDATED successfully ...";
					echo validation_success($notification);
					
					
			} else 
			{
				echo "Error: " . $sql . $con->error;
			}

		   }
	   }
   }	
}

?>

