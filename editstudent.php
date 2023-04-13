<?php
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "attendance_db";

    global $idnum;
    $conn = new mysqli($servername, $username, $password, $dbname);  

    $search = isset($_GET['search']) ? $_GET['search']: null;

    $results_per_page = 10;

    if(isset($_POST['submit'])){
    //  Get form data
        $idnum = mysqli_real_escape_string($conn,$_POST['idnum']);
        $name = mysqli_real_escape_string($conn,$_POST['name']);
        $course = mysqli_real_escape_string($conn,$_POST['course']);
        $year = mysqli_real_escape_string($conn,$_POST['year']);
        $block = mysqli_real_escape_string($conn,$_POST['block']);
        $date = date('Y-m-d H:i:s');

        $query = "UPDATE student_info SET name='$name', course='$course', year='$year', block='$block' WHERE id='$idnum'";
        if(mysqli_query($conn, $query)){
            header("Location: student_info.php");
        } else{
            echo "Error updating record: " . mysqli_error($conn);
        }
    }


    if(!empty($search)){
        $query = 'SELECT id, name, course, year, block 
                  FROM attendance
                  INNER JOIN student_info ON attendance.student_id = student_info.id
                  WHERE student_info.name LIKE "%'.$search.'%" OR student_info.id LIKE "%'.$search.'%" OR student_info.course LIKE "%'.$search.'%" OR student_info.year LIKE "%'.$search.'%" OR student_info.block LIKE "%'.$search.'%" ORDER BY name';

    }else{
        $query = 'SELECT id, name, course, year, block
                  FROM attendance
                  INNER JOIN student_info ON attendance.student_id = student_info.id';
    }

    $row=array();
    $query = mysqli_query($conn, "SELECT * FROM student_info WHERE id='" . $_GET['id'] . "'");
    $row= mysqli_fetch_array($query);

    mysqli_close($conn);

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
      <input type ="text" name="idnum" value="<?php echo $row['id']; ?>"> <br><br>
      <b> Enter student name: <br></b>
      <input type ="text" name="name" value="<?php echo $row['name']; ?>"> <br><br>
      <b>Course:<br></b>
      <select id = "course" name = "course">
        <option value="none" selected disabled hidden>Select Course:</option>
        <option id="bsit" value="BSIT" <?php if ($row['course'] == 'BSIT') echo ' selected="selected"'; ?>>BSIT</option>
        <option id="bscs" value="BSCS"  <?php if ($row['course'] == 'BSCS') echo ' selected="selected"'; ?>> BSCS </option>
        <option id="bsmedbio" value="BSMedBio"  <?php if ($row['course'] == 'BSMedBio') echo ' selected="selected"'; ?>> BSMedBio </option>
        <option id="bsessa" value="BSES"  <?php if ($row['course'] == 'BSES') echo ' selected="selected"'; ?>> BSES </option>
        <option id="bsmarbio" value="BSMarBio"  <?php if ($row['course'] == 'BSMarBio') echo ' selected="selected"'; ?>> BSMarBio </option><br><br>
      </select><br><br>
      <b>Year:<br></b>
      <select id = "year" name = "year">
        <option value="none" selected disabled hidden>Select Year Level:</option>
        <option id="1" value="First Year" <?php if ($row['year'] == 'First Year') echo ' selected="selected"'; ?>>First Year</option>
        <option id="2" value="Second Year" <?php if ($row['year'] == 'Second Year') echo ' selected="selected"'; ?>> Second Year </option>
        <option id="3" value="Third Year" <?php if ($row['year'] == 'Third Year') echo ' selected="selected"'; ?>> Third Year </option>
        <option id="4" value="Fourth Year" <?php if ($row['year'] == 'Fourth Year') echo ' selected="selected"'; ?>> Fourth Year </option><br><br>
      </select><br><br>
      <b>Block:<br></b>
      <select id = "block" name = "block">
        <option value="none" selected disabled hidden>Select Block:</option>
        <option id="b1" value="Block 1" <?php if ($row['block'] == 'Block 1') echo ' selected="selected"'; ?>>Block 1</option>
        <option id="b2" value="Block 2" <?php if ($row['block'] == 'Block 2') echo ' selected="selected"'; ?>>Block 2</option>
        <option id="b3" value="Block 3" <?php if ($row['block'] == 'Block 3') echo ' selected="selected"'; ?>>Block 3</option>
        <option id="b4" value="Block 4" <?php if ($row['block'] == 'Block 4') echo ' selected="selected"'; ?>>Block 4</option>
        <option id="b5" value="Block 5" <?php if ($row['block'] == 'Block 5') echo ' selected="selected"'; ?>>Block 5</option><br><br>
      </select><br><br>
        <a href="index.php"> <button name = "submit" id="submits" value="Submit" class="submit">Submit</button></a>
        </form>
        </div>
         

  </body>
</html>
