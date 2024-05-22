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
    <title>register patient</title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <br><br><h2>Register a Patient</h2><br><br>
    <div class="center-box">
        <form action="./register_patient.php" method="post">
            <label for="ssn">SSN: </label>
            <input type="int" id="ssn" name="ssn" required><br><br>

            <label for="fname">First Name: </label>
            <input type="text" id="fname" name="fname" required><br><br>

            <label for="mname">Middle Initial: </label>
            <input type="char" id="mname" name="mname" ><br><br>

            <label for="lname">Last Name: </label>
            <input type="text" id="lname" name="lname" required><br><br>

            <label for="age">Age: </label>
            <input type="int" id="age" name="age" required><br><br>

            <label for="gender">Gender: </label>
            <input type="char" id="gender" name="gender" required><br><br>

            <label for="race">Race: </label>
            <input type="text" id="race" name="race" required><br><br>

            <label for="occupation">Occupation: </label>
            <input type="text" id="occupation" name="occupation" required><br><br>

            <label for="medHist">Medical History: </label>
            <input type="text" id="medHist" name="medHist" required><br><br>

            <label for="phone">Phone Number: </label>
            <input type="bigint" id="phone" name="phone" required><br><br>

            <label for="address">Address: </label>
            <input type="text" id="address" name="address" required><br><br>

            <label for="username">Username: </label>
            <input type="varchar" id="username" name="username" required><br><br>

            <label for="password">Password: </label>
            <input type="varchar" id="password" name="password" required><br><br>

            <input type="hidden" name="adminfn" value="register">
            <input type="submit" value="Register Patient" name="submitP1">
        </form>
        <?php 
            if (isset($_POST['submitP1'])) {
                $fname = $_POST['fname'];
                $mi = $_POST['mname'];
                $lname = $_POST['lname'];
                $ssn = $_POST['ssn'];
                $age = $_POST['age'];
                $gender = $_POST['gender'];
                $race = $_POST['race'];
                $address = $_POST['address'];
                $medHist = $_POST['medHist'];
                $occupation = $_POST['occupation'];
                $phone = $_POST['phone'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                
                $sql = "SELECT MAX(UserID) AS MaxUserID FROM USERINFO";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $maxUserID = $row['MaxUserID'];
                    // Increment the maximum UserID to generate a new unique UserID
                    $newUserID = $maxUserID + 1;
                } else {
                    // If no records exist, start from 1 for the first user
                    $newUserID = 1;
                }

                $sql1 = "INSERT INTO USERINFO(UserID, Username, Password, UserType) 
                VALUES ('$newUserID','$username','$password', 'Patient')";
                if ($conn->query($sql1) === TRUE) {
                    // echo "\n\nUser ID registered successfully";
                    $_SESSION['message'] = "\r\n \r\nUserID registered registered successfully";
                } else {
                    // echo "Error: " . $sql2 . "<br>" . $conn->error;
                    $_SESSION['message'] = "Error: " . $sql2 . "<br>" . $conn->error;

                }
                // SQL query to insert nurse data
                $sql2 = "INSERT INTO PATIENT (SSN, Username, Password, UserID, FName, MI, LName, Age, Gender, Race, Occupation, Med_History, PhoneNo, Address) 
                VALUES ('$ssn', '$username', '$password', '$newUserID', '$fname', '$mi', '$lname', '$age', '$gender', '$race', '$occupation', '$medHist', '$phone','$address')";
                echo "SQL Query: " . $sql2;
                if ($conn->query($sql2) === TRUE) {
                    // echo "\n\nNurse registered successfully";
                    $_SESSION['message'] = "\r\n \r\nPatient registered successfully";
                } else {
                    // echo "Error: " . $sql2 . "<br>" . $conn->error;
                    $_SESSION['message'] = "Error: " . $sql2 . "<br>" . $conn->error;
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