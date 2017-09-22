<?php 
session_start();
include 'db.php';
if(!isset($_SESSION["sess_user"])){
header("location:login.php");
} else {
?>
<!doctype html>
<html>
<head>
<title>Welcome</title>

<style>
  .img {
  width: 200px;
  height: 200px;
  overflow: auto;
  border-radius: 50%;
  position: absolute;
  top: 25px;
  right: 250px;

}
    table {
    width: 100%;
}
td:hover {
    background-color: #f5f5f5;
    }
th {
    height: 50px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
    padding: 8px;
}
    td{
    height: 50px;
    text-align: left;
    background-color: #bde2bf;
    padding: 8px;  
    }
</style>
<script src="Allowkeys.js"></script>
</head>
<center>  
<body>

<h2>Welcome, <?=$_SESSION['sess_user'];?>!    

    <form name="registration" action="member.php" enctype="multipart/form-data" method="post">
        <input type="file" name="file" required /><br>
        
		<input type="text" id="fname" maxlength="16" name="fname" placeholder="Name" required onkeypress="return only(event,alpha)" />	
        
		<input type="text" id="fatname" maxlength="32" name="fatname" placeholder="Father's Name" onkeypress="return only(event,alpha)" required /><br>
        
		<input type="text" id="mname" maxlength="16" name="mname" placeholder="Middle Name" onkeypress="return only(event,alpha)" required /> 
		<input type="text" id="motname" maxlength="32" name="motname" placeholder="Mother's Name" onkeypress="return only(event,alpha)" required /><br>

		<input type="text" id="sname" maxlength="16" name="sname" placeholder="Surname" onkeypress="return only(event,alpha)" required /> 
		<input type="number" id="bday" name="bday" placeholder="Birthday" onkeypress="return only(event,num)" required /><br>

		<input type="number" id="studentno" name="studentno" placeholder="Student No." onkeypress="return only(event,num)" required /> 
		<input type="email" id="email" name="email" maxlength="16" placeholder="Email" onkeypress="return only(event,num+alpha+signs)" required /><br>

		<input type="text" id="course" name="course" maxlength="10" placeholder="Course &amp; Section" onkeypress="return only(event,num+alpha)" required /> 
		
		<input type="text" id="contact" name="contact" onkeypress="return only(event,num)" pattern="[0-9]{11}" placeholder="Contact No." required/><br>
		<input type="submit" name="submit">
	</form>
    <a href="logout.php">Logout</a></h2>
   
    </body></center>
<?php       
           
    
              if (isset($_POST['submit'])){
                  //pag submit define agad
                $fname = $conn->real_escape_string($_POST['fname']);
                $fatname = $conn->real_escape_string($_POST['fatname']);
                $mname = $conn->real_escape_string($_POST['mname']);
                $sname = $conn->real_escape_string($_POST['sname']);
                $studentno = $conn->real_escape_string($_POST['studentno']);
                $motname = $conn->real_escape_string($_POST['motname']);
                $bday = $conn->real_escape_string($_POST['bday']);
                $email = $conn->real_escape_string($_POST['email']);
                $course = $conn->real_escape_string($_POST['course']);
                $contact = $conn->real_escape_string($_POST['contact']);           
            // if you want to show this yung echo sa baba remove the max length on the form sa taaas
                  //check kung ano nilagay 
              if(strlen($fname) > 16) {
                echo "Name must not exceed 32 characters";
              }
              elseif ((strlen($mname) > 16)) {
              	echo "Middle must not exceed 16 characters";
              }
              elseif ((strlen($sname) > 16)) {
              	echo "Surname must not exceed 16 characters";
              }
              elseif ((strlen($studentno) > 16)) {
              	echo "Student No. must not exceed 16 characters";
              }
              elseif ((strlen($course) > 10)) {
              	echo "Course and Section must not exceed 10 characters";
              }
              elseif ((strlen($fatname) > 32)) {
              	echo "Father Name must not exceed 32 characters";
              }
              elseif ((strlen($motname) > 32)) {
              	echo "Mother Name must not exceed 32 characters";
              }
              elseif ((strlen($bday) > 10)) {
              	echo "Birthday must not exceed 10 characters";
              }
              elseif ((strlen($email) > 32)) {
              	echo "email must not exceed 32 character";
              }
            elseif (!isset($_FILES['file']['tmp_name'])){
                    echo "no image found";//condition that will check if the picture files are not empty. Note that $_FILES will be use for input type file format.
              }
              else{
                // define daw kaya nag lagay ako nyan d ko alam basta hahaha
                $file_name = $_FILES['file']['name'];
			    $file_tmp = $_FILES['file']['tmp_name']; 
                //i use a fuction called addslashes to prevent sql injection and inside it another function called file_get_contents to get the picture.
                $image_name= addslashes($_FILES['file']['name']);
	            move_uploaded_file($_FILES["file"]["tmp_name"],"images/" .  $_FILES["file"]["name"]);	
                $mypic="images/".$_FILES['file']['name'];
                  //insert query pota baka makalimuta mo kung ano to
                    $sql ="INSERT INTO `info`(`fname`, `fatname`, `mname`, `motname`, `surname`, `bday`, `studentno`, `email`, `course`, `contact`,`mypic`) VALUES ('$fname', '$fatname', '$mname', '$motname', '$sname', '$bday', '$studentno', '$email', '$course', '$contact','$mypic')";
                    
                    if(mysqli_query($conn, $sql)) {
                        
                    
 echo '
<script language="javascript">
    ';
    echo 'alert("New record created successfully:")';
    echo '
</script>';            
             ?>
             <div class="img">
                        <?php
                        // query sa baba para ma select yung pinakabagong lagay sa db para sa pic lng nmn yan
                        $picsql=mysqli_query($conn,"SELECT * FROM `info` ORDER BY `info`.`IID` DESC LIMIT 1");
                        // fetch yung data sa db
						while ($row = mysqli_fetch_assoc($picsql)) {
                         
                            // pinalabas mo yung image sa database dapat tama path mo dit hoy
                            echo "<img width=100% src='".$row['mypic']."' />";
                            
                             }  ?> </div> 
    <?php               
        echo "
<table>"; echo "
    <tr>
        <th>Name</th>
        <th>Middle</th>
        <th>Surname</th>
        <th>Student No.</th>
        <th>Course&Sec</th>
        <th>Father Name</th>
        <th>Mother Name</th>
        <th>Brithday</th>
        <th>Email</th>
        <th>Contact no.</th>
    </tr>
    </br>"; echo "
    <tr>
        <td>"; echo $fname; echo "</td>
        <td>"; echo $mname; echo "</td>
        <td>"; echo $sname; echo "</td>
        <td>"; echo $studentno; echo "</td>
        <td>"; echo $course; echo "</td>
        <td>"; echo $fatname; echo "</td>
        <td>"; echo $motname; echo "</td>
        <td>"; echo $bday; echo "</td>
        <td>"; echo $email; echo "</td>
        <td>"; echo $contact; echo "</td>
    </tr>"; echo "</table>";
                        
}                   else { 
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}      
              }
          }
       }
?>
                     
</html>