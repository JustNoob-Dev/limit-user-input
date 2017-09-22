<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type"
       content="text/html; charset=utf-8"/>
    <meta name="author" content="Justin Marc T. Almario justin86marc@yahoo.com">
<title>Register</title>
<script src="Allowkeys.js"></script>
</head>
<body>

<center>    
<p><a href="register.php">Register</a> | <a href="login.php">Login</a></p>
<h3>Registration Form</h3>    
<form action="" method="POST">
Username: <input type="text" name="user" onkeypress="return only(event,num+alpha)" required><br />
Password: <input type="password" name="pass" onkeypress="return only(event,num+alpha)" required><br />	
Retype Password:<input type="password" name="repass" onkeypress="return only(event,num+alpha)" required><br />
<input type="submit" value="Register" name="submit" />
</form>
</center>
    
<?php
   
if(isset($_POST["submit"])){
include 'db.php';
if(!empty($_POST['user']) && !empty($_POST['pass'])) {
    session_start();
	$user=$conn->escape_string($_POST['user']);
	$pass=$conn->escape_string($_POST['pass']);
    $repass=$conn->escape_string($_POST['repass']);
    
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(strlen($pass) < 16 ){
if(strlen($user) < 16 ){
if ($pass==$repass){
    $pass= md5($pass);
	$query=mysqli_query($conn,"SELECT * FROM login WHERE username='".$user."' AND password='".$pass."'");
	$numrows=mysqli_num_rows($query);
	if($numrows==0)
	{
	$sql="INSERT INTO login(username,password) VALUES('$user','$pass')";
	$result = $conn->query($sql);
	if($result){
	echo "Account Successfully Created";
	} else {
	echo "That username already exists! Please try again with another!";
	}
	} else {
	echo "Already Exists! Please try again";
	}
}else 
    echo"Password does not match!!!";
    }
    else
        echo "Username must not exceed 16 characters";
}   else
        echo "Password must not exceed 16 characters";

} else {
	echo "All fields are required!";
}
}
?>
</body>
    <center>
    <div id="footer">
        Copyright &copy; 2017<br/>
        All Rights Reserved.<br/>
        <!--Powered By <a href="mailto:justin86marc@yahoo.com">Justin Marc T. Almario</a>-->
    </div>
    </center>
</html>