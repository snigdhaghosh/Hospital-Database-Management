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
    <title>update nurse</title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <br><br><h2>UPDATE NURSE INFORMATION</h2>
    <div class="center-box">
        <form action="./update_nurse.php" method="post">
            <label for="id">Employee ID: </label>
            <input type="int" id="id" name="id" required><br><br>
            <input type="submit" value="Find Nurse" name="submit2">
        </form>
        <?php 
            if (isset($_POST['submit2'])) {
                $employee_id = $_POST['id'];

                $sql = "SELECT * FROM NURSE WHERE EmployeeID = '$employee_id'";
                $result = $conn->query($sql);
        
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                ?>
            <br><br>Update whichever field is neccessary to be updated.<br><br>
            <form action="./update_nurse.php" method="post">
                <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
                
                <label for="fname"><br><br>First Name: </label>
                <input type="text" id="fname" name="fname" value="<?php echo $row['FName']; ?>"><br><br>

                <label for="mname">Middle Initial: </label>
                <input type="text" id="mname" name="mname" value="<?php echo $row['MI'];?>"><br><br>

                <label for="lname">Last Name: </label>
                <input type="text" id="lname" name="lname" value="<?php echo $row['LName'];?>"><br><br>

                <label for="age">Age: </label>
                <input type="int" id="age" name="age" value="<?php echo $row['Age'];?>"><br><br>

                <label for="gender">Gender: </label>
                <input type="char" id="gender" name="gender" value="<?php echo $row['Gender'];?>"><br><br>
            
                <label for="username">Username: </label>
                <input type="varchar" id="username" name="username" value="<?php echo $row['Username'];?>"><br><br>

                <label for="password">Password: </label>
                <input type="varchar" id="password" name="password" value="<?php echo $row['Password'];?>"><br><br>
                
                <input type="submit" value="Update Information" name="submit3">
            </form>
                <?php
                } else {
                    echo nl2br ("\r\nNurse not found\r\n<--");
                    header('refresh:1;url=admin_page.php');
                    exit;
                }
        } if (isset($_POST['submit3'])) {

            $employee_id = $_POST['employee_id'];
            $new_fname = $_POST['fname'];
            $mi = $_POST['mname'];
            $lname = $_POST['lname'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $username =$_POST['username'];
            $password =$_POST['password'];

            $update_sql = "UPDATE NURSE SET FName = '$new_fname',
            MI='$mi', 
            LName = '$lname',
            Age = '$age',
            Gender = '$gender',
            Username = '$username',
            Password = '$password'
            WHERE NURSE.EmployeeID = '$employee_id'";
            // echo "SQL Query: " . $update_sql;
            if ($conn->query($update_sql) === TRUE) {
                $_SESSION['message'] = "Nurse information updated successfully";
            } else {
                $_SESSION['message'] = "Error updating information: " . $conn->error;
            }

            echo nl2br ($_SESSION['message']);
            header('refresh:1;url=admin_page.php');
            exit;
        }
        ?>
    </div>


</body>
</html>