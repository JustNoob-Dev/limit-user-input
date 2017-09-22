<!doctype html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="Justin Marc T. Almario justin86marc@yahoo.com">
    <title>Login</title>
</head>

<body>

    <center>
        <p><a href="register.php">Register</a> | <a href="login.php">Login</a></p>
        <h3>Login Form</h3>
        <form action="" method="POST">
            Username: <input type="text" name="user" required><br /> Password: <input type="password" name="pass" required><br />
            <input type="submit" value="Login" name="submit" />
        </form>
    </center>
    
<?php
     
if(isset($_POST["submit"])){

if(!empty($_POST['user']) && !empty($_POST['pass'])) {
    session_start();
    include 'db.php';
	$user=$conn->escape_string($_POST['user']);
	$pass=$conn->escape_string($_POST['pass']);
	
    
    $pass= md5($pass);
	$query=mysqli_query($conn,"SELECT * FROM login WHERE username='".$user."' AND password='".$pass."'");
	$numrows=mysqli_num_rows($query);
	if($numrows!=0)
	{
	while($row=mysqli_fetch_assoc($query))
	{
	$dbusername=$row['username'];
	$dbpassword=$row['password'];
	}

	if($user == $dbusername && $pass == $dbpassword)
	{
	session_start();
	$_SESSION['sess_user']=$user;

	/* Redirect browser */
	header("Location: member.php");
	}
	} else {
	echo "Invalid username or password!";
	}

} else {
	echo "All fields are required!";
}
}
?>

</body>
<center>
    <div id="footer">
        Copyright &copy; 2017<br/> All Rights Reserved.<br/>
        <!--Powered By <a href="mailto:justin86marc@yahoo.com">Justin Marc T. Almario</a>-->
    </div>
</center>

</html>