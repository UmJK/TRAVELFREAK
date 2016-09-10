<?php
	include("../includes/database_connection.php");
	include("../includes/session.php");
	include("../includes/functions.php");
?>
<?php
	if(logged_in()){
		header("Location: home.php");
	}
?>
<?php
	global $error;
	if(isset($_POST['submit'])){
		$password = mysqli_real_escape_string($connection,(mysql_entities_fix_string($_POST['password'])));
	    $username = mysqli_real_escape_string($connection,(mysql_entities_fix_string($_POST['username'])));
	    $hash_password = password_hashing($password);
	    $found_user=attempt_login($username,$hash_password,$connection);
	    if($found_user)
	    {
	        $user_id=find_user_by_id($username,$connection);
	        $name=find_user_by_name($username,$connection);
	        $_SESSION['current_user_id']=$user_id;
	        $_SESSION['current_name']=$name;
	        $_SESSION['current_username']=$username;
	        redirect_to("home.php");
	    }
	    else
	    {
	        $error="Incorrect user details";
	        destroySession();
	    }
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<form action="login.php" method="post">
		<input type="text" name="username" value=""></input>
		<input type="password" name="password" value=""></input>
		<input type="submit" name="submit" value="Submit"></input>
	</form>
</body>
</html>