<?php
include '../reusable/connection.php';
include '../includes/functions.php';
autoLogin();

if (isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = md5($_POST['password']); // Use password_hash() and password_verify() for better security

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        header('Location: ../admin/dashboard.php');
        exit();
    } else {
        set_message('Invalid username or password', 'danger');
        header('Location: ../admin/index.php');
        exit();
    }
}
?>
