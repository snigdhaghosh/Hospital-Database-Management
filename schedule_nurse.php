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
    <title>schedule nurse</title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <?php
//    Function to schedule time for nurses based on constraints
    function scheduleTimeForNurse($timeSlotID, $nurseID, $conn, $MaxCapacity, $NoScheduledNurses) {
        // Check if the time slot and nurse IDs are provided
        if ($timeSlotID && $nurseID) {
            // Check the number of nurses scheduled for the provided time slot
            $nurseCountQuery = "SELECT COUNT(*) as count FROM NURSESCHEDULE WHERE SlotID = '$timeSlotID'";
            // echo "<br>" ."SQL Query: " . $nurseCountQuery;
            $nurseCountResult = $conn->query($nurseCountQuery);

            if ($nurseCountResult->num_rows > 0) {
                $nurseCountData = $nurseCountResult->fetch_assoc();
                $nurseCount = $nurseCountData['count'];
    
                if ($nurseCount < 12) {
                    // Check if the nurse is not already scheduled for this time slot
                    $existingScheduleQuery = "SELECT COUNT(*) as count FROM NURSESCHEDULE WHERE SlotID = '$timeSlotID' AND NurseID = '$nurseID'";
                    // echo "<br>" ."SQL Query: " . $existingScheduleQuery;
                    $existingScheduleResult = $conn->query($existingScheduleQuery);
                    
                    if ($existingScheduleResult->num_rows > 0) {
                        $existingScheduleData = $existingScheduleResult->fetch_assoc();
                        $existingScheduleCount = $existingScheduleData['count'];
                        
                        if ($existingScheduleCount == 0) {
                            $sqlid = "SELECT MAX(NSCHEDULEID) AS MaxUserID FROM NURSESCHEDULE";
                            $result = $conn->query($sqlid);

                            if ($result && $result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $maxUserID = $row['MaxUserID'];
                                // Increment the maximum UserID to generate a new unique UserID
                                $newUserID = $maxUserID + 1;
                            } else {
                                // If no records exist, start from 1 for the first user
                                $newUserID = 1;
                            }

                            // Schedule the nurse for the time slot
                            $insertQuery = "INSERT INTO NURSESCHEDULE (NSCHEDULEID, SlotID, NurseID) VALUES ('$newUserID', '$timeSlotID', '$nurseID')";
                            
                            $MaxCapacity = $MaxCapacity+10;
                            $NoScheduledNurses = $NoScheduledNurses + 1;
                            $update_sql = "UPDATE TIMESLOT SET MaxCapacity = '$MaxCapacity',
                            NoScheduledNurses= '$NoScheduledNurses' 
                            WHERE SlotID = '$timeSlotID'";

                            // echo "<br>" ."SQL Query: " . $insertQuery;
                            if ($conn->query($insertQuery) === TRUE) {
                                // return true;
                            } else {
                                return "Error scheduling time for nurse: " . $conn->error;
                            }
                           
                            if ($conn->query($update_sql) === TRUE) {
                                return true;
                            } else {
                                return "Error scheduling time for nurse: " . $conn->error;
                            }

                        } else {
                            return "Nurse is already scheduled for this time slot";
                        }
                    }
                } else {
                    return "Maximum nurse scheduling limit reached for this time slot";
                }
            } else {
            return "Failed to retrieve necessary data";
            }
        } else {
        return "Invalid parameters provided";
        }
    }
    ?>
    
    <br><br><h2>Schedule Time</h2><br><br>
    <div class="center-box">
        Select the date you want to schedule for
        <form action="schedule_nurse.php" method="post"><br><br>
        <label for="username1">Username: </label>
            <input type="text" id="username1" name="username1" required><br><br>
            <label for="password1">Password: </label>
            <input type="password" id="password1" name="password1" required><br><br>

            <label for="date1">Date:</label>
            <input type="date" id="date1" name="date1" required><br><br>
            <input type="submit" value="Lookup Time Slots" name="submits1"><br><br><br>
        </form>
        <?php 
            if (isset($_POST['submits1'])) {
                $date1 = $_POST['date1'];
                // validate username and password
                $username1 = $_POST['username1'];
                $password1 = $_POST['password1'];
                $sql = "SELECT * FROM NURSE WHERE Username = '$username1'";
                $result = $conn->query($sql);
                $employee_id = $row['EmployeeID'];
                // echo "SQL Query: " . $update_sql;
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if($password1 === $row['Password']) {
                        ?>
                        <form action="./schedule_nurse.php" method="post">
                        <label for="time">Select time slot</label>
                        <select id="time" name="time"><br>
                        <option value="time1">10:00 - 11:00 AM</option>
                            <option value="time2">11:00 - 12:00 PM</option>
                            <option value="time3">12:00 - 01:00 PM</option>
                            <option value="time4">01:00 - 02:00 PM</option>
                            <option value="time5">02:00 - 03:00 PM</option>
                            <option value="time6">04:00 - 05:00 PM</option>
                            <option value="time7">05:00 - 06:00 PM</option>
                        </select><br><br>
                        <input type="hidden" name="employee_id" value="<?php echo $row['EmployeeID']; ?>">
                        <input type="hidden" name="date1" value="<?php echo $_POST['date1']; ?>">
                        <input type="submit" value="Submit" name="submits2">
                        </form>

                        <?php
                    } else {
                        $_SESSION['message'] =  "Incorrect password";
                    }
                } else {
                    $_SESSION['message'] =  "Username does not exist.";
                }

            } if (isset($_POST['submits2'])) {
                $employee_id = $_POST['employee_id'];
                $date1 = $_POST['date1'];
                $times = $_POST['time'];
                if($times === 'time1') {
                    $t1 = '10:00:00';
                    $t2 = '11:00:00';
                } else if($times === 'time2') {
                    $t1 = '11:00:00';
                    $t2 = '12:00:00';
                } else if($times === 'time3') {
                    $t1 = '12:00:00';
                    $t2 = '13:00:00';
                } else if($times === 'time4') {
                    $t1 = '13:00:00';
                    $t2 = '14:00:00';
                } else if($times === 'time5') {
                    $t1 = '14:00:00';
                    $t2 = '15:00:00';
                } else if($times === 'time6') {
                    $t1 = '16:00:00';
                    $t2 = '17:00:00';
                } else if($times === 'time7') {
                    $t1 = '17:00:00';
                    $t2 = '18:00:00';
                } else {
                    $_SESSION['message'] =  "Error: Time not chosen.";
                }
                $_SESSION['message'] =  "$t1 - $t2" . "<br>";

                $sql1 = "SELECT * FROM TIMESLOT WHERE Date='$date1' AND TimeStart = '$t1' AND TimeEnd = '$t2'";
                $result1 = $conn->query($sql1);
                // echo "SQL Query: " . $sql1;
                if ($result1->num_rows > 0) {
                    $row1 = $result1->fetch_assoc();
                    $_SESSION['message'] =  "SlotID = " .$row1['SlotID'] . "<br>";
                    $_SESSION['message'] =  "NurseID = " .$employee_id . "<br>";
                    
                    // Check here for the number of the nurses.
                    $timeSlotID = $row1['SlotID'];
                    $MaxCapacity = $row1['MaxCapacity'];
                    $NoScheduledNurses = $row1['NoScheduledNurses'];
                    $result2 = scheduleTimeForNurse($timeSlotID, $employee_id, $conn, $MaxCapacity, $NoScheduledNurses);
                    if ($result2 === true) {
                        $_SESSION['message'] =  "Nurse scheduled successfully for the time slot";
                    } else {
                        $_SESSION['message'] =  $result2;
                    }

                } else {
                    $_SESSION['message'] =  "No appointments have been scheduled for this date and time" . "<br>";
                    // echo "Scheduling for the time and date....";

                    // Add nurse to the slot. 
                    // timeslot
                    // NSchedule
                    $sqlid = "SELECT MAX(SlotID) AS MaxID FROM TIMESLOT";
                    $result3 = $conn->query($sqlid);

                    if ($result3 && $result3->num_rows > 0) {
                        $row3 = $result3->fetch_assoc();
                        $maxID = $row3['MaxID'];
                        // Increment the maximum UserID to generate a new unique UserID
                        $newID = $maxID + 1;
                    } else {
                        // If no records exist, start from 1 for the first user
                        $newID = 1;
                    }

                    $insertQuery1 = "INSERT INTO TIMESLOT (SlotID, Date, TimeStart, TimeEnd) VALUES ('$newID', '$date1', '$t1', '$t2')";
                    if ($conn->query($insertQuery1) === TRUE) {
                        // return true;
                    } else {
                        return "Error scheduling time for nurse: " . $conn->error;
                    }

                    $timeSlotID = $newID;
                    $MaxCapacity = 0;
                    $NoScheduledNurses = 0;
                    $result2 = scheduleTimeForNurse($timeSlotID, $employee_id, $conn, $MaxCapacity, $NoScheduledNurses);
                    if ($result2 === true) {
                        $_SESSION['message'] =  "Nurse scheduled successfully for the time slot";
                    } else {
                        $_SESSION['message'] =  $result2;
                    }


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

