<?php
    include 'connection.php';
    $event_id = isset($_GET['event_id']) ? $_GET['event_id'] : '';
    $result_per_page = 10;

    $query_01 = "SELECT * FROM event_attendance where eventid = '$event_id'";

    $result_01 = mysqli_query($conn, $query_01);

    $resultRows = mysqli_num_rows($result_01);


    $number_of_page = ceil($resultRows / $result_per_page);

    if(!isset($_GET['page'])){
        $page = 1;
    }else{
        $page = $_GET['page'];

    }
    $first_page_number = ($page - 1) * $result_per_page;
     //create query search
    $query_02 = "SELECT event_name, studentid, firstname, lastname, timein_no, timeout_no, event_total_absents
        FROM event_attendance
        JOIN student_info ON event_attendance.studentid = student_info.id
        JOIN events ON event_attendance.eventid = events.event_id
        WHERE events.event_id = '$event_id' ORDER BY lastname ASC LIMIT $first_page_number, $result_per_page";

    $result_02 = mysqli_query($conn, $query_02);

    $records = array();
    if (mysqli_num_rows($result_02) > 0) {
        while ($row = mysqli_fetch_assoc($result_02)) {
            $records[] = $row;
        }
    }

    $eventQuery = "SELECT event_id, event_name FROM events";
    $eventResult = mysqli_query($conn, $eventQuery);
    $events = array();
    while ($eventRow = mysqli_fetch_assoc($eventResult)) {
        $events[] = $eventRow;
    }


    mysqli_free_result($result_02);

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
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="GET" class="form">
            <select name="event_id" class="select" required style="padding: 8px";>
                <option value="">Select Event</option>
                <?php foreach ($events as $event) : ?>
                    <option value="<?php echo $event['event_id']; ?>" <?php if ($event_id == $event['event_id']) echo 'selected'; ?>>
                        <?php echo $event['event_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Search" style="background-color: grey; padding: 8px; border-radius: 10px; color: white; border: none; margin-bottom: 15px; margin-left: 5px;">
        </form>
                    <thead>
                        <th>Events </th>
                        <th> Student Name </th>
                        <th>Time-in Number:</th>
                        <th>Time-out Number:</th>
                        <th>Absents:</th>
                        
                    </thead>
                    <tbody>
                        <?php foreach($records as $record) : ?>
                        <tr>
                            <td><?php echo $record['event_name']; ?></td>
                            <td> <?php echo $record['lastname'] . ", " . $record ['firstname']; ?> </td>
                            <td><?php echo $record['timein_no']; ?></td>
                            <td><?php echo $record['timeout_no']; ?></td>
                            <td><?php echo $record['event_total_absents']; ?></td>
                            
                        </tr>
                        <?php endforeach ?>     
                    </tbody>
            </table><br>
            <?php 
                for ($page = 1; $page <= $number_of_page; $page++) {
                  echo '<a href="index.php?event_id=' . $event_id . '&page=' . $page . '" style="margin-right: 5px; padding: 5px; color: black;">' . $page . '</a>';
                }
              ?>
        </div>
    </body>
</html>