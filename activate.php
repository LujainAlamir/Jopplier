
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

	<div class="jumbotron">
		<h1 class="text-center">Activate <?php activate_user(); ?> </h1>
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
