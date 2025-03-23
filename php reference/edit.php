<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'mydb';
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM users WHERE id = $id");
    $user = $result->fetch_assoc();
}

// Handle form submission for update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ? WHERE id = ?");
    $stmt->bind_param("ssi", $first_name, $last_name, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php"); // Redirect to the main page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" value="<?php echo $user['first_name']; ?>" required>
        <br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" value="<?php echo $user['last_name']; ?>" required>
        <br>
        <button type="submit">Update User</button>
    </form>
    <br>
    <a href="index.php">Back to User List</a>
</body>
</html>