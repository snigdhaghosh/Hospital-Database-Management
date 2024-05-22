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
    <title>Delete Nurse</title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <br><br><h2>DELETE A NURSE INFORMATION</h2>
    <div class="center-box">
        <form action="./delete_nurse.php" method="post">
            <label for="id">Employee ID: </label>
            <input type="int" id="id" name="id" required><br><br>
            <input type="submit" value="Delete Nurse" name="submit2">
        </form>
        <?php 
            if (isset($_POST['submit2'])) {
                $employee_id = $_POST['id'];

                $sql = "SELECT * FROM NURSE WHERE EmployeeID = '$employee_id'";
                $result = $conn->query($sql);
        
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    $del_sql = "DELETE FROM NURSE WHERE EmployeeID = '$employee_id'";
                    if ($conn->query($del_sql) ===TRUE) {
                        $_SESSION['message'] = "Nurse deleted from database";
                    } else {
                        $_SESSION['message'] = "Error updating information: " . $conn->error;
                    }

                    $del2_sql = "DELETE FROM USERINFO WHERE UserId = '$employee_id'";
                    if ($conn->query($del2_sql) ===TRUE) {
                        $_SESSION['message'] = "Nurse deleted from database";
                    } else {
                        $_SESSION['message'] = "Error updating information: " . $conn->error;
                    }

                } else {
                    echo nl2br ("\r\nNurse not found\r\n<--");
                    header('refresh:1;url=admin_page.php');
                    exit;
                }
            echo nl2br ($_SESSION['message']);
            header('refresh:1;url=admin_page.php');
            session_destroy();
            exit;
            }
        ?>
    </div>
</body>
</html>
