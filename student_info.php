<?php
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "attendance_db";

    global $idnum;
    $conn = new mysqli($servername, $username, $password, $dbname);  

    $search = isset($_GET['search']) ? $_GET['search']: null;

    $results_per_page = 10;

    $query = "SELECT id, name, course, year, block from attendance, student_info";
    $result = mysqli_query($conn, $query);
    $number_of_result = mysqli_num_rows($result);

    $number_of_page = ceil($number_of_result / $results_per_page);

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


    $result = mysqli_query($conn, $query);
    $records = array();
    if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $records[] = $row;
                }
            }

    mysqli_free_result($result);

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
            <button type="submit" class="add_student">
            <a href="addstudent.php"> Add New Student</a></button>
            <div class="time">
                <button type="submit" class="time_in">
                <a href="timein.php"> Time-in</a></button>
            
                <button type="submit" class="time_out">
                <a href="timeout.php">Time-out</a></button>
            </div>
            <table class="table" border="1">
                <h4 class="label">Students List</h4>
                    <thead>
                        <th>Student Id</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Block</th>
                        <th> </th>
                        
                    </thead>
                    <tbody>
                        <?php foreach($records as $record) : ?>
                        <tr>
                            <td><?php echo $record['id']; ?></td>
                            <td><?php echo $record['name']; ?></td>
                            <td><?php echo $record['course']; ?></td>
                            <td><?php echo $record['year']; ?></td>
                            <td><?php echo $record['block']; ?></td>
                            <?php echo '<td> <button type="submit" class="add_student"><a href="editstudent.php?id=' . $record['id'] . '">Edit Student Information</a></button></td>'; ?>
                            
                        </tr>
                        <?php endforeach ?>     
                    </tbody>
            </table>
        </div>
    </body>
</html>