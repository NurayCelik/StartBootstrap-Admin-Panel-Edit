
<?php 
include '../datalib/Session.php';

if(Session::get('adminName')==false){
	
	header("Location:admin");

} else {

	//header("Location:production/login.php");

}

?>
