<!DOCTYPE html>
<html>
<head>
    <?php
        session_start();
        $server="localhost";
        $username="root";
        $password="";
        $dbname="project";
        $conn = new mysqli($server, $username, $password, $dbname);
        if($conn->connect_error) die("connection failed");
    ?>
    <title>view nurse</title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <br><br><h2>VIEW NURSE INFORMATION</h2><br><br>
    <div class="center-box">
        <form action="./view_nurse_info.php" method="post">
            <label for="id">Employee ID: </label>
            <input type="int" id="id" name="id" required><br><br>
            <input type="submit" value="Find Nurse" name="submit7"><br><br>
        </form>
        <?php 
            if (isset($_POST['submit7'])) {
                $employee_id = $_POST['id'];

                $sql = "SELECT * FROM NURSE WHERE EmployeeID = '$employee_id'";
                $result = $conn->query($sql);
        
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "Nurse ID: " . $row["EmployeeID"] . "<br>";
                    echo "Name: " . $row["FName"] . " " . $row["MI"] . " " . $row["LName"] . "<br>";
                    echo "Age: " . $row["Age"] . "<br>";
                    echo "Gender: " . $row["Gender"] . "<br>";
                    echo "Phone: " . $row["PhoneNo"] . "<br>";
                    echo "Address: " . $row["Address"] . "<br><br>";
                    // echo "Scheduled Time: " . $row["ScheduleTime"] . "<br>";
                    // echo "<hr>";

                    $scheduleQuery = "SELECT TIMESLOT.Date, TIMESLOT.TimeStart, TIMESLOT.TimeEnd 
                    FROM NURSESCHEDULE 
                    JOIN TIMESLOT ON NURSESCHEDULE.SlotID = TIMESLOT.SlotID 
                    WHERE NURSESCHEDULE.NurseID = '$employee_id'";

                    $scheduleResult = $conn->query($scheduleQuery);

                    if ($scheduleResult->num_rows > 0) {
                    echo "<br><h3>Scheduled Times</h3>";
                    echo "<ul>";
                    while ($row = $scheduleResult->fetch_assoc()) {
                        echo "<li>Date: " . $row['Date'] . ", Time: " . $row['TimeStart'] . " - " . $row['TimeEnd'] . "</li>";
                    }
                    echo "</ul>";
                    } else {
                    echo "No scheduled times for this nurse.";
                    }

                } else {
                    echo nl2br ("\r\nNurse not found\r\n<--");
                    // header('refresh:1;url=admin_page.php');
                    exit;
                }
            }
        ?>
    </div>
</body>
</html>