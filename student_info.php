<?php
    include 'connection.php';

    global $idnum;

    $search = isset($_GET['search']) ? $_GET['search']: null;

    $results_per_page = 10;

    $query = "SELECT id, firstname, lastname, extname, course, year, block, event_id, event_name from attendance, student_info, events";
    $result = mysqli_query($conn, $query);
    $number_of_result = mysqli_num_rows($result);

    $number_of_page = ceil($number_of_result / $results_per_page);

    if(!empty($search)){
        $query = 'SELECT id, firstname, lastname, course, year, block from student_info
                  WHERE firstname LIKE "%'.$search.'%" OR lastname LIKE "%'.$search.'%" OR id LIKE "%'.$search.'%" OR course LIKE "%'.$search.'%" OR year LIKE "%'.$search.'%" OR block LIKE "%'.$search.'%" ORDER BY lastname';

    }else{
        $query = "SELECT id, firstname, lastname, course, year, block from student_info";
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
            <button type="submit" class="add_student">
            <a href="addstudent.php"> Add New Student</a></button>
            <div class="time">
                <button type="submit" class="time_in">
                <a href="timein.php"> Time-in</a></button>
            
                <button type="submit" class="time_out">
                <a href="timeout.php">Time-out</a></button>
            </div>
            <table class="table" border="1">
                <center><h4>Students List</h4></center>
                    <thead>
                        <th>Student Id</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Block</th>
                        <th>Actions</th>
                        
                    </thead>
                    <tbody>
                        <?php foreach($records as $record) : ?>
                        <tr>
                            <td><?php echo $record['id']; ?></td>
                            <td><?php echo $record['lastname'] . ", " . $record['firstname'] ?></td>
                            <td><?php echo $record['course']; ?></td>
                            <td><?php echo $record['year']; ?></td>
                            <td><?php echo $record['block']; ?></td>
                            <?php echo '<td> <button type="submit" class="time_in"><a href="editstudent.php?id=' . $record['id'] . '">Edit</a></button>'; ?>
                            <?php echo ' <button type="submit" class="time_out"><a href="deletestudent.php?id=' . $record['id'] . '">Delete</a></button></td>'; ?>
                            
                            
                        </tr>
                        <?php endforeach ?>     
                    </tbody>
            </table>
        </div>
    </body>
</html>