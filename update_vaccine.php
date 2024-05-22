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
    <br><br><h2>UPDATE VACCINE INFORMATION</h2>
    <div class="center-box">
        <form action="./update_vaccine.php" method="post">
            <label for="id">Vaccine ID: </label>
            <input type="int" id="id" name="id" required><br><br>
            <input type="submit" value="Update Vaccine" name="submit5">
        </form>
        <?php 
            if (isset($_POST['submit5'])) {
                $id = $_POST['id'];

                $sql = "SELECT * FROM VACCINE WHERE VaccineID = '$id'";
                $result = $conn->query($sql);
        
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                ?>
                <br><br>Update whichever field is neccessary to be updated.<br><br>
                <form action="./update_vaccine.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    
                    <label for="name"><br><br>Name: </label>
                    <input type="varchar" id="name" name="name" value="<?php echo $row['Name']; ?>"><br><br>

                    <label for="company">Company Name: </label>
                    <input type="varchar" id="company" name="company" value="<?php echo $row['CompanyName'];?>"><br><br>

                    <label for="doses">Required Doses: </label>
                    <input type="int" id="doses" name="doses" value="<?php echo $row['RequiredDoses'];?>"><br><br>

                    <label for="desc">Description: </label>
                    <input type="text" id="desc" name="desc" value="<?php echo $row['Description'];?>"><br><br>

                    <label for="av">Availability: </label>
                    <input type="int" id="av" name="av" value="<?php echo $row['Availability'];?>"><br><br>
                
                    <label for="hold">On Hold: </label>
                    <input type="int" id="hold" name="hold" value="<?php echo $row['OnHold'];?>"><br><br>

                    <input type="submit" value="Update Information" name="submit6">
                </form>
                <?php
                } else {
                    echo nl2br ("\r\Vaccine not found\r\n<--");
                    header('refresh:1;url=admin_page.php');
                    exit;
                }
            } if (isset($_POST['submit6'])) {
                $id = $_POST['id'];
                $name = $_POST['name'];
                $company = $_POST['company'];
                $doses = $_POST['doses'];
                $desc = $_POST['desc'];
                $av = $_POST['av'];
                $hold = $_POST['hold'];

                $update_sql = "UPDATE VACCINE SET Name = '$name',
                CompanyName ='$company', 
                RequiredDoses = '$doses',
                Description = '$desc',
                Availability = '$av',
                OnHold = '$hold'
                WHERE VaccineID = '$id'";
                // echo "SQL Query: " . $update_sql;
                if ($conn->query($update_sql) === TRUE) {
                    $_SESSION['message'] = "Vaccine information updated successfully";
                } else {
                    $_SESSION['message'] = "Error updating information: " . $conn->error;
                }

                echo nl2br ($_SESSION['message']);
                header('refresh:1;url=admin_page.php');
                session_destroy();
                exit;
            }
            // var_dump($_POST);
        ?>
    </div>
</body>
</html>