<!DOCTYPE html>
<html>
<head>
    <?php
        $server="localhost";
        $username="root";
        $password="";
        $dbname="project";
        $conn = new mysqli($server, $username, $password, $dbname);
        if($conn->connect_error) die("connection failed");
    ?>
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css" !important>
</head>
<body>
    <div class="center-box">
        <br><br><h2>Admin Login</h2>
        <form action="admin_login.php" method="post"><br><br>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login" name="login">
        </form>

        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
                $input_username = $_POST['username'];
                $input_password = $_POST['password'];

                $sql = "SELECT * FROM ADMIN where Username='$input_username'";
                $result = $conn->query($sql);
        
                if ($result->num_rows > 0) {
                    
                    $row = $result->fetch_assoc();
                    // Use password_verify for hashed passwords, if stored securely
                    if ($row['Password'] == $input_password) {
                        // Successful login
                        echo "Login successful!";
                        // Redirect the user to appropriate page based on role
                        header('Location: admin_page.php');
                    } else {
                        // Incorrect password
                        echo "Incorrect password!";
                    }
                } else {
                    // Username not found
                    echo "Username not found!";
                }
            }
        ?>
    </div>
</body>
</html>