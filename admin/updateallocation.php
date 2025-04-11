<?php
include '../reusable/connection.php';
include '../includes/functions.php';

// Check if 'member_id' is in the URL
if (isset($_GET['member_id'])) {
    $member_id = mysqli_real_escape_string($conn, $_GET['member_id']);

    // Process form submission
    if (isset($_POST['updateAllocation'])) {
        $class_id = mysqli_real_escape_string($conn, $_POST['class_id']);
        $sql = "UPDATE members SET class_id='$class_id' WHERE member_id='$member_id'";
        
        if ($conn->query($sql) === TRUE) {
            set_message("Allocation updated successfully", "success");
        } else {
            set_message("Error: " . $conn->error, "danger");
        }
        header('Location: manageallocation.php');
        exit();
    } else {
        // Fetch member details
        $sql = "SELECT * FROM members WHERE member_id='$member_id' AND deleted_at IS NULL";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $member = $result->fetch_assoc();
        } else {
            set_message("Member not found", "danger");
            header('Location: manageallocation.php');
            exit();
        }

        // Fetch classes
        $sql = "SELECT * FROM classes WHERE deleted_at IS NULL";
        $classes_result = $conn->query($sql);
        $classes = [];
        while ($row = $classes_result->fetch_assoc()) {
            $classes[] = $row;
        }
    }
} else {
    set_message("Invalid request", "danger");
    header('Location: manageallocation.php');
    exit();
}
?>

<?php include '../reusable/header-admin.php'; ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="../reusable/css/styles.css">

<div class="container mt-5">
    <h1 class="text-center">Edit Member</h1>
    <?php get_message(); ?>
    <form method="post" class="mt-4">
        <input type="hidden" name="updateMember" value="1">
        <div class="form-group">
            <label for="member_name">Member Name</label>
            <input type="text" class="form-control" id="member_name" name="member_name" value="<?php echo htmlspecialchars($member['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($member['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <input type="text" class="form-control" id="role" name="role" value="<?php echo htmlspecialchars($member['role']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Member</button>
    </form>
</div>

<?php include '../reusable/footer-admin.php'; ?>
