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
    <title>Nurse Login</title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <br><br><h2>Nurse</h2><br><br>
    <div class="center-box">
        <form action="./nurse_login.php" method="post">
            <label for="nursefn">Select the functionality you want to perform</label><br><br>
            <select id="nursefn" name="nursefn"><br>
                <option value="updateNurse">Update Information</option>
                <option value="scheduleappt">Schedule Time Slots</option>
                <option value="cancelaapt">Cancel Scheduled Time</option>
                <option value="viewNurseInfo">View Nurse Infomation</option>
                <option value="vaccination">Record Vaccination Delivered</option>
            </select>
            <br><br>
            <input type="submit" value="Submit" name="submitN">
        </form>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitN'])) {
                $patientfn = $_POST['nursefn'];
            }
            switch($patientfn) {
                case 'updateNurse':
                    header('Location: update_nurse_add.php');
                    exit; 
                    break; 
                case 'scheduleappt':
                    header('Location: schedule_nurse.php');
                    exit; 
                    break;
                case 'cancelaapt':
                    header('Location: cancel_nurse_sch.php');
                    exit;
                    break;
                case 'viewNurseInfo':
                    header('Location: view_nurse_info.php');
                    exit;
                    break;
                case 'vaccination':
                    header('Location: record_vaccination.php');
                    exit;
                    break;
                default:
                    // echo "select a action to perform";
                    break;
            }
            // $conn->close();
        ?>
    </div>
</body>
</html>