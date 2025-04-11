<?php
include '../reusable/connection.php';
include '../includes/functions.php';

// Check if 'member_id' is present in the URL
if (isset($_GET['member_id'])) {
    $member_id = mysqli_real_escape_string($conn, $_GET['member_id']);

    // Mark the allocation as deleted
    $sql = "UPDATE members SET allocation_deleted_at=NOW() WHERE member_id='$member_id'";

    if ($conn->query($sql) === TRUE) {
        set_message("Allocation deleted successfully", "success");
    } else {
        set_message("Error: " . $conn->error, "danger");
    }
} else {
    set_message("Error: 'member_id' parameter is missing.", "danger");
}

// Redirect to the allocation list page
header('Location: manageallocation.php');
exit();
?>
