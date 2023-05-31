<?php
    include 'connection.php';

    $search = isset($_GET['search']) ? $_GET['search'] : '';

    if(!empty($search)){
    $query1 = 'SELECT  event_attendance.studentid, student_info.firstname, student_info.lastname, SUM(event_attendance.timein_no) as totaltimedin, SUM(event_attendance.timeout_no) as totaltimedout, SUM(event_attendance.event_total_absents) as totalabsents
        FROM event_attendance
        JOIN student_info ON event_attendance.studentid = student_info.id
        WHERE id LIKE "%'.$search.'%" OR firstname LIKE "%'.$search.'%" OR lastname LIKE "%'.$search.'%"
        GROUP BY event_attendance.studentid, student_info.firstname, student_info.lastname
        ORDER BY lastname';
    } else {
        $query1 = "SELECT  event_attendance.studentid, student_info.firstname, student_info.lastname, SUM(event_attendance.timein_no) as totaltimedin, SUM(event_attendance.timeout_no) as totaltimedout, SUM(event_attendance.event_total_absents) as totalabsents
            FROM event_attendance
            JOIN student_info ON event_attendance.studentid = student_info.id
            GROUP BY event_attendance.studentid, student_info.firstname, student_info.lastname";
    }
    
    $result1 = mysqli_query($conn, $query1);
    $records1 = array();
    if(mysqli_num_rows($result1) > 0){
        while($row1 = mysqli_fetch_assoc($result1)){
            $records1[] = $row1;
        }
    }


    mysqli_free_result($result1);

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
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="GET" class="form">
                <input type="text" name="search" class="search" required />
                <input type="submit" value="Search" style="background-color: grey; padding: 8px; border-radius: 10px; color: white; border: none;">
            </form>
        </ul>
    </nav>
        <div class="container">
            <table class="table" border="1">
                <center><h4>OVERALL STUDENT ATTENDANCE</h4></center>
                    <thead>
                        <th>Student Id</th>
                        <th>Name</th>
                        <th>Total Time-in:</th>
                        <th>Total Time-out:</th>
                        <th>Total Absents:</th>
                        
                    </thead>
                    <tbody>
                        <?php foreach($records1 as $record) : ?>
                        <tr>
                            <td><?php echo $record['studentid']; ?></td>
                            <td><?php echo $record['lastname'] . ", " . $record['firstname']; ?></td>
                            <td><?php echo $record['totaltimedin']; ?></td>
                            <td><?php echo $record['totaltimedout']; ?></td>
                            <td><?php echo $record['totalabsents']; ?></td>
                            
                        </tr>
                        <?php endforeach ?>     
                    </tbody>
            </table>
        </div>
    </body>
</html>
