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
    <title>view patient</title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <br><br><h2>VIEW PATIENT INFORMATION</h2><br><br>
    <div class="center-box">
        <form action="./view_patient_info.php" method="post">
            <label for="ssn">SSN: </label>
            <input type="int" id="ssn" name="ssn" required><br><br>
            <input type="submit" value="Find Patient" name="submit8"><br><br><br>
        </form>
        <?php 
        if (isset($_POST['submit8'])) {
            $ssn = $_POST['ssn'];

            $sql = "SELECT * FROM PATIENT WHERE SSN = '$ssn'";
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "SSN: " . $row["SSN"] . "<br>";
                echo "Name: " . $row["FName"] . " " . $row["MI"] . " " . $row["LName"] . "<br>";
                echo "Age: " . $row["Age"] . "<br>";
                echo "Gender: " . $row["Gender"] . "<br>";
                echo "Phone: " . $row["PhoneNo"] . "<br>";
                echo "Race: " . $row["Race"] . "<br>";
                echo "Occupation: " . $row["Occupation"] . "<br>";
                echo "Medical History: " . $row["Med_Hist"] . "<br>";
                echo "Address: " . $row["Address"] . "<br><br>";
                // echo "Scheduled Time: " . $row["ScheduleTime"] . "<br>";
                // echo "<hr>";

                $scheduleQuery = "SELECT TIMESLOT.Date, TIMESLOT.TimeStart, TIMESLOT.TimeEnd 
                FROM PATIENTSCHEDULE 
                JOIN TIMESLOT ON PATIENTSCHEDULE.SlotID = TIMESLOT.SlotID 
                WHERE PATIENTSCHEDULE.PatientSSN = '$ssn'";

                $scheduleResult = $conn->query($scheduleQuery);

                if ($scheduleResult->num_rows > 0) {
                echo "<br><br><h3>Scheduled Vaccination Times</h3><br>";
                echo "<ul>";
                while ($row = $scheduleResult->fetch_assoc()) {
                    echo "<li>Date: " . $row['Date'] . ", Time: " . $row['TimeStart'] . " - " . $row['TimeEnd'] . "</li>";
                }
                echo "</ul>";
                } else {
                echo "No scheduled vaccination times for this patient.";
                }

                $vaccinationHistoryQuery = "SELECT * 
                FROM VACCINATIONRECORD 
                WHERE PatientSSN = '$ssn'";

                $vaccinationHistoryResult = $conn->query($vaccinationHistoryQuery);

                if ($vaccinationHistoryResult->num_rows > 0) {
                    echo "<br><br><h3>Vaccination History</h3><br>";
                    echo "<table border='1'>";
                    echo "<tr><th>Vaccine</th><th>Dose Number</th><th>Time</th><th>Date</th></tr>";
                    while ($row = $vaccinationHistoryResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['VaccineID'] . "</td>";
                    echo "<td>" . $row['DoseNumber'] . "</td>";
                    echo "<td>" . $row['VaccinationTime'] . "</td>";
                    echo "<td>" . $row['Date'] . "</td>";
                    echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<br>No vaccination history for this patient.";
                }

            } else {
                echo nl2br ("\r\nPatient not found\r\n<--");
                // header('refresh:1;url=admin_page.php');
                exit;
            }
        }
        ?>

    </div>
</body>
</html>