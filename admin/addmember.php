<?php
include '../reusable/connection.php';
include '../includes/functions.php';

// Form data and error variables
$name = $email = $role = '';
$errors = [];

// Form submission check
if (isset($_POST['addMember'])) {
    // Escape POST variables
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $image = $_FILES['image']['name'];
    $target_dir = "../reusable/images/instructors/";
    $target_file = $target_dir . basename($image);

    // Create directory if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0775, true);
    }

    // Validate image upload
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // SQL query to add a new member
        $query = "INSERT INTO members (`name`, `email`, `role`, `image`) VALUES (
            '" . mysqli_real_escape_string($conn, $name) . "',
            '" . mysqli_real_escape_string($conn, $email) . "',
            '" . mysqli_real_escape_string($conn, $role) . "',
            '" . mysqli_real_escape_string($conn, $image) . "')";

        // Execute query
        if (mysqli_query($conn, $query)) {
            // Move uploaded file
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                set_message('New member created successfully!', 'success');
                header("Location: members.php");
                exit();
            } else {
                $errors[] = 'Failed to upload image. Check directory permissions.';
            }
        } else {
            $errors[] = 'Failed: ' . mysqli_error($conn);
        }
    } else {
        $errors[] = 'Image upload error: ' . $_FILES['image']['error'];
    }
}
?>

<?php include '../reusable/header-admin.php'; ?>

<div class="container admin-container">
    <h1 class="admin-title">Create Member</h1>

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

    <form method="post" enctype="multipart/form-data" class="admin-form">
        <input type="hidden" name="addMember" value="1">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role:</label>
            <select class="form-select" id="role" name="role" required>
                <option value="student" <?php if ($role == 'student') echo 'selected'; ?>>Student</option>
                <option value="instructor" <?php if ($role == 'instructor') echo 'selected'; ?>>Instructor</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>
        <button type="submit" class="btn btn-admin-primary">Create Member</button>
    </form>
</div>

<?php include '../reusable/footer-admin.php'; ?>
