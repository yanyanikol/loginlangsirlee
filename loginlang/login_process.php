
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

    // Check if username exists
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Check if username starts with "admin"
            if (strpos($username, 'admin') === 0) {
                // Redirect to admin page
                header("Location: admin.php");
            } else {
                // Redirect to user page
                header("Location: user.php");
            }
        } else {
            echo "<p>Invalid password.</p>";
        }
    } else {
        echo "<p>Username does not exist.</p>";
    }
}

$conn->close();
?>
