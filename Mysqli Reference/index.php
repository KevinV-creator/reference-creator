<?php
// Include database connection
include 'dbconnection.php';


$count = 1;
// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Fetch all records
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <style>
        table { width: 70%; border-collapse: collapse; }
        table, th, td {  border: 1px solid black; }
        th, td {  padding: 8px; text-align: left; }
        .actions { text-align: center; }  
    </style>
   
</head>
<body>
    <h1>User List</h1>
    <a href="add.php">Add New User</a>
    <?php
    
?>
   </h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <!-- <td><?php echo $row['id']; ?></td> -->
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td class="actions">
                        <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="index.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php
    // Close connection
    $conn->close();
    ?>
</body>
</html>