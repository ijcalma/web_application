<?php
  // Include the QRcode library
  include 'phpqrcode/qrlib.php';
  
  $servername = "localhost";
  $username = "root";
  $password = "admin";
  $dbname = "attendance_db";

  global $idnum;
  $conn = new mysqli($servername, $username, $password, $dbname);


  if(isset($_POST['submit'])){
    //  Get form data
        $idnum = mysqli_real_escape_string($conn,$_POST['idnum']);
        $name = mysqli_real_escape_string($conn,$_POST['name']);
        $course = mysqli_real_escape_string($conn,$_POST['course']);
        $year = mysqli_real_escape_string($conn,$_POST['year']);
        $block = mysqli_real_escape_string($conn,$_POST['block']);
        $date = date('Y-m-d H:i:s');

    //create insert query
        $query ="INSERT INTO student_info(id, name, course, year, block, datetime)
        VALUES ('$idnum', '$name', '$course', '$year', '$block', '$date')";
        $query2 = "INSERT INTO attendance (student_id) VALUES ('$idnum')";
        $query3 = "INSERT INTO checklist (studentid) VALUES ('$idnum')";
    
    //Execute query
        if(mysqli_query($conn, $query) && mysqli_query($conn, $query2) && mysqli_query($conn, $query3)){
            header("Location: index.php");
        }else{
            echo 'ERROR: '. mysqli_error($conn);
        }
  }
        $tempDir = "QRCODES";

        // Generate a unique file name for the QR code image
        $fileName = $idnum. '.png';

        // Generate the full path to the QR code image
        $filePath = $tempDir . "/" . $fileName;

        // Generate the QR code image using the code and the file path
        QRcode::png($idnum, $filePath);
 

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
      <b> Enter Student ID Number: <br></b>
      <input type ="text" name="idnum"> <br><br>
      <b> Enter student name: <br></b>
      <input type ="text" name="name"> <br><br>
      <b>Course:<br></b>
      <select id = "course" name = "course">
        <option value="none" selected disabled hidden>Select Course:</option>
        <option id="bsit" value="BSIT">BSIT</option>
        <option id="bscs" value="BSCS"> BSCS </option>
        <option id="bsmedbio" value="BSMedBio"> BSMedBio </option>
        <option id="bsessa" value="BSES"> BSES </option>
        <option id="bsmarbio" value="BSMarBio"> BSMarBio </option><br><br>
      </select><br><br>
      <b>Year:<br></b>
      <select id = "year" name = "year">
        <option value="none" selected disabled hidden>Select Year Level:</option>
        <option id="1" value="First Year">First Year</option>
        <option id="2" value="Second Year"> Second Year </option>
        <option id="3" value="Third Year"> Third Year </option>
        <option id="4" value="Fourth Year"> Fourth Year </option><br><br>
      </select><br><br>
      <b>Block:<br></b>
      <select id = "block" name = "block">
        <option value="none" selected disabled hidden>Select Block:</option>
        <option id="b1" value="Block 1">Block 1</option>
        <option id="b2" value="Block 2">Block 2</option>
        <option id="b3" value="Block 3">Block 3</option>
        <option id="b4" value="Block 4">Block 4</option>
        <option id="b5" value="Block 5">Block 5</option><br><br>
      </select><br><br>
        <a href="index.php"> <button name = "submit" id="submits" value="Submit" class="submit">Submit</button></a>
        </form>

  </body>
</html>