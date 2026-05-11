<?php
include 'connect.php';
require_once 'includes/header.php';

$sql = "SELECT u.user_id, u.email, u.first_name, u.last_name, 
               a.admin_number, a.clearance_level, a.office 
        FROM tbluser u 
        JOIN tbladmin a ON u.user_id = a.user_id 
        WHERE u.role = 'admin'";
$result = mysqli_query($connection, $sql);
?>

<a href="dashboard.php" style="display: inline-block; margin-bottom: 20px; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;">← Back to Dashboard</a>

<table border="1">
    <thead>
        <tr><th>ID</th><th>Email</th><th>First Name</th><th>Last Name</th><th>Admin No.</th><th>Clearance</th><th>Office</th><th>Actions</th></tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['user_id'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['first_name'] ?></td>
            <td><?= $row['last_name'] ?></td>
            <td><?= $row['admin_number'] ?></td>
            <td><?= $row['clearance_level'] ?></td>
            <td><?= $row['office'] ?></td>
            <td>
                <a href="admin_edit.php?id=<?= $row['user_id'] ?>">Edit</a> |
                <a href="admin_delete.php?id=<?= $row['user_id'] ?>" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<a href="admin_create.php">Add New Admin</a>

<?php require_once 'includes/footer.php'; ?>