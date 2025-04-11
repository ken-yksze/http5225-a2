<?php
include '../reusable/connection.php';
include '../includes/functions.php';

// Check if 'id' is in the URL
if (isset($_GET['id'])) {
    $class_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Process form submission
    if (isset($_POST['updateClass'])) {
        $class_name = mysqli_real_escape_string($conn, $_POST['class_name']);
        $class_time = mysqli_real_escape_string($conn, $_POST['class_time']);
        $video_id = mysqli_real_escape_string($conn, $_POST['video_id']);

        $sql = "UPDATE classes SET class_name='$class_name', class_time='$class_time', video_id='$video_id' WHERE class_id='$class_id'";
        if ($conn->query($sql) === TRUE) {
            set_message("Class updated successfully", "success");
            header('Location: classes.php');
            exit();
        } else {
            set_message("Error: " . $conn->error, "danger");
        }
    } else {
        // Fetch class details
        $sql = "SELECT * FROM classes WHERE class_id='$class_id' AND deleted_at IS NULL";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
        } else {
            set_message("Class not found", "danger");
            header('Location: classes.php');
            exit();
        }
    }
} else {
    set_message("Invalid request", "danger");
    header('Location: classes.php');
    exit();
}
?>

<?php include '../reusable/header-admin.php'; ?>

<div class="container admin-container">
    <h1 class="admin-title">Edit Class</h1>

    <?php get_message(); ?>

    <form method="post" class="admin-form">
        <input type="hidden" name="updateClass" value="1">
        <div class="mb-3">
            <label for="class_name" class="form-label">Class Name:</label>
            <input type="text" class="form-control" id="class_name" name="class_name" value="<?php echo htmlspecialchars($row['class_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="class_time" class="form-label">Class Time:</label>
            <input type="datetime-local" class="form-control" id="class_time" name="class_time" value="<?php echo date('Y-m-d\TH:i', strtotime($row['class_time'])); ?>" required>
        </div>
        <div class="mb-3">
            <label for="video_id" class="form-label">YouTube Video ID:</label>
            <input type="text" class="form-control" id="video_id" name="video_id" value="<?php echo htmlspecialchars($row['video_id']); ?>">
        </div>
        <button type="submit" class="btn btn-admin-primary">Update Class</button>
    </form>
</div>

<?php include '../reusable/footer-admin.php'; ?>
