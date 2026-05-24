<?php
include 'connect.php';

$sql = "SELECT user_id, email, first_name, last_name, role, is_active, created_at 
        FROM tbluser 
        ORDER BY role, last_name";
$result = mysqli_query($connection, $sql);
?>

<div style='background-color:#ffff00'>
    <center>
        <h2 style="color:black">Manage All Users</h2>
    </center>
</div>

<div>
    <button><a href="admin_create.php">Add New Admin</a></button>
    <button><a href="dashboard.php">Back to Dashboard</a></button>
</div>

<br>
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Role</th>
            <th>Active</th>
            <th>Created</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['first_name']; ?></td>
            <td><?php echo $row['last_name']; ?></td>
            <td><?php echo ucfirst($row['role']); ?></td>
            <td><?php echo $row['is_active'] ? 'Yes' : 'No'; ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td>
                <button><a href="admin_edit.php?id=<?php echo $row['user_id']; ?>">EDIT</a></button>
                <button><a href="admin_delete.php?id=<?php echo $row['user_id']; ?>" onclick="return confirm('Delete this user?')">DELETE</a></button>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

 