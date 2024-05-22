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
    <title>cancel schedule nurse</title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <br><br><h2>Cancel Scheduled Time</h2><br><br>
    <div class="center-box">
        <form action="cancel_nurse_sch.php" method="post"><br><br>
        <label for="username1">Username: </label>
            <input type="text" id="username1" name="username1" required><br><br>
            <label for="password1">Password: </label>
            <input type="password" id="password1" name="password1" required><br><br>
            <input type="submit" value="Find Scheduled Time" name="submitn1"><br><br><br>
        </form>
        <?php
        if (isset($_POST['submitn1'])) {
            // validate username and password
            $username1 = $_POST['username1'];
            $password1 = $_POST['password1'];
            $sql = "SELECT * FROM NURSE WHERE Username = '$username1'";
            $result = $conn->query($sql);
            
            // echo "SQL Query: " . $update_sql;
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if($password1 === $row['Password']) {
                    $employee_id = $row['EmployeeID'];
                    $scheduledTimesQuery = "SELECT * FROM NURSESCHEDULE WHERE NurseID = '$employee_id'";
                    // echo "<br>" ."SQL Query: " . $scheduledTimesQuery;
                    $result1 = $conn->query($scheduledTimesQuery);

                    if ($result1->num_rows > 0) { 
                        ?>
                        <form action="cancel_nurse_sch.php" method="post">
                            <label for="timeSlot">Select Time Slot to Cancel:</label>
                            <select id="timeSlot" name="timeSlot">
                            <?php
                            while ($row1 = $result1->fetch_assoc()) {
                                $slotID = $row1['SlotID'];
                                $timesQuery = "SELECT * FROM TIMESLOT WHERE SlotID = '$slotID'";
                                $result3 = $conn->query($timesQuery);
                                $row3 = $result3->fetch_assoc();
                                $date1 = $row3['Date'];
                                $startTime = $row3['TimeStart'];
                                $endTime = $row3['TimeEnd'];
                                echo "<option value='$slotID'>Date: $date1, Time: $startTime - $endTime</option>";
                            }
                            ?>
                            </select>
                            <input type="submit" value="Cancel Time" name="cancelTime">
                            <input type="hidden" name="nurseID" value="<?php echo $employee_id; ?>">
                        </form>
                        <?php
                        // get nschecuded id
                        // time slot
                    } else {
                        echo "No time scheduled for this nurse";
                        // echo nl2br($_SESSION['message']);
                        header('refresh:3;url=nurse_login.php');
                        session_destroy();
                        exit;
                    }
                } else {
                    echo "Incorrect Password";
                    // echo nl2br($_SESSION['message']);
                    header('refresh:3;url=nurse_login.php');
                    session_destroy();
                    exit;
                }
            } else {
                echo "Username does not exist";
                // echo nl2br($_SESSION['message']);
                header('refresh:3;url=nurse_login.php');
                session_destroy();
                exit;
            }
        } if (isset($_POST['cancelTime'])) {
            $selectedSlot = $_POST['timeSlot'];
            $nurseID = $_POST['nurseID'];

            // Perform the deletion of the selected time slot from NURSESCHEDULE table
            $deleteQuery = "DELETE FROM NURSESCHEDULE WHERE SlotID = '$selectedSlot' AND NurseID = '$nurseID'";
            // echo "<br>" ."SQL Query: " . $deleteQuery;

            $deleteQuery2 = "UPDATE TIMESLOT SET NoScheduledNurses = NoScheduledNurses - 1, 
            MaxCapacity = MaxCapacity - 10 WHERE SlotID = '$selectedSlot'";
            // echo "<br>" ."SQL Query: " . $deleteQuery2;

            // Execute the query
            if($conn->query($deleteQuery) === TRUE &&  $conn->query($deleteQuery2) ===TRUE) {
                echo "Time slot canceled successfully.";
            } else {
                echo "Error deleting record: " . $conn->error;
            }

            echo nl2br($_SESSION['message']);
            header('refresh:3;url=nurse_login.php');
            session_destroy();
            exit;
        }

        ?>
    </div>
</body>
</html>
