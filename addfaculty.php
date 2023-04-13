<?php
  // Include the QRcode library
  include 'phpqrcode/qrlib.php';
  
  $servername = "localhost";
  $username = "root";
  $password = "admin";
  $dbname = "attendance_db";
  $conn = new mysqli($servername, $username, $password, $dbname);


  if(isset($_POST['submit'])){
    //  Get form data
        $name = mysqli_real_escape_string($conn,$_POST['name']);
        $college = mysqli_real_escape_string($conn,$_POST['college']);
        $org = mysqli_real_escape_string($conn,$_POST['org']);

    //create insert query
        $query ="INSERT INTO faculty(name, college, organization)
        VALUES ('$name', '$college', '$org')";
    
    //Execute query
        if(mysqli_query($conn, $query)){
            header("Location: index.php");
        }else{
            echo 'ERROR: '. mysqli_error($conn);
        }
  }
  $conn->close();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>QR Attendance System</title>
    <link rel="stylesheet" href="style.css" />    
  </head>
  <body style="font-family: sans-serif;">
        <nav>
                <ul class="navbar-nav">
                    <li> 
                        <a href="index.php"> Student Attendance List</a>
                    </li>
                    <li>
                        <a href="student_info.php" class="active"> Student List</a>
                    </li>
                    <li>
                        <a href="attendance_check.php">Attendance Checklist</a>
                    </li>
                    <li>
                        <a href="faculty.php">Faculty Adviser</a>
                    </li>
                    <form action="index.php" method="GET" class="form">
                        <input type="text" name="search" class="search" placeholder="Enter Student's Name" required />
                        <input type="submit" value="Search" class="searchbtn" />
                    </form>
                </ul>
            </nav>
        <div class="container">
            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" class="addform">
      <b> Enter Faculty Name: <br></b>
      <input type ="text" name="name"> <br><br>
      <b>College:<br></b>
      <select id = "college" name = "college">
        <option value="none" selected disabled hidden>Select College:</option>
        <option id="cs" value="CS">CS</option>
        <option id="cah" value="CAH"> CAH </option>
        <option id="cnhs" value="CNHS"> CNHS </option>
        <option id="chtm" value="CHTM"> CHTM </option>
        <option id="ccje" value="CCJE"> CCJE </option>
        <option id="cba" value="CBA"> CBA </option>
        <option id="ceat" value="CEAT"> CEAT </option>
        <option id="cte" value="CTE"> CTE </option><br><br>
      </select><br><br>
      <b>Organization:<br></b>
      <select id = "org" name = "org">
        <option value="none" selected disabled hidden>Select Organization:</option>
        <option id="site" value="SITE">SITE</option>
        <option id="acs" value="ACS"> ACS </option>
        <option id="yba" value="YBA"> YBA </option>
        <option id="essa" value="ESSA"> ESSA </option><br><br>
      </select><br><br>
      
        <a href="faculty.php"> <button name = "submit" id="submits" value="Submit" class="submit">Submit</button></a>
        </form>
</div>
  </body>
</html>