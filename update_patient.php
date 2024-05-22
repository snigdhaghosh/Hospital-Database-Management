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
    <title>update patient</title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <br><br><h2>UPDATE PATIENT INFORMATION</h2>
    <div class="center-box">
        <form action="./update_patient.php" method="post">
            <label for="SSN">SSN: </label>
            <input type="int" id="ssn" name="ssn" required><br><br>
            <input type="submit" value="Find Patient" name="submitp3">
        </form>
        <?php 
            if (isset($_POST['submitp3'])) {
                $ssn = $_POST['ssn'];

                $sql = "SELECT * FROM PATIENT WHERE SSN = '$ssn'";
                $result = $conn->query($sql);
        
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                ?>
            <br>Update whichever field is neccessary to be updated.
            <form action="./update_patient.php" method="post">
            <input type="hidden" name="ssn" value="<?php echo $ssn; ?>">
            
            <label for="fname"><br>First Name: </label>
            <input type="text" id="fname" name="fname" value="<?php echo $row['FName']; ?>"><br><br>

            <label for="mname">Middle Initial: </label>
            <input type="char" id="mname" name="mname" value="<?php echo $row['MI'];?>"><br><br>

            <label for="lname">Last Name: </label>
            <input type="text" id="lname" name="lname" value="<?php echo $row['LName'];?>"><br><br>

            <label for="age">Age: </label>
            <input type="int" id="age" name="age" value="<?php echo $row['Age'];?>"><br><br>

            <label for="gender">Gender: </label>
            <input type="char" id="gender" name="gender" value="<?php echo $row['Gender'];?>"><br><br>

            <label for="race">Race: </label>
            <input type="text" id="race" name="race" value="<?php echo $row['Race'];?>"><br><br>

            <label for="occupation">Occupation: </label>
            <input type="text" id="occupation" name="occupation" value="<?php echo $row['Occupation'];?>"><br><br>

            <label for="medHist">Medical History: </label>
            <input type="text" id="medHist" name="medHist" value="<?php echo $row['Med_History'];?>"><br><br>

            <label for="phone">Phone Number: </label>
            <input type="bigint" id="phone" name="phone" value="<?php echo $row['PhoneNo'];?>"><br><br>

            <label for="address">Address: </label>
            <input type="text" id="address" name="address" value="<?php echo $row['Address'];?>"><br><br>
        
            <label for="username">Username: </label>
            <input type="varchar" id="username" name="username" value="<?php echo $row['Username'];?>"><br><br>

            <label for="password">Password: </label>
            <input type="varchar" id="password" name="password" value="<?php echo $row['Password'];?>"><br><br>
            
            <input type="submit" value="Update Information" name="submitp4">
            </form>
            <?php
                } else {
                    echo nl2br ("\r\nPatient not found\r\n<--");
                    header('refresh:1;url=patient_login.php');
                    exit;
                }
            }
            ?>
        <?php
        if (isset($_POST['submitp4'])) {
            $ssn = $_POST['ssn'];
            $new_fname = $_POST['fname'];
            $mi = $_POST['mname'];
            $lname = $_POST['lname'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $race = $_POST['race'];
            $address = $_POST['address'];
            $medHist = $_POST['medHist'];
            $occupation = $_POST['occupation'];
            $phone = $_POST['phone'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            $update_sql = "UPDATE PATIENT SET FName = '$new_fname',
                MI='$mi', 
                LName = '$lname',
                Age = '$age',
                Gender = '$gender',
                Race = '$race',
                Med_History = '$medHist',
                Occupation = '$occupation',
                PhoneNo = '$phone',
                Address = '$address',
                Username = '$username',
                Password = '$password'
                WHERE SSN = '$ssn'";
            // echo "SQL Query: " . $update_sql;
            if ($conn->query($update_sql) === TRUE) {
                $_SESSION['message'] = "Patient information updated successfully";
            } else {
                $_SESSION['message'] = "Error updating information: " . $conn->error;
            }

            echo nl2br ($_SESSION['message']);
            header('refresh:1;url=patient_login.php');
            exit;
        }
        ?>
    </div>

</body>
</html>