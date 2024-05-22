<!DOCTYPE html>
<html>
<head>
    <?php
        session_start();
        // ob_start();
        $server="localhost";
        $username="root";
        $password="";
        $dbname="project";
        $conn = new mysqli($server, $username, $password, $dbname);
        if($conn->connect_error) die("connection failed");
    ?>
    <title>register nurse</title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <br><br><h2>Register a Nurse</h2>
    <div class="center-box">
        <form action="./register_nurse.php" method="post">
            <label for="fname">First Name: </label>
            <input type="text" id="fname" name="fname" required><br><br>

            <label for="mname">Middle Initial: </label>
            <input type="text" id="mname" name="mname" ><br><br>

            <label for="lname">Last Name: </label>
            <input type="text" id="lname" name="lname" required><br><br>

            <label for="age">Age: </label>
            <input type="int" id="age" name="age" required><br><br>

            <label for="gender">Gender: </label>
            <input type="char" id="gender" name="gender" required><br><br>

            <label for="phone">Phone Number: </label>
            <input type="bigint" id="phone" name="phone" required><br><br>

            <label for="id">Employee ID: </label>
            <input type="int" id="id" name="id" required><br><br>

            <input type="hidden" name="adminfn" value="register">
            <input type="submit" value="Register Nurse" name="submit1">
        </form>
    </div>
    <?php 
        if (isset($_POST['submit1'])) {
            $fname = $_POST['fname'];
            $mi = $_POST['mname'];
            $lname = $_POST['lname'];
            $employee_id = $_POST['id'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];
            $password= substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-:,"),0,10);
            $username = implode(".",[$lname,$fname]);
            
            echo nl2br ("\r\n \r\nYour Username: $username");
            echo nl2br ("\r\n \r\nYour Password: $password");

            $sql1 = "INSERT INTO USERINFO(UserID, Username, Password, UserType) 
            VALUES ('$employee_id','$username','$password', 'Nurse')";
            if ($conn->query($sql1) === TRUE) {
                // echo "\n\nUser ID registered successfully";
                $_SESSION['message'] = "\r\n \r\nUserID registered registered successfully";
            } else {
                // echo "Error: " . $sql2 . "<br>" . $conn->error;
                $_SESSION['message'] = "Error: " . $sql2 . "<br>" . $conn->error;

            }
            // SQL query to insert nurse data
            $sql2 = "INSERT INTO NURSE (EmployeeID, Username, Password, UserID, FName, MI, LName, Age, Gender, PhoneNo) 
            VALUES ('$employee_id', '$username', '$password', '$employee_id', '$fname', '$mi', '$lname', '$age', '$gender', $phone)";

            if ($conn->query($sql2) === TRUE) {
                // echo "\n\nNurse registered successfully";
                $_SESSION['message'] = "\r\n \r\nNurse registered successfully";
            } else {
                // echo "Error: " . $sql2 . "<br>" . $conn->error;
                $_SESSION['message'] = "Error: " . $sql2 . "<br>" . $conn->error;
            }

            echo nl2br($_SESSION['message']);
            header('refresh:3;url=admin_page.php');
            session_destroy();
            exit;

        }
    ?>
</body>
</html>