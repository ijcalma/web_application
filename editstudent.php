<?php
    include 'connection.php';

    if(isset($_POST['submit'])){
    //  Get form data
        $idnum = mysqli_real_escape_string($conn, $_GET['id']);
        $firstname = mysqli_real_escape_string($conn,$_POST['firstname']);
        $lastname = mysqli_real_escape_string($conn,$_POST['lastname']);
        $middlename = mysqli_real_escape_string($conn,$_POST['middlename']);
        $extname = mysqli_real_escape_string($conn,$_POST['extname']);
        $course = mysqli_real_escape_string($conn,$_POST['course']);
        $year = mysqli_real_escape_string($conn,$_POST['year']);
        $block = mysqli_real_escape_string($conn,$_POST['block']);
        $date = date('Y-m-d H:i:s');

        $query1 = "UPDATE student_info SET id ='$idnum', firstname='$firstname', lastname='$lastname', middlename='$middlename', extname='$extname', course='$course', year='$year', block='$block' WHERE id='$idnum'";
        if(mysqli_query($conn, $query1)){
            header("Location: student_info.php");
            exit();
        } else{
            echo "Error updating record: " . mysqli_error($conn);
        }
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
        <?php include 'navbar.php'; ?>
    </nav>
        <div class="container">
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" class="addform">
      <b> Enter Student ID Number: <br></b>
      <input type ="text" name="idnum" value="<?php echo $row['id']; ?>"> <br><br>
      <b> Enter student First name: <br></b>
      <input type ="text" name="firstname" value="<?php echo $row['firstname']; ?>"> <br><br>
      <b> Enter student Last name: <br></b>
      <input type ="text" name="lastname" value="<?php echo $row['lastname']; ?>"> <br><br>
      <b> Enter student middle name: <br></b>
      <input type ="text" name="middlename" value="<?php echo $row['middlename']; ?>"> <br><br>
      <b> Enter student extension name: <br></b>
      <input type ="text" name="extname" value="<?php echo $row['extname']; ?>"> <br><br>
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
        <button name = "submit" id="submits" value="submit" class="submit">Submit</button></a>
        </form>
        </div>
         

  </body>
</html>
