
<?php

include_once 'header.php';
?>
<?php 
include("functions/init.php");
?>
<body>
<section class="login-banner">
<h2>Login</h2>
</section>

<section class="login-portal">
<div class="container">
<div class="row">
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 col-lg-push-4 col-md-push-4 col-sm-push-4 col-xs-push-3 login-inner">
<?php

if(isset($_SESSION['msg']))
{
if($_SESSION['msg']==1)
echo "please login";
else
echo $_SESSION['msg'];
session_unset($_SESSION['msg']);
}
?>
<?php display_message(); ?>
<?php validate_user_login(); ?>
<form  method="post">
<div class="form-group">
<label class="control-label" for="username">Username: </label><input type="text" name="username" class="form-control" required />
</div>
<div class="form-group">
<label class="control-label" for="password">Password: </label><input type="password" name="password" class="form-control"/>
</div>
<div class="form-group text-center" style="color:gray;">
	<input type="checkbox" tabindex="3" class="" name="remember" id="remember">
	<label for="remember"> Remember Me</label>
</div>
<div class="row">
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-lg-push-4 col-sm-push-4 col-md-push-4 col-xs-push-4 form-group">
<br /><input type="submit" value="login" class="form-control"/>
</div>
</div>

<div class="form-group">
	<div class="row">
		<div class="col-lg-12">
			<div class="text-center">
				<a href="recover.php" tabindex="5" class="forgot-password">Forgot Password?</a>
			</div>
		</div>
	</div>
</div>
</form>

</div>
</div>
</div>
</section>
<?php
include_once 'footer.php';
?>
</body>
</html>
