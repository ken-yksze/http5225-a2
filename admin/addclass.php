<?php
include '../reusable/connection.php';
include '../includes/functions.php';

// Form data variables
$class_name = $class_time = $video_id = '';
$errors = [];

// Form submission check
if (isset($_POST['addClass'])) {
    // Escape POST variables
    $class_name = mysqli_real_escape_string($conn, $_POST['class_name']);
    $class_time = mysqli_real_escape_string($conn, $_POST['class_time']);
    $video_id = mysqli_real_escape_string($conn, $_POST['video_id']);

    // SQL query to add a new class
    $query = "INSERT INTO classes (class_name, class_time, video_id) VALUES (
        '" . mysqli_real_escape_string($conn, $class_name) . "',
        '" . mysqli_real_escape_string($conn, $class_time) . "',
        '" . mysqli_real_escape_string($conn, $video_id) . "')";

    // Execute query
    if ($conn->query($query) === TRUE) {
        set_message("New class added successfully", "success");
        header('Location: classes.php');
        exit();
    } else {
        $errors[] = 'Failed: ' . mysqli_error($conn);
    }
}
?>

<?php include '../reusable/header-admin.php'; ?>

<div class="container admin-container">
    <h1 class="admin-title">Add Class</h1>

    <?php
    // Show messages
    get_message();
    if (!empty($errors)) {
        echo '<div class="alert alert-danger">';
        foreach ($errors as $error) {
            echo '<p>' . htmlspecialchars($error) . '</p>';
        }
        echo '</div>';
    }
    ?>

    <form method="post" class="admin-form">
        <input type="hidden" name="addClass" value="1">
        <div class="mb-3">
            <label for="class_name" class="form-label">Class Name:</label>
            <input type="text" class="form-control" id="class_name" name="class_name" value="<?php echo htmlspecialchars($class_name); ?>" required>
        </div>
        <div class="mb-3">
            <label for="class_time" class="form-label">Class Time:</label>
            <input type="datetime-local" class="form-control" id="class_time" name="class_time" value="<?php echo htmlspecialchars($class_time); ?>" required>
        </div>
        <div class="mb-3">
            <label for="video_id" class="form-label">YouTube Video ID:</label>
            <input type="text" class="form-control" id="video_id" name="video_id" value="<?php echo htmlspecialchars($video_id); ?>" placeholder="Enter YouTube Video ID">
        </div>
        <button type="submit" class="btn btn-admin-primary">Add Class</button>
    </form>
</div>

<?php include '../reusable/footer-admin.php'; ?>
