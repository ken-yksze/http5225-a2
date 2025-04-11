<?php
include '../reusable/connection.php';
include '../includes/functions.php';


// Fetch members that are not deleted
$sql = "SELECT * FROM members WHERE deleted_at IS NULL";
$result = $conn->query($sql);


include '../reusable/header-admin.php';
?>

<link rel="stylesheet" href="../reusable/css/admin-styles.css">

<div class="container admin-container">
    <h1 class="admin-title text-center">Members</h1>

    <?php get_message(); ?>

    <table class="table table-striped table-hover admin-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Role</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars(ucfirst($row['role'])); ?></td>
                    <td>
                        <?php
                        $imagePath = "../reusable/images/instructors/" . htmlspecialchars($row['image']);
                        if (file_exists($imagePath) && !empty($row['image'])) {
                            echo "<img src='$imagePath' alt='Instructor Image' style='width:100px;height:100px;'>";
                        } else {
                            echo "<img src='../reusable/images/instructors/no-image.png' alt='No Image Available' style='width:100px;height:100px;'>";
                        }
                        ?>
                    </td>
                    <td>
                        <a href="updateMember.php?id=<?php echo $row['member_id']; ?>" class="btn btn-admin-primary btn-sm">Edit</a>
                        <a href="deleteMember.php?id=<?php echo $row['member_id']; ?>" class="btn btn-admin-danger btn-sm" onclick="return confirm('Are you sure you want to delete this member?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="addMember.php" class="btn btn-admin-primary">Add New Member</a>
    </div>
</div>

<?php include '../reusable/footer-admin.php'; ?>