<?php
  include 'connection.php';

  $total = 0;
  $attendance = 0;
  if(isset($_POST['submit'])){
    //  Get form data
        $name = mysqli_real_escape_string($conn, $_POST['event_name']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);

        if($type=='Whole Day'){
          $type2 = '';
        $query ="INSERT INTO events(event_name, type, eventdate)
        VALUES ('$name', '$type', '$date')";

        }
        else{
          if (isset($_POST['type2'])) {
          $type2 = mysqli_real_escape_string($conn, $_POST['type2']);
          $query ="INSERT INTO events(event_name, type, half_day_type, eventdate)
        VALUES ('$name', '$type', '$type2', '$date')";
          }
        }
    
    //Execute query
        if(mysqli_query($conn, $query)){
            header("Location: events.php");
        }else{
            echo 'ERROR: '. mysqli_error($conn);
        }
        
  }

  $conn->close();
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
      <b> Enter Events Name: <br></b>
      <input type ="text" name="event_name"> <br><br>
      <b>Type:</b>
      <select id="type" name="type">
        <option value="none" selected disabled hidden>Type:</option>
        <option id="Whole Day" value="Whole Day">Whole Day</option>
        <option id="Half Day" value="Half Day">Half Day</option>
      </select>
      <br><br>
      <div id="type2-container" style="display:none;">
        <label for="type2"><b>Half Day Type:</b></label>
        <select id="type2" name="type2">
          <option value="none" selected disabled hidden>Choose...</option>
          <option value="Morning">Morning</option>
          <option value="Afternoon">Afternoon</option>
        </select>
      </div>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script>
      $(function() {
        $('#type').change(function(){
          if ($(this).val() == 'Half Day') {
            $('#type2-container').show();
          } else {
            $('#type2-container').hide();
          }
        });
      });
      </script>


      <br><br>
      <b> Event Date: <br></b>
      <input type="date" id="date" name="date">
      <br><br>
        <a href="events.php"> <button name = "submit" id="submits" value="Submit" class="submit">Submit</button></a>
        </form>
</div>
  </body>
</html>