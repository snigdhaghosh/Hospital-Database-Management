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
        <!-- <br><br>Update whichever field is neccessary to be updated.<br><br> -->
        <form action="update_nurse_add.php" method="post"><br><br>
            <label for="username1">Username:</label>
            <input type="text" id="username1" name="username1" required><br><br>
            <label for="password1">Password:</label>
            <input type="password" id="password1" name="password1" required><br><br>
            <input type="submit" value="Login" name="submitn2"><br><br><br>
        </form>
        <!-- <form action="./update_nurse_add.php" method="post">
            <label for="id">Employee ID: </label>
            <input type="int" id="id" name="id" required><br><br>
            <input type="submit" value="Find Nurse" name="submit2">
        </form> -->
        <?php 
            if (isset($_POST['submitn2'])) {
                $username1 = $_POST['username1'];
                $password1 = $_POST['password1'];

                $update_sql = "SELECT * FROM NURSE WHERE Username = '$username1'";
                $result = $conn->query($update_sql);
                
                // echo "SQL Query: " . $update_sql;

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                
                    if($password1 === $row['Password']) {
                        echo "Nurse ID: " . $row["EmployeeID"] . "<br>";
                        echo "Name: " . $row["FName"] . " " . $row["MI"] . " " . $row["LName"] . "<br>";
                        echo "Age: " . $row["Age"] . "<br>";
                        echo "Gender: " . $row["Gender"] . "<br>";
                ?>
            <form action="./update_nurse_add.php" method="post">
            <input type="hidden" name="employee_id" value="<?php echo $row['EmployeeID']; ?>">

            <label for="phone"><br><br>Phone Number: </label>
            <input type="int" id="phone" name="phone" value="<?php echo $row['PhoneNo']; ?>"><br><br>

            <label for="address">Address: </label>
            <input type="text" id="address" name="address" value="<?php echo $row['Address'];?>"><br><br>
            
            <input type="submit" value="Update Information" name="submitn3">
        </form>
            <?php
                    } else {
                            echo nl2br ("\r\nWrong Password\r\n<--");
                        header('refresh:1;url=nurse_login.php');
                        exit;
                    }
                } else {
                    echo nl2br ("\r\nUsername does not exist\r\n<--");
                    header('refresh:1;url=nurse_login.php');
                    exit;
                }
            }
            ?>
        <?php
        if (isset($_POST['submitn3'])) {

                $employee_id = $_POST['employee_id'];
                $address = $_POST['address'];
                $phone = $_POST['phone'];

                $update_sql2 = "UPDATE NURSE SET Address = '$address',
                PhoneNo='$phone' 
                WHERE NURSE.EmployeeID = '$employee_id'";
                // echo "SQL Query: " . $update_sql2;
                if ($conn->query($update_sql2) === TRUE) {
                    $_SESSION['message'] = "Nurse information updated successfully";
                } else {
                    $_SESSION['message'] = "Error updating information: " . $conn->error;
                }

                echo nl2br ($_SESSION['message']);
                header('refresh:1;url=nurse_login.php');
                exit;
            }
        ?>
    </div>
</body>
</html>