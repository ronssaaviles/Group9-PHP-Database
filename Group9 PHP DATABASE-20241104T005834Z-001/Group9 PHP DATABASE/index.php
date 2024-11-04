<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <form action="index.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Sign up</a></p>
    </div>
</body>
</html>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database configuration
    include 'config.php';

    // Retrieve and sanitize user inputs
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    if ($stmt === false) {
        // Check if the SQL statement was prepared successfully
        die("Error in SQL statement: " . $conn->error);
    }

    // Bind the parameter to the SQL statement
    $stmt->bind_param("s", $username);

    // Execute the statement and store the result
    $stmt->execute();
    $stmt->store_result();

    // Bind result variables
    $stmt->bind_result($id, $hashed_password);

    // Check if a user with the given username was found
    if ($stmt->num_rows > 0) {
        // Fetch the result row
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Set session variables and redirect to dashboard if login is successful
            $_SESSION["user_id"] = $id;
            header("Location: dashboard.php");
            exit;
        } else {
            // Display error message for invalid password
            echo "<p>Invalid password.</p>";
        }
    } else {
        // Display error message if no user is found with the provided username
        echo "<p>No user found with that username.</p>";
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
