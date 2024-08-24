<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "it_resource_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    
    // Query to get admin user details
    $sql = "SELECT * FROM admins WHERE username='$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            header("Location: admin.php"); // Redirect to the admin page
            exit();
        } else {
            echo "<p>Invalid username or password</p>";
        }
    } else {
        echo "<p>Invalid username or password</p>";
    }
}

$conn->close();
?>
