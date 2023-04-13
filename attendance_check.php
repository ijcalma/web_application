<?php
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "attendance_db";

    global $idnum;
    $conn = new mysqli($servername, $username, $password, $dbname);  

    $search = isset($_GET['search']) ? $_GET['search']: null;

    $results_per_page = 10;

    $query = "SELECT studentid, name, course, timedin, timedout, absent from attendance, checklist, student_info";
    $result = mysqli_query($conn, $query);
    $number_of_result = mysqli_num_rows($result);

    $number_of_page = ceil($number_of_result / $results_per_page);

    if(!empty($search)){
    $query = 'SELECT s.id, s.name, c.timedin, c.timedout, c.absent
        FROM attendance a
        INNER JOIN student_info s ON a.student_id = s.id
        INNER JOIN checklist c ON c.studentid = s.id
        WHERE s.name LIKE "%'.$search.'%" OR s.id LIKE "%'.$search.'%" OR s.course LIKE "%'.$search.'%" OR s.year LIKE "%'.$search.'%" OR s.block LIKE "%'.$search.'%"
        ORDER BY s.name';
	} else {
    $query = 'SELECT s.id, s.name, c.timedin, c.timedout, c.absent
        FROM attendance a
        INNER JOIN student_info s ON a.student_id = s.id
        INNER JOIN checklist c ON c.studentid = s.id';
	}
	$sum = 'timedin + timedout';
	$absent = "UPDATE checklist SET absent = $sum-4";
	mysqli_query($conn, $absent);

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
                        <a href="student_info.php"> Student List</a>
                    </li>
                    <li>
                        <a href="attendance_check.php" class="active">Attendance Checklist</a>
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
                        <th>Time-in Number:</th>
                        <th>Time-out Number:</th>
                        <th>Absents:</th>
                        
                    </thead>
                    <tbody>
                        <?php foreach($records as $record) : ?>
                        <tr>
                            <td><?php echo $record['id']; ?></td>
                            <td><?php echo $record['name']; ?></td>
                            <td><?php echo $record['timedin']; ?></td>
                            <td><?php echo $record['timedout']; ?></td>
                            <td><?php echo $record['absent']; ?></td>
                            
                        </tr>
                        <?php endforeach ?>     
                    </tbody>
            </table>
        </div>
    </body>
</html>