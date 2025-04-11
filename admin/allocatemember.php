<?php
include '../reusable/connection.php';
include '../includes/functions.php';

// Fetch all classes
$classes_query = "SELECT class_id, class_name, class_time FROM classes";
$classes_result = $conn->query($classes_query);
$classes = $classes_result->fetch_all(MYSQLI_ASSOC);

// Check if member_id is in the URL
if (isset($_GET['member_id'])) {
    $member_id = mysqli_real_escape_string($conn, $_GET['member_id']);
    // Fetch member details
    $member_query = "SELECT member_id, name FROM members WHERE member_id='$member_id'";
    $member_result = $conn->query($member_query);
    $member = $member_result->fetch_assoc();
}
?>

<?php include '../reusable/header-admin.php'; ?>

<link rel="stylesheet" href="../reusable/css/admin-styles.css">
<style>
    .custom-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23333' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 12px 12px;
        padding-right: 2rem !important;
    }
</style>

<div class="container admin-container">
    <h1 class="admin-title text-center">Assign Member to a Class</h1>
    
    <?php get_message(); ?>
    
    <?php if (isset($member)): ?>
        <h2 class="text-center mb-4">Assign <?php echo htmlspecialchars($member['name']); ?> to a Class</h2>
        <form action="allocatemember.php" method="post" class="mx-auto" style="max-width: 500px;">
            <input type="hidden" name="member_id" value="<?php echo $member['member_id']; ?>">
            <div class="form-group">
                <label for="class">Select Class:</label>
                <select name="class_id" id="class" class="form-control custom-select" required>
                    <option value="" disabled selected>Choose a class</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?php echo $class['class_id']; ?>"><?php echo htmlspecialchars($class['class_name'] . ' at ' . $class['class_time']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-admin-primary btn-block">Assign</button>
            </div>
        </form>
    <?php else: ?>
        <p class="text-center">Member not found.</p>
    <?php endif; ?>

    <?php
    // Handle form submission
    if (isset($_POST['member_id']) && isset($_POST['class_id'])) {
        $member_id = mysqli_real_escape_string($conn, $_POST['member_id']);
        $class_id = mysqli_real_escape_string($conn, $_POST['class_id']);

        // Update member's class_id
        $update_query = "UPDATE members SET class_id='$class_id' WHERE member_id='$member_id'";

        if ($conn->query($update_query) === TRUE) {
            set_message("Member successfully assigned to the class.", "success");
            // Redirect to the main page
            header("Location: manageallocation.php");
            exit();
        } else {
            set_message("Error assigning member to the class: " . $conn->error, "danger");
        }
    }
    ?>
</div>

<?php include '../reusable/footer-admin.php'; ?>
