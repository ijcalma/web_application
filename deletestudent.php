<?php
    include "connection.php";
    $id = $_GET["id"];
        $query = "DELETE FROM student_info WHERE id = '$id'";
        if(mysqli_query($conn, $query)) {
            echo '<script>alert("Student record successfully deleted.")</script>';
            echo "<a href ='student_info.php'><button> Return to Student List</button></a>";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }

    mysqli_close($conn);
?>

