<?php
include 'connection.php';

$event_id = $_GET['event_id'];
$query = "SELECT * FROM events WHERE event_id = $event_id";
$result = mysqli_query($conn, $query);
$event = mysqli_fetch_assoc($result);

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    if($type=='Whole Day'){
        $type2 = '';
        $query ="UPDATE events SET event_name = '$name', type = '$type', half_day_type = NULL, eventdate = '$date' WHERE event_id = $event_id";
    }
    else{
        if (isset($_POST['type2'])) {
            $type2 = mysqli_real_escape_string($conn, $_POST['type2']);
            $query ="UPDATE events SET event_name = '$name', type = '$type', half_day_type = '$type2', eventdate = '$date' WHERE event_id = $event_id";
        }
    }

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
            <b> Enter Event Name: <br></b>
            <input type="text" name="event_name" value="<?php echo $event['event_name']; ?>"> <br><br>
            <b>Type:</b>
            <select id="type" name="type">
                <option value="none" selected disabled hidden>Type:</option>
                <option id="Whole Day" value="Whole Day" <?php if($event['type'] == 'Whole Day') echo 'selected'; ?>>Whole Day</option>
                <option id="Half Day" value="Half Day" <?php if($event['type'] == 'Half Day') echo 'selected'; ?>>Half Day</option>
            </select>
            <br><br>
            <div id="type2-container" style="display:none;">
                <label for="type2"><b>Half Day Type:</b></label>
                <select id="type2" name="type2">
                    <option value="none" selected disabled hidden>Choose...</option>
                    <option value="Morning" <?php if($event['half_day_type'] == 'Morning') echo 'selected'; ?>>Morning</option>
                    <option value="Afternoon" <?php if($event['half_day_type'] == 'Afternoon') echo 'selected'; ?>>Afternoon</option>
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
            <input type="date" id="date" name="date" value="<?php echo $event['eventdate']; ?>">
            <br><br>
            <button name="submit" id="submits" value="Submit" class="submit">Submit</button>
        </form>
    </div>
</body>
</html>
