<?php
include '../reusable/connection.php';
include '../includes/functions.php';

// Get and escape member_id from query parameter
$member_id = mysqli_real_escape_string($conn, $_GET['id']);

// Mark the member as deleted
$sql = "UPDATE members SET deleted_at=NOW() WHERE member_id='$member_id'";

if ($conn->query($sql) === TRUE) {
    set_message("Member deleted successfully", "success");
} else {
    set_message("Error: " . $conn->error, "danger");
}

// Redirect to members list page
header('Location: members.php');
exit();
?>
