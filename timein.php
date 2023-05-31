<?php
  include 'connection.php';

  $queryy = "SELECT * FROM events";
  $result = mysqli_query($conn, $queryy);
  $events = mysqli_fetch_all($result, MYSQLI_ASSOC);

  global $idnum;

  date_default_timezone_set("Asia/Manila");
  if(isset($_POST['submit'])){
    $idnum = mysqli_real_escape_string($conn,$_POST['text']);
    $eventid = mysqli_real_escape_string($conn,$_POST['event']);
    $date = date('Y-m-d H:i:s');
    $is_morning = (date('H') < 12);

    $query_fetch_half_day_type = "SELECT half_day_type FROM events WHERE event_id = '$eventid'";
    $result_fetch_half_day_type = mysqli_query($conn, $query_fetch_half_day_type);
    $row_fetch_half_day_type = mysqli_fetch_assoc($result_fetch_half_day_type);
    $half_day_type = $row_fetch_half_day_type['half_day_type'];

      if ($is_morning && $half_day_type != 'Afternoon') {
          $query_check_existing = "SELECT * FROM attendance WHERE student_id = '$idnum' AND eventid = '$eventid' AND timein_am IS NOT NULL";
          $result_check_existing = mysqli_query($conn, $query_check_existing);

          if (mysqli_num_rows($result_check_existing) > 0) {
            echo "<script>alert('An existing record with the same student ID and event ID already has a time-in entry.');</script>";
          }
          else{
          $query = "INSERT INTO attendance (student_id, eventid, timein_am)
              VALUES ('$idnum', '$eventid', '$date')
              ON DUPLICATE KEY UPDATE timein_am = '$date'";
            $query2 = "INSERT INTO notification (notification, created_at) VALUES ('Student $idnum logged in this morning.', '$date')";
            mysqli_query($conn, $query2);
            $notificationId = mysqli_insert_id($conn);
            $query3 = "SELECT year FROM student_info WHERE id = $idnum";
            $result3 = mysqli_query($conn, $query3);
            if ($result3) {
              $row = mysqli_fetch_assoc($result3);
              $year = $row['year'];
              $query4 = "SELECT id FROM student_info WHERE year = '$year' AND id = $idnum";
              $result4 = mysqli_query($conn, $query4);
              if ($result4) {
                $row = mysqli_fetch_assoc($result4);
                $idstudent = $row['id'];
              }

              $query5 = "INSERT INTO notif_students (notif_id, students_id)
                      VALUES ($notificationId, '$idstudent')";
              mysqli_query($conn, $query5);
              mysqli_free_result($result4);
            }
              if(mysqli_query($conn, $query)){
                $attendance_check = "INSERT INTO event_attendance (studentid, eventid) VALUES ('$idnum', '$eventid')";
                $attendance_exists = "SELECT 1 FROM event_attendance WHERE studentid = '$idnum' AND eventid = '$eventid' LIMIT 1";
                $result_attendance_exists = mysqli_query($conn, $attendance_exists);

              if (mysqli_num_rows($result_attendance_exists) != 0) {
                $query_fetch_type = "SELECT type FROM events WHERE event_id = '$eventid'";
                $result_fetch_type = mysqli_query($conn, $query_fetch_type);
                $row_fetch_type = mysqli_fetch_assoc($result_fetch_type);
                $type = $row_fetch_type['type'];

                $query_fetch_counts = "SELECT timein_no, timeout_no FROM event_attendance WHERE studentid = '$idnum' AND eventid = '$eventid'";
                $result_fetch_counts = mysqli_query($conn, $query_fetch_counts);
                $row_fetch_counts = mysqli_fetch_assoc($result_fetch_counts);
                $timein_no = $row_fetch_counts['timein_no'];
                $timeout_no = $row_fetch_counts['timeout_no'];

                $timein_no += 1;

                $update_attendance = "UPDATE event_attendance SET timein_no = $timein_no WHERE studentid = '$idnum' AND eventid = '$eventid'";
                mysqli_query($conn, $update_attendance);

                if ($type == 'Whole Day') {
                    $total_attendance = "UPDATE event_attendance SET event_total_timein = event_total_timein + 1, event_total_timeout = event_total_timeout + 1 WHERE studentid = '$idnum' AND eventid = '$eventid'";
                    mysqli_query($conn, $total_attendance);
                } elseif ($type == 'Half Day') {
                    if ($half_day_type == 'Morning') {
                        $total_attendance = "UPDATE event_attendance SET event_total_timein = event_total_timein + 1 WHERE studentid = '$idnum' AND eventid = '$eventid'";
                        mysqli_query($conn, $total_attendance);
                    } elseif ($half_day_type == 'Afternoon') {
                        $total_attendance = "UPDATE event_attendance SET event_total_timeout = event_total_timeout + 1 WHERE studentid = '$idnum' AND eventid = '$eventid'";
                        mysqli_query($conn, $total_attendance);
                    }

                  $total_absents = "UPDATE event_attendance SET event_total_absents = event_total_timein + event_total_timeout - timein_no - timeout_no WHERE studentid = '$idnum' AND eventid = '$eventid'";
                  mysqli_query($conn, $total_absents);
                }

                  else{
                    $total_attendance = "UPDATE event_attendance SET event_total_timein =1, event_total_timeout=1";
                    $total_absents = "UPDATE event_attendance SET event_total_absents = event_total_timein + event_total_timeout - timein_no - timeout_no";
                    mysqli_query($conn, $total_attendance);
                    mysqli_query($conn, $total_absents);
                  }
                } else{
                    if(mysqli_query($conn, $attendance_check)){
                      $query_fetch_type = "SELECT type FROM events WHERE event_id = '$eventid'";
                    $result_fetch_type = mysqli_query($conn, $query_fetch_type);
                    $row_fetch_type = mysqli_fetch_assoc($result_fetch_type);
                    $type = $row_fetch_type['type'];

                    $query_fetch_counts = "SELECT timein_no, timeout_no FROM event_attendance WHERE studentid = '$idnum' AND eventid = '$eventid'";
                    $result_fetch_counts = mysqli_query($conn, $query_fetch_counts);
                    $row_fetch_counts = mysqli_fetch_assoc($result_fetch_counts);
                    $timein_no = $row_fetch_counts['timein_no'];
                    $timeout_no = $row_fetch_counts['timeout_no'];

                    $timein_no += 1;

                    $update_attendance = "UPDATE event_attendance SET timein_no = $timein_no WHERE studentid = '$idnum' AND eventid = '$eventid'";
                    mysqli_query($conn, $update_attendance);

                    if ($type == 'Whole Day') {
                        $total_attendance = "UPDATE event_attendance SET event_total_timein = event_total_timein + 1, event_total_timeout = event_total_timeout + 1 WHERE studentid = '$idnum' AND eventid = '$eventid'";
                        mysqli_query($conn, $total_attendance);
                    } elseif ($type == 'Half Day') {
                        if ($half_day_type == 'Morning') {
                            $total_attendance = "UPDATE event_attendance SET event_total_timein = event_total_timein + 1 WHERE studentid = '$idnum' AND eventid = '$eventid'";
                            mysqli_query($conn, $total_attendance);
                        } elseif ($half_day_type == 'Afternoon') {
                            $total_attendance = "UPDATE event_attendance SET event_total_timeout = event_total_timeout + 1 WHERE studentid = '$idnum' AND eventid = '$eventid'";
                            mysqli_query($conn, $total_attendance);
                        }

                      $total_absents = "UPDATE event_attendance SET event_total_absents = event_total_timein + event_total_timeout - timein_no - timeout_no WHERE studentid = '$idnum' AND eventid = '$eventid'";
                      mysqli_query($conn, $total_absents);
                    }
                      else{
                        $total_attendance = "UPDATE event_attendance SET event_total_timein =1, event_total_timeout=1";
                        $total_absents = "UPDATE event_attendance SET event_total_absents = event_total_timein + event_total_timeout - timein_no - timeout_no";
                        mysqli_query($conn, $total_attendance);
                        mysqli_query($conn, $total_absents);
                      }
                      }
                    }
                echo "<script>alert('Successfully timed-in: " . $idnum . "');</script>";
              }
            }
          } elseif (!$is_morning && $half_day_type != 'Morning') {
            $query_check_existing = "SELECT * FROM attendance WHERE student_id = '$idnum' AND eventid = '$eventid' AND timein_pm IS NOT NULL";
            $result_check_existing = mysqli_query($conn, $query_check_existing);

            if (mysqli_num_rows($result_check_existing) > 0) {
              echo "<script>alert('An existing record with the same student ID and event ID already has a time-in entry.');</script>";
            }
            else{
             $query = "INSERT INTO attendance (student_id, eventid, timein_pm)
              VALUES ('$idnum', '$eventid', '$date')
              ON DUPLICATE KEY UPDATE timein_pm = '$date'";
                $query2 = "INSERT INTO notification (notification, created_at) VALUES ('Student $idnum logged in this afternoon.', '$date')"; 
                mysqli_query($conn, $query2);
                $notificationId = mysqli_insert_id($conn);
                $query3 = "SELECT year FROM student_info WHERE id = $idnum";
                $result3 = mysqli_query($conn, $query3);
                if ($result3) {
                    $row = mysqli_fetch_assoc($result3);
                    $year = $row['year'];
                  $query4 = "SELECT id FROM student_info WHERE year = '$year' AND id = $idnum";
                  $result4 = mysqli_query($conn, $query4);
                  if ($result4) {
                      $row = mysqli_fetch_assoc($result4);
                      $idstudent = $row['id'];
                  }
                  $query5 = "INSERT INTO notif_students (notif_id, students_id)
                          VALUES ($notificationId, '$idstudent')";
                  mysqli_query($conn, $query5);
                  mysqli_free_result($result4);
              }

              if(mysqli_query($conn, $query)){
                $attendance_check = "INSERT INTO event_attendance (studentid, eventid) VALUES ('$idnum', '$eventid')";
                $attendance_exists = "SELECT 1 FROM event_attendance WHERE studentid = '$idnum' AND eventid = '$eventid' LIMIT 1";
                $result_attendance_exists = mysqli_query($conn, $attendance_exists);

              if (mysqli_num_rows($result_attendance_exists) != 0) {
                  $query_fetch_type = "SELECT type FROM events WHERE event_id = '$eventid'";
                  $result_fetch_type = mysqli_query($conn, $query_fetch_type);
                  $row_fetch_type = mysqli_fetch_assoc($result_fetch_type);
                  $type = $row_fetch_type['type'];

                  $query_fetch_counts = "SELECT timein_no, timeout_no FROM event_attendance WHERE studentid = '$idnum' AND eventid = '$eventid'";
                  $result_fetch_counts = mysqli_query($conn, $query_fetch_counts);
                  $row_fetch_counts = mysqli_fetch_assoc($result_fetch_counts);
                  $timein_no = $row_fetch_counts['timein_no'];
                  $timeout_no = $row_fetch_counts['timeout_no'];

                  $timein_no +=1;

                  $update_attendance = "UPDATE event_attendance SET timein_no = $timein_no WHERE studentid = '$idnum' AND eventid = '$eventid'";
                  mysqli_query($conn, $update_attendance);
                  if($type == 'Whole Day'){
                    $total_attendance = "UPDATE event_attendance SET event_total_timein =2, event_total_timeout=2";
                    $total_absents = "UPDATE event_attendance SET event_total_absents = event_total_timein + event_total_timeout - timein_no - timeout_no";
                    mysqli_query($conn, $total_attendance);
                    mysqli_query($conn, $total_absents);
                  }
                  else{
                    $total_attendance = "UPDATE event_attendance SET event_total_timein =1, event_total_timeout=1";
                    $total_absents = "UPDATE event_attendance SET event_total_absents = event_total_timein + event_total_timeout - timein_no - timeout_no";
                    mysqli_query($conn, $total_attendance);
                    mysqli_query($conn, $total_absents);
                  }
                } else{
                    if(mysqli_query($conn, $attendance_check)){
                      $query_fetch_type = "SELECT type FROM events WHERE event_id = '$eventid'";
                      $result_fetch_type = mysqli_query($conn, $query_fetch_type);
                      $row_fetch_type = mysqli_fetch_assoc($result_fetch_type);
                      $type = $row_fetch_type['type'];

                      $query_fetch_counts = "SELECT timein_no, timeout_no FROM event_attendance WHERE studentid = '$idnum' AND eventid = '$eventid'";
                      $result_fetch_counts = mysqli_query($conn, $query_fetch_counts);
                      $row_fetch_counts = mysqli_fetch_assoc($result_fetch_counts);
                      $timein_no = $row_fetch_counts['timein_no'];
                      $timeout_no = $row_fetch_counts['timeout_no'];

                      $timein_no +=1;

                      $update_attendance = "UPDATE event_attendance SET timein_no = $timein_no WHERE studentid = '$idnum' AND eventid = '$eventid'";
                      mysqli_query($conn, $update_attendance);
                    if($type == 'Whole Day'){
                      $total_attendance = "UPDATE event_attendance SET event_total_timein =2, event_total_timeout=2";
                      $total_absents = "UPDATE event_attendance SET event_total_absents = event_total_timein + event_total_timeout - timein_no - timeout_no";
                      mysqli_query($conn, $total_attendance);
                      mysqli_query($conn, $total_absents);
                    }
                    else{
                      $total_attendance = "UPDATE event_attendance SET event_total_timein =1, event_total_timeout=1";
                      $total_absents = "UPDATE event_attendance SET event_total_absents = event_total_timein + event_total_timeout - timein_no - timeout_no";
                      mysqli_query($conn, $total_attendance);
                      mysqli_query($conn, $total_absents);
                    }
                  }
                }
                echo "<script>alert('Successfully timed-in: " . $idnum . "');</script>";
              }
            }
          }
      }
  $conn->close();
?>
<!DOCTYPE html>
<html>
  <head>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="instascan.min.js"></script>
    <link rel="stylesheet" href="style.css" />     
  </head>
  <body style="font-family: sans-serif;">
    <?php include 'navbar.php'; ?>
    </nav>
            <br>
    <div class="container2" style="margin-left: 340px;">
      <video id="preview" style="width: 400px; height: 300px; border-radius: 50px;"></video>
        <button type="submit" class="time_in" style="margin-left: 100px; margin-top: -250px;">
        <a href="timein.php"> Time-in</a></button>
        <button type="submit" class="time_out" style="margin-left: 5px; margin-top: -250px;">
        <a href="timeout.php">Time-out</a></button>
          <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" style="margin-top: 100px; margin-left: -165px;">
            <label> ATTENDANCE TIME-IN:</label><br><br>
            <input type ="text" name="text" id="text" placeholder="Scan QR Code" class="form-control" style="padding: 15px; width: 150px">
            <br><br>
            <b>Event:<br></b><br>
            <select id = "event" name = "event" style="padding: 5px">
              <option value="none" selected disabled hidden>Type:</option>
              <?php foreach ($events as $event): ?>
              <option value="<?php echo $event['event_id']; ?>"><?php echo $event['event_name']; ?></option>
            <?php endforeach; ?>
            </select>
            <br><br>
            <input type ="submit" name="submit" id="submit" value="Submit" style=" padding: 15px">
          </form>
    <script>
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
      Instascan.Camera.getCameras().then(function (cameras) {
        if(cameras.length > 0 ){
          scanner.start(cameras[0]);
        }
        else {
          alert('No cameras found');
        }
      }).catch(function(e){
        console.error(e);
      });

      scanner.addListener('scan', function(c){
        document.getElementById('text').value=c;
      });
    </script>

  </body>
</html>
