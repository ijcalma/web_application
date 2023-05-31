<?php
    include 'connection.php';

    $result_per_page = 10;

    $query_01 = "SELECT * FROM student_info";

    $result_01 = mysqli_query($conn, $query_01);

    $resultRows = mysqli_num_rows($result_01);

    $number_of_page = ceil($resultRows / $result_per_page);

    if(!isset($_GET['page'])){
        $page = 1;
    }else{
        $page = $_GET['page'];

    }
    $first_page_number = ($page - 1) * $result_per_page;

    $query = "SELECT  event_attendance.studentid, student_info.firstname, student_info.lastname, SUM(event_attendance.timein_no) as totaltimedin, SUM(event_attendance.timeout_no) as totaltimedout, SUM(event_attendance.event_total_absents) as totalabsents
            FROM event_attendance
            JOIN student_info ON event_attendance.studentid = student_info.id
            GROUP BY event_attendance.studentid, student_info.firstname, student_info.lastname ORDER BY lastname ASC LIMIT $first_page_number, $result_per_page";

    $search = isset($_GET['search']) ? $_GET['search'] : '';

    if(!empty($search)){
    $query1 = 'SELECT  event_attendance.studentid, student_info.firstname, student_info.lastname, SUM(event_attendance.timein_no) as totaltimedin, SUM(event_attendance.timeout_no) as totaltimedout, SUM(event_attendance.event_total_absents) as totalabsents
        FROM event_attendance
        JOIN student_info ON event_attendance.studentid = student_info.id
        WHERE id LIKE "%'.$search.'%" OR firstname LIKE "%'.$search.'%" OR lastname LIKE "%'.$search.'%"
        GROUP BY event_attendance.studentid, student_info.firstname, student_info.lastname
        ORDER BY lastname';
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
                        <?php foreach($records as $record) : ?>
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
            <?php 
                for ($page = 1; $page <= $number_of_page; $page++) {
                  echo '<a href="report.php?page=' . $page . '" style="margin-right: 5px; padding: 5px; color: black;">' . $page . '</a>';
                }
              ?>
        </div>
    </body>
</html>
