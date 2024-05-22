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
    <title> Vaccination Record</title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <br><br><h2>Vaccination Record</h2>
    <div class="center-box">
        <form action="record_vaccination.php" method="post"><br><br>
            <label for="username1">Username: </label>
            <input type="text" id="username1" name="username1" required><br><br>
            <label for="password1">Password: </label>
            <input type="password" id="password1" name="password1" required><br><br>
            <input type="submit" value="Login" name="submitn5"><br><br><br>
        </form>
        <?php 
            if (isset($_POST['submitn5'])) {
                // validate username and password
                $username1 = $_POST['username1'];
                $password1 = $_POST['password1'];
                $sql = "SELECT * FROM NURSE WHERE Username = '$username1'";
                $result = $conn->query($sql);
                
                // echo "SQL Query: " . $sql;
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $employee_id = $row['EmployeeID'];
                    if($password1 === $row['Password']) {
                        ?>
                        <form action="record_vaccination.php" method="post">
                            <label for="patientSSN">Patient SSN: </label>
                            <input type="int" id="patientSSN" name="patientSSN" required><br><br>
                            
                            <label for="nurseID">Administered Nurse ID: </label>
                            <input type="int" id="nurseID" name="nurseID" value="<?php echo $employee_id; ?>"required><br><br>

                            <label for="slotID">Time Slot ID: </label>
                            <input type="int" id="slotID" name="slotID" required><br><br>
                            
                            <label for="vaccineID">Vaccine ID: </label>
                            <input type="int" id="vaccineID" name="vaccineID" required><br><br>

                            <label for="doseNumber">Dose Number: </label>
                            <input type="int" id="doseNumber" name="doseNumber" required><br><br>
                            
                            <label for="time">Vaccination Time: </label>
                            <input type="time" id="time" name="time" required><br><br>

                            <label for="date">Vaccination Date: </label>
                            <input type="date" id="date" name="date" required><br><br>
                            
                            <input type="submit" value="Record Vaccination" name="recordVaccination">
                        </form>
                        <?php
                    } else {
                        $_SESSION['message'] =  "Incorrect password";
                        echo nl2br($_SESSION['message']);
                        header('refresh:3;url=nurse_login.php');
                        session_destroy();
                        exit;
                    }
                } else {
                    $_SESSION['message'] =  "Username does not exist.";
                    echo nl2br($_SESSION['message']);
                    header('refresh:3;url=nurse_login.php');
                    session_destroy();
                    exit;
                }
            }  if (isset($_POST['recordVaccination'])) {
                // Nurse has submitted the vaccination record
                    $patientSSN = $_POST['patientSSN'];
                    $nurseID = $_POST['nurseID'];
                    $doseNumber = $_POST['doseNumber'];
                    $slotID = $_POST['slotID'];
                    $time = $_POST['time'];
                    $vaccineID = $_POST['vaccineID'];
                    $date = $_POST['date'];

                    $sql1 = "SELECT MAX(RecordID) AS MaxUserID FROM VACCINATIONRECORD";
                    $result1 = $conn->query($sql1);

                    if ($result1 && $result1->num_rows > 0) {
                        $row1 = $result1->fetch_assoc();
                        $maxUserID = $row1['MaxUserID'];
                        // Increment the maximum UserID to generate a new unique UserID
                        $newUserID = $maxUserID + 1;
                    } else {
                        // If no records exist, start from 1 for the first user
                        $newUserID = 1;
                    }

                    // Perform the insertion of the vaccination record into the database
                    $insertQuery = "INSERT INTO VACCINATIONRECORD (RecordID, PatientSSN, NurseID, SlotID, VaccineID, DoseNumber, VaccinationTime, Date)
                                    VALUES ('$newUserID', '$patientSSN', '$nurseID', '$slotID', '$vaccineID', '$doseNumber', '$time', '$date')";
                    
                    // Execute the query
                
                    if ( $conn->query($insertQuery) === TRUE) {
                        $_SESSION['message'] = "Vaccination recorded successfully.";
                    } else {
                        $_SESSION['message'] = "Error: " . $sql2 . "<br>" . $conn->error;
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