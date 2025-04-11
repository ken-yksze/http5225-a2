<?php
include '../reusable/connection.php';
include '../includes/functions.php';

// Fetch members with their current class details
$sql = "SELECT m.member_id, m.name AS member_name, m.email, m.role, m.image, 
               c.class_name, c.class_time
        FROM members m
        LEFT JOIN classes c ON m.class_id = c.class_id
        WHERE m.allocation_deleted_at IS NULL";
$result = $conn->query($sql);
?>

<?php include '../reusable/header-admin.php'; ?>

<link rel="stylesheet" href="../reusable/css/admin-styles.css">

<style>
    .btn-group .btn {
        margin-right: 5px;
    }
    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>

<div class="container admin-container">
    <h1 class="admin-title text-center">Members</h1>

    <?php get_message(); ?>

    <table class="table table-striped table-hover admin-table">
        <thead>
            <tr>
                <th>Member Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Image</th>
                <th>Current Class</th>
                <th>Class Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['member_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars(ucfirst($row['role'])); ?></td>
                    <td>
                        <?php
                        $imagePath = "../reusable/images/instructors/" . htmlspecialchars($row['image']);
                        if (file_exists($imagePath) && !empty($row['image'])) {
                            echo "<img src='$imagePath' alt='Member Image' style='width:100px;height:100px;' class='img-thumbnail'>";
                        } else {
                            echo "<img src='../reusable/images/instructors/no-image.png' alt='No Image Available' style='width:100px;height:100px;' class='img-thumbnail'>";
                        }
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['class_name'] ? $row['class_name'] : 'No class assigned'); ?></td>
                    <td><?php echo htmlspecialchars($row['class_time'] ? date('d-m-Y H:i', strtotime($row['class_time'])) : 'N/A'); ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <?php if (!$row['class_name']): ?>
                                <a href="allocatemember.php?member_id=<?php echo urlencode($row['member_id']); ?>" class="btn btn-admin-primary btn-sm">Assign to a class</a>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm" disabled>Assigned</button>
                            <?php endif; ?>
                            <a href="updateallocation.php?member_id=<?php echo urlencode($row['member_id']); ?>" class="btn btn-admin-primary btn-sm">Edit</a>
                            <a href="deleteallocation.php?member_id=<?php echo urlencode($row['member_id']); ?>" class="btn btn-admin-danger btn-sm" onclick="return confirm('Are you sure you want to delete this member?');">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../reusable/footer-admin.php'; ?>
