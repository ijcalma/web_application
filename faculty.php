<?php
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "attendance_db";

    $conn = new mysqli($servername, $username, $password, $dbname);  

    $search = isset($_GET['search']) ? $_GET['search']: null;

    $results_per_page = 10;

    $query = "SELECT facultyid, name, college, organization from faculty";
    $result = mysqli_query($conn, $query);
    $number_of_result = mysqli_num_rows($result);

    $number_of_page = ceil($number_of_result / $results_per_page);

    if(!empty($search)){
    $query = 'SELECT facultyid, name, college, organization 
        from faculty
        WHERE name LIKE "%'.$search.'%" OR facultyid LIKE "%'.$search.'%" OR organization LIKE "%'.$search.'%" ORDER BY name';
	} else {
        $query = "SELECT facultyid, name, college, organization from faculty";
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
        <div class="container">
            <button type="submit" class="add_student">
            <a href="addfaculty.php"> Add New Faculty Member</a></button>
            
            <table class="table" border="1">
                <h4 class="label">Students List</h4>
                    <thead>
                        <th>Faculty ID</th>
                        <th>Name</th>
                        <th>College</th>
                        <th>Organization</th>
                        
                    </thead>
                    <tbody>
                        <?php foreach($records as $record) : ?>
                        <tr>
                            <td><?php echo $record['facultyid']; ?></td>
                            <td><?php echo $record['name']; ?></td>
                            <td><?php echo $record['college']; ?></td>
                            <td><?php echo $record['organization']; ?></td>
                             
                            
                        </tr>
                        <?php endforeach ?>     
                    </tbody>
            </table>
        </div>
    </body>
</html>