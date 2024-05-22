<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        session_start();
        $server="localhost";
        $username="root";
        $password="";
        $dbname="project";
        $conn = new mysqli($server, $username, $password, $dbname);
        if($conn->connect_error) die("connection failed");
    ?>
    <title>
        HOSPITAL DATABASE SYSTEM
        USER SELECTION PORTAL
    </title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <br><br><br><h1 id=home-name>HOSPITAL PORTAL</h1><br><br><br><br><br>
    <div class="center-box">
        <h2>Select User Type</h2><br>
        <form action="./main.php" method="post">
            <label for="userType">Choose user type:</label><br><br><br>
            <select id="userType" name="userType"><br>
                <option value="admin">Admin</option>
                <option value="nurse">Nurse</option>
                <option value="patient">Patient</option>
            </select>
            <br><br>
            <input type="submit" value="Submit" class = ".submits">
        </form>
    </div>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userType = $_POST['userType'];
            // Redirect to respective pages based on user type
            if ($userType == 'admin') {
                header('Location: admin_login.php');
                exit;
            } elseif ($userType == 'nurse') {
                header('Location: nurse_login.php');
                exit;
            } elseif ($userType == 'patient') {
                header('Location: patient_login.php');
                exit;
            }
        }
    ?>
</body>
</html>
 