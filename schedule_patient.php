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
    <title>schedule patient</title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <br><br><h2>Schedule Vaccination Appointment</h2><br><br>
    <div class="center-box">
    Enter the vaccination for which you want the appointment
    <form action="schedule_patient.php" method="post"><br><br>
        <label for="username1">Username: </label>
        <input type="text" id="username1" name="username1" required><br><br>
        <label for="password1">Password: </label>
        <input type="password" id="password1" name="password1" required><br><br>

        <label for="vaccine">Vaccination: </label>
        <input type="text" id="vaccine" name="vaccine" required><br><br>

        <!-- <label for="date1">Date:</label>
        <input type="date" id="date1" name="date1" required><br><br> -->
        <input type="submit" value="Lookup Vaccination Avalability" name="submitv1"><br><br><br>
    </form>
    <?php
    if (isset($_POST['submitv1'])) {

        $vaccine = $_POST['vaccine'];
        // validate username and password
        $username1 = $_POST['username1'];
        $password1 = $_POST['password1'];
        $sql = "SELECT * FROM PATIENT WHERE Username = '$username1'";
        $result = $conn->query($sql);
        
        // echo "SQL Query: " . $update_sql;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($password1 === $row['Password']) {
                //continue
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

        $ssn = $row['SSN'];

        $vaccineQuery = "SELECT * FROM VACCINE WHERE Name = '$vaccine'";
        // echo "SQL Query: " . $vaccineQuery;
        $vaccineResult = $conn->query($vaccineQuery);
        if ($vaccineResult->num_rows > 0) {
            $vaccineData = $vaccineResult->fetch_assoc();
            $availability = $vaccineData['Availability'];
            $onHold = $vaccineData['OnHold'];
            $vaccineID = $vaccineData['VaccineID'];
            $requiredDoses = $vaccineData['RequiredDoses'];

            if ($availability - $onHold > 0) {
                // Check the patient's vaccination status to ensure they are eligible for the dose
                if($requiredDoses > 1) {
                    // Check if patient has received the first dose of the same vaccine

                    $firstDoseQuery = "SELECT COUNT(*) as dose_count FROM VACCINATIONRECORD 
                    WHERE PatientSSN = '$ssn' AND VaccineID = '$vaccineID' AND DoseNumber = 1";

                    // echo "SQL Query: " . $firstDoseQuery ."<br>";
                    $firstDoseResult = $conn->query($firstDoseQuery);
                    if ($firstDoseResult->num_rows > 0) {
                        $firstDoseData = $firstDoseResult->fetch_assoc();
                        $firstDoseCount = $firstDoseData['dose_count'];
        
                        if ($firstDoseCount > 0) {
                            // check date and time slot
                            ?>
                            <form action="./schedule_patient.php" method="post">
                                <label for="date1">Date:</label>
                                <input type="date" id="date1" name="date1" required><br><br>
                                <input type="hidden" name="ssn" value="<?php echo $ssn; ?>">
                                <input type="hidden" name="vaccineID" value="<?php echo $vaccineID; ?>">
                                <input type="submit" value="Lookup Time Slots" name="submitv2"><br><br><br>
                            </form>
                            <?php
                            
                        } else {
                            echo "Patient did not recieve the first dose for this vaccine";
                            ?>
                            <form action="./schedule_patient.php" method="post">
                                <label for="date1">Date:</label>
                                <input type="date" id="date1" name="date1" required><br><br>
                                <input type="hidden" name="ssn" value="<?php echo $ssn; ?>">
                                <input type="hidden" name="vaccineID" value="<?php echo $vaccineID; ?>">
                                <input type="submit" value="Lookup Time Slots" name="submitv2"><br><br><br>
                            </form>
                            <?php
                        }
                    } else {
                        echo "Error in retrieving patient's vaccination record";
                        header('refresh:3;url=patient_login.php');
                        session_destroy();
                        exit;
                    }
                } else {
                    echo "Just one dose for this vaccine is required.";
                    ?>
                    <form action="./schedule_patient.php" method="post">
                        <label for="date1">Date:</label>
                        <input type="date" id="date1" name="date1" required><br><br>
                        <input type="hidden" name="ssn" value="<?php echo $ssn; ?>">
                        <input type="hidden" name="vaccineID" value="<?php echo $vaccineID; ?>">
                        <input type="submit" value="Lookup Time Slots" name="submitv2"><br><br><br>
                    </form>
                    <?php
                }
            } else {
                echo "Appointment for this vaccine cannot be set right now. (Not Available)";
                header('refresh:3;url=patient_login.php');
                session_destroy();
                exit;
            }
        } else {
            echo "Vaccine Name does not exist";
            header('refresh:3;url=patient_login.php');
            session_destroy();
            exit;
        }

    } if (isset($_POST['submitv2'])) {
        $_SESSION['message'] = "Select a time for your vaccination shot" ."<br><br>";
        $date1 = $_POST['date1'];
        $vaccineID = $_POST['vaccineID'];
        $ssn = $_POST['ssn'];

        $timeSlotsQuery = "SELECT SlotID, Date, TimeStart, TimeEnd FROM TIMESLOT WHERE Date = '$date1' AND NoPatientScheduled<MaxCapacity AND NoPatientScheduled<101";
        //  echo "SQL Query: " . $timeSlotsQuery;
        $result = $conn->query($timeSlotsQuery);
        ?> <form action="schedule_patient.php" method="post">
            <select id = "timeSlot" name="timeSlot"><?php
        // Display available time slots in the dropdown
        if ($result->num_rows > 0) {
            
            while ($row = $result->fetch_assoc()) {
                $slotID = $row['SlotID'];
                $date = $row['Date'];
                $startTime = $row['TimeStart'];
                $endTime = $row['TimeEnd'];
                echo "<option value='$slotID'>Date: $date, Time: $startTime - $endTime</option>";
            }
        } else {
            echo "No available time slots";
            header('refresh:3;url=patient_login.php');
            session_destroy();
            exit;
        }
        ?>
        <input type="hidden" name="ssn" value="<?php echo $ssn; ?>">
        <input type="hidden" name="vaccineID" value="<?php echo $vaccineID; ?>">
        <input type="submit" value="Schedule" name="submitv3">
        </select> 
        </form>
    
        <?php    

    } if (isset($_POST['submitv3'])) {
        $time = $_POST['timeSlot'];
        $vaccineID = $_POST['vaccineID'];
        $ssn = $_POST['ssn'];

        $updateVaccineQuery = "UPDATE VACCINE SET Availability = Availability - 1, OnHold = OnHold + 1 
        WHERE VaccineID = '$vaccineID'";
        // echo "SQL Query: " . $updateVaccineQuery;


        $sqlid = "SELECT MAX(PSCHEDULEID) AS MaxUserID FROM PATIENTSCHEDULE";
        $result1 = $conn->query($sqlid);

        if ($result1 && $result1->num_rows > 0) {
            $row1 = $result1->fetch_assoc();
            $maxUserID = $row1['MaxUserID'];
            // Increment the maximum UserID to generate a new unique UserID
            $newUserID = $maxUserID + 1;
        } else {
            // If no records exist, start from 1 for the first user
            $newUserID = 100;
        }


        $insertQuery = "INSERT INTO PATIENTSCHEDULE (PSCHEDULEID, SlotID, VaccineID, PatientSSN) VALUES ('$newUserID', '$time', '$vaccineID', '$ssn')";
        $insertQuery2 = "UPDATE TIMESLOT SET NoPatientScheduled = NoPatientScheduled + 1 WHERE SlotID='$time'";

        // echo "SQL Query: " . $insertQuery2;

        // $conn->query($updateVaccineQuery);

        // set appointment - patient schedule
        if ($conn->query($insertQuery) === TRUE) {
            // return true;
        } else {
            return "Error scheduling time for patient: " . $conn->error;
            echo nl2br($_SESSION['message']);
            header('refresh:3;url=patient_login.php');
            session_destroy();
            exit;
        }
       
        if ($conn->query($updateVaccineQuery) === TRUE) {
            $_SESSION['message'] = "Appointment Scheduled.";
        } else {
            return "Error scheduling time for patient: " . $conn->error;
        }

        if ($conn->query($insertQuery2) === TRUE) {
            $_SESSION['message'] = "Appointment Scheduled.";
        } else {
            return "Error scheduling time for patient: " . $conn->error;
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