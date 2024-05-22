<!DOCTYPE html>
<html>
<head>
    <?php
        // ob_start();
        $server="localhost";
        $username="root";
        $password="";
        $dbname="project";
        $conn = new mysqli($server, $username, $password, $dbname);
        if($conn->connect_error) die("connection failed");
    ?>
    <title>Admin Page</title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <div class="center-box">
        <br><br><h2>Admin Page</h2><br><br>
        <form action="./admin_page.php" method="post">
            <label for="adminfn">Select the functionality you want to perform</label><br><br>
            <select id="adminfn" name="adminfn"><br>
                <option value="register">Register Nurse</option>
                <option value="updateNurse">Update Nurse Information</option>
                <option value="delNurse">Delete a nurse</option>
                <option value="addVacine">Add Vaccine</option>
                <option value="updateVaccine">Update Vaccine</option>
                <option value="viewNurseInfo">View Nurse Infomation</option>
                <option value="viewPatientInfo">View Patient Infomation</option>
            </select>
            <br><br>
            <input type="submit" value="Submit" name="submit">
        </form>
            <!-- <script> 
        function clearcontent() { 
                document.body.innerHTML = ""; 
        }
        </script>  -->
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                $adminfn = $_POST['adminfn'];
            }
            switch($adminfn) {
                case 'register' : 
                    header('Location: register_nurse.php');
                    exit;
                    break;
                case 'updateNurse':
                    header('Location: update_nurse.php');
                    exit; 
                    break; 
                case 'delNurse':
                    header('Location: delete_nurse.php');
                    exit; 
                    break;
                case 'addVacine':
                    header('Location: add_vaccine.php');
                    exit;
                    break;
                case 'updateVaccine':
                    header('Location: update_vaccine.php');
                    exit;
                    break;
                case 'viewNurseInfo':
                    header('Location: view_nurse_info.php');
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
            // $conn->close();
        ?>
    </div>
</body>
</html>