<?php
include("includes/header.php");
include("includes/navbar.php");
?>

<div style="margin: 5%">
<form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="border: 2px dotted blue; text-align:center; width: 400px;" id="formcooki">
	<p>
		Username: <input name="username" type="text" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>" class="input-field">
	</p>
		 <p>Password: <input name="password" type="password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>" class="input-field">
	</p>
		<p><input type="checkbox" name="remember" /> Remember me
	</p>
		<p><input type="submit" value="Login"></span></p>


		<!-- data-rel="back" //Form gönderilince geri getirir.Şu şekilde
		<a id="submit-edit-customer-btn" data-role="button" data-inline="true" data-rel="back" data-theme="a">Save</a>
 -->
	</form>
	if(!empty($_POST["remember"])) {
	@setcookie ("username",$_POST["username"],time()+ 3600);
	@setcookie ("password",$_POST["password"],time()+ 3600);
	echo "Cookies Set Successfuly";
} else {
	@setcookie("username","");
	@setcookie("password","");
	echo "Cookies Not Set";
}

?>

<!-- <p><a href="rememberme.php?id=#formcooki"> Go to Login Page </a> </p> -->
<p><a href="<?php echo $_SERVER['PHP_SELF']; ?>?id=#formcooki"> Go to Login Page </a> </p>
</div>

<?php
include("includes/scripts.php");
include("includes/footer.php");
?>
<!-- <?php
/**
* Website: www.TutorialsClass.com
**/
/* 
if(!empty($_POST["remember"])) {
	@setcookie ("username",$_POST["username"],time()+ 3600);
	@setcookie ("password",$_POST["password"],time()+ 3600);
	echo "Cookies Set Successfuly";
} else {
	@setcookie("username","");
	@setcookie("password","");
	echo "Cookies Not Set";
} */

?>

<p><a href="rememberme.php?id=#formcooki"> Go to Login Page </a> </p>
 -->

