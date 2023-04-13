<?php
  $servername = "localhost";
  $username = "root";
  $password = "admin";
  $dbname = "attendance_db";

  global $idnum;
  global $count_to;
  $count_to = 0;
  $conn = new mysqli($servername, $username, $password, $dbname);

  date_default_timezone_set("Asia/Manila");

  if(isset($_POST['text'])){
    //  Get form data
        $idnum = mysqli_real_escape_string($conn,$_POST['text']);
        $date = date('Y-m-d H:i:s');

        $is_morning = (date('H') < 12);
        
        if ($is_morning) {
            $query ="UPDATE attendance SET timeout_am = '$date' WHERE timeout_am IS NULL AND student_id = '$idnum'";
        } else {
            $query ="UPDATE attendance SET timeout_pm = '$date' WHERE timeout_pm IS NULL AND student_id = '$idnum'";
        }
    
    //Execute query
        if(mysqli_query($conn, $query)){
            $count_to += 1;
            $query_to="UPDATE checklist SET timedout = $count_to where studentid='$idnum'";
            mysqli_query($conn, $query_to);
            echo "<script>alert('Successfully timed-out: " . $idnum . "');</script>";
        }else{
            echo 'ERROR: '. mysqli_error($conn);
        }
  }

  $conn->close();
?>

<!DOCTYPE html>
<html>
  <head>
    <script type ="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"/></script>
    <script type ="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"> </script>
    <script type ="text/javascript" src="instascan.min"> </script>
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
            <br>
    <div class="container2" style="margin-left: 340px;">
      <video id="preview" style="width: 400px; height: 300px; border-radius: 50px;"></video>
          <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
            <label style="margin-left: 115px"> ATTENDANCE TIME-OUT:</label><br><br>
            <input type ="text" name="text" id="text" placeholder="Scan QR Code" class="form-control" style="margin-left: 115px; padding: 15px; width: 150px">
            <input type ="submit" name="submit" id="submit" value="Submit" style="margin-left: 5px; padding: 15px">
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
