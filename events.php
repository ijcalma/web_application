<?php
include 'connection.php';

    $result_per_page = 10;

    $query_01 = "SELECT * FROM events";

    $result_01 = mysqli_query($conn, $query_01);

    $resultRows = mysqli_num_rows($result_01);

    $number_of_page = ceil($resultRows / $result_per_page);

    if(!isset($_GET['page'])){
        $page = 1;
    }else{
        $page = $_GET['page'];

    }
    $first_page_number = ($page - 1) * $result_per_page;
    $query = "SELECT event_id, event_name, type, half_day_type, eventdate FROM events ORDER BY event_name ASC LIMIT $first_page_number, $result_per_page";


$search = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($search)) {
    $query .= " WHERE event_name LIKE '%$search%' OR event_id LIKE '%$search%' OR type LIKE '%$search%' OR half_day_type LIKE '%$search%' OR eventdate LIKE '%$search%'";
}


// Execute the modified query
$result = mysqli_query($conn, $query);

$records = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
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
    </nav>
    <div class="container">
        <button type="submit" class="add_student"><a href="addevent.php"> Add New Event</a></button>
        <button type="submit" style="float: right; border: solid black 1px; padding: 10px; border-radius: 5px;"><a href="index.php" style="color: black; "> Event Attendance</a></button>
        <table class="table" border="1">
            <center><h4>Event List</h4></center>
            <thead>
                <?php if (count($records) > 0): ?>
                    <?php $record = $records[0]; ?>
                    <th>Event ID</th>
                    <th>Event</th>
                    <th>Type</th>
                        <th>Half Day Type</th>
                    <th>Date of Event</th>
                <?php endif; ?>
            </thead>
            <tbody>
                <?php foreach ($records as $record) : ?>
                    <tr>
                        <td><?php echo $record['event_id']; ?></td>
                        <td><?php echo $record['event_name']; ?></td>
                        <td><?php echo $record['type']; ?></td>
                        <td><?php echo $record['half_day_type']; ?></td>
                        <td><?php echo $record['eventdate']; ?></td>
                        <td>
                            <?php echo '<button type="submit" class="time_in"><a href="editevent.php?event_id=' . $record['event_id'] . '"> Edit</a></button>
                            <button type="submit" class="time_out"><a href="deleteevent.php?event_id=' . $record['event_id'] . '"> Delete</a></button>
                        </td>'; ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php 
                for ($page = 1; $page <= $number_of_page; $page++) {
                  echo '<a href="events.php?page=' . $page . '" style="margin-right: 5px; padding: 5px; color: black;">' . $page . '</a>';
                }
              ?>
    </div>
</body>
</html>
