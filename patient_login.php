<!DOCTYPE html>
<html>
<head>
    <?php
        $server="localhost";
        $username="root";
        $password="";
        $dbname="project";
        $conn = new mysqli($server, $username, $password, $dbname);
        if($conn->connect_error) die("connection failed");
    ?>
    <title>Patient Page</title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <br><br><h2>Patient</h2><br><br>
    <div class="center-box">
        <form action="./patient_login.php" method="post">
            <label for="patientfn">Select the functionality you want to perform</label><br><br>
            <select id="patientfn" name="patientfn"><br>
                <option value="register">Register Patient</option>
                <option value="updatePatient">Update Patient Information</option>
                <option value="scheduleappt">Schedule Vaccination Time</option>
                <option value="cancelaapt">Cancel Vaccination Appointment</option>
                <option value="viewPatientInfo">View Patient Infomation</option>
            </select>
            <br><br>
            <input type="submit" value="Submit" name="submitP">
        </form>
            <!-- <script> 
        function clearcontent() { 
                document.body.innerHTML = ""; 
        }
        </script>  -->
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitP'])) {
                $patientfn = $_POST['patientfn'];
            }
            switch($patientfn) {
                case 'register' : 
                    header('Location: register_patient.php');
                    exit;
                    break;
                case 'updatePatient':
                    header('Location: update_patient.php');
                    exit; 
                    break; 
                case 'scheduleappt':
                    header('Location: schedule_patient.php');
                    exit; 
                    break;
                case 'cancelaapt':
                    header('Location: cancel_patient_sch.php');
                    exit;
                    break;
                case 'viewPatientInfo':
                    header('Location: view_patient_info.php');
                    exit;
                    break;
                default:
                    // echo "select a action to perform";
                    break;
            }
        ?>
    </div>
</body>
</html>