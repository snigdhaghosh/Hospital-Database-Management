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
    <title>cancel schedule patient</title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <br><br><h2>Cancel Appointment Scheduled</h2><br><br>
    <div class="center-box">
        <form action="cancel_patient_sch.php" method="post"><br><br>
        <label for="username1">Username: </label>
            <input type="text" id="username1" name="username1" required><br><br>
            <label for="password1">Password: </label>
            <input type="password" id="password1" name="password1" required><br><br>
            <input type="submit" value="Find Scheduled Time" name="submitpp1"><br><br><br>
        </form>
        <?php
        if (isset($_POST['submitpp1'])) {

            $username1 = $_POST['username1'];
            $password1 = $_POST['password1'];
            $sql = "SELECT * FROM PATIENT WHERE Username = '$username1'";
            $result = $conn->query($sql);
            
            // echo "SQL Query: " . $update_sql;
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if($password1 === $row['Password']) {
                    $ssn = $row['SSN'];
                    $scheduledTimesQuery = "SELECT * FROM PATIENTSCHEDULE WHERE PatientSSN = '$ssn'";
                    $result1 = $conn->query($scheduledTimesQuery);

                    if ($result1->num_rows > 0) { 
                        ?>
                        <form action="cancel_patient_sch.php" method="post">
                            <label for="timeSlot">Select Time Slot to Cancel:</label><br><br>
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
                                $vaccineID = $row1['VaccineID'];
                                echo "<option value='$slotID'> Vaccine: $vaccineID, Date: $date1, Time: $startTime - $endTime</option>";
                            }
                            ?>
                            </select>
                            <input type="submit" value="Cancel Time" name="cancelTime1">
                            <input type="hidden" name="ssn" value="<?php echo $ssn; ?>">
                            <input type="hidden" name="vaccineID" value="<?php echo $vaccineID; ?>">
                        </form>
                        <?php
                        // get nschecuded id
                        // time slot
                    } else {
                        echo "No time scheduled for thsis patient";
                        header('refresh:3;url=patient_login.php');
                        session_destroy();
                        exit;
                    }
                } else {
                    echo nl2br("Incorrect password");
                    header('refresh:3;url=patient_login.php');
                    session_destroy();
                    exit;
                }
            } else {
                echo nl2br("Username does not exist.");
                header('refresh:3;url=patient_login.php');
                session_destroy();
                exit;
            }
        } if (isset($_POST['cancelTime1'])) {
            $selectedSlot = $_POST['timeSlot'];
            $ssn = $_POST['ssn'];
            
            $sql2 = "SELECT * FROM PATIENTSCHEDULE WHERE SlotID = '$selectedSlot' AND PatientSSN = '$ssn'";
            $result4 = $conn->query($sql2);
            // echo "<br>" ."SQL Query: " . $sql2;
            $row4 = $result4->fetch_assoc();
            if ($result4->num_rows > 0) { 
                $vaccineID = $row4['VaccineID'];
            } else {
                echo "Could not find vaccine id";
                header('refresh:3;url=patient_login.php');
                session_destroy();
                exit;
            }
            

            $deleteQuery = "DELETE FROM PATIENTSCHEDULE WHERE SlotID = '$selectedSlot' AND PatientSSN = '$ssn'";
            // echo "<br>" ."SQL Query: " . $deleteQuery;
            $deleteQuery2 = "UPDATE TIMESLOT SET NoPatientScheduled = NoPatientScheduled - 1 WHERE SlotID = '$selectedSlot'";
            // echo "<br>" ."SQL Query: " . $deleteQuery2;

            
            $deleteQuery3 = "UPDATE VACCINE SET OnHold = OnHold + 1, Availability = Availability+1 WHERE VaccineID = '$vaccineID'";
            // echo "<br>" ."SQL Query: " . $deleteQuery3;

            if ($conn->query($deleteQuery) === TRUE) {
            } else {
                echo "Error deleting record: " . $conn->error;
                header('refresh:3;url=patient_login.php');
                session_destroy();
                exit;
            }
            if($conn->query($deleteQuery2) ===TRUE){

            } else {
                echo "Error deleting record: " . $conn->error;
                header('refresh:3;url=patient_login.php');
                session_destroy();
                exit;
            }
            if ($conn->query($deleteQuery3) === TRUE){
                echo "Time slot canceled successfully.";
            }else {
                echo "Error deleting record: " . $conn->error;
            }
            echo nl2br($_SESSION['message']);
            header('refresh:3;url=patient_login.php');
            session_destroy();
            exit;
        }
        ?>
    </div>
</body>
</html>