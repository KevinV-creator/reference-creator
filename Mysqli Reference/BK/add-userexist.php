<?php
// Include database connection
include 'dbconnection.php';

// Handle form submission for insert
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $person_age = $_POST['person_age'];

    // Check if the first_name and last_name already exist in the database
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE first_name = ? AND last_name = ?");
    $stmt->bind_param("ss", $first_name, $last_name);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

        if ($count > 0) {
            echo "<p style='color:red;'>User with the name $first_name $last_name already exists!</p>";
        } else {
            // Insert new user into the database
            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, age) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $first_name, $last_name, $person_age);
            $stmt->execute();
            $stmt->close();
            header("Location: index.php"); // Redirect to the main page
            exit();
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
</head>
<body>
    <h1>Add New User</h1>
    <form method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_namex" required>
        <br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_namex" required>
        <br>
        <label for="person_age">Age:</label>
        <input type="number" min="1" max="150" name="person_age" id="person_age" required>
        <br>
        <button type="submit">Add User</button>
    </form>
    <br>
    <a href="index.php">Back to User List</a>
</body>
</html>
