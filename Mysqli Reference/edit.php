<?php
// Include database connection
include 'dbconnection.php';

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
    $person_age = $_POST['person_age'];
    $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, age = ? WHERE id = ?");
    $stmt->bind_param("ssii", $first_name, $last_name ,$person_age, $id);
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
    <link rel="icon" href="images/kevin.ico" type="image/x-icon">
</head>
<body>
    <h1>Edit User</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" value="<?php echo $user['first_name']; ?>" required>
        <br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" value="<?php echo $user['last_name']; ?>" required><br>
       
        <label for="person_age">Age:</label>
        <input type="number" name="person_age"  min="1" max="150" id="person_age"   value="<?php echo $user['age']; ?>"  required>
        <br>
        <button type="submit">Update User</button>
    </form>
    <br>
    <a href="index.php">Back to User List</a>
</body>
</html>