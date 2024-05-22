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
    <title>Add Vaccine</title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <br><br><h2>ADD VACCINE</h2><br><br>
    <div class="center-box">
        <form action="./add_vaccine.php" method="post">
            <label for="vaccineID">Vaccine ID: </label>
            <input type="int" id="vaccineID" name="vaccineID" required><br><br>

            <label for="name">Name: </label>
            <input type="varchar" id="name" name="name" ><br><br>

            <label for="company">Company Name: </label>
            <input type="varchar" id="company" name="company" required><br><br>

            <label for="doses">Required Doses: </label>
            <input type="int" id="doses" name="doses" required><br><br>

            <label for="desc">Description: </label>
            <input type="text" id="desc" name="desc" ><br><br>

            <label for="av">Availability: </label>
            <input type="int" id="av" name="av" required><br><br>

            <label for="hold">On Hold: </label>
            <input type="int" id="hold" name="hold" required><br><br>

            <input type="submit" value="Add Vaccine" name="submit4">
        </form>

        <?php 

        if (isset($_POST['submit4'])) {
            $id = $_POST['vaccineID'];
            $name = $_POST['name'];
            $company = $_POST['company'];
            $doses = $_POST['doses'];
            $desc = $_POST['desc'];
            $av = $_POST['av'];
            $hold = $_POST['hold'];

            $sql2 = "INSERT INTO VACCINE (VaccineID, Name, CompanyName, RequiredDoses, Description, Availability, OnHold) 
                VALUES ('$id', '$name', '$company', '$doses', '$desc', '$av', '$hold')";

            if ($conn->query($sql2) === TRUE) {
                // echo "\n\nNurse registered successfully";
                $_SESSION['message'] = "\r\n \r\nVaccine Added to the system";
            } else {
                // echo "Error: " . $sql2 . "<br>" . $conn->error;
                $_SESSION['message'] = "Error: " . $sql2 . "<br>" . $conn->error;
            }

            echo nl2br($_SESSION['message']);
            header('refresh:1;url=admin_page.php');
            session_destroy();
            exit;

        }

        ?>
    </div>
</body>
</html>