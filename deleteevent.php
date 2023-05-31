<?php
    include "connection.php";
    $id = $_GET["event_id"];
        $query = "DELETE FROM events WHERE event_id = '$id'";
        if(mysqli_query($conn, $query)) {
            echo '<script>alert("Event record successfully deleted.")</script>';
            echo "<a href ='events.php'><button> Return to Event List</button></a>";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }

    mysqli_close($conn);
?>

