<?php
include('../includes/functions.php');
autoLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dance Studio Management - Login</title>
    <link rel="icon" href="../images/logo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../reusable/css/admin-styles.css">
</head>

<body>
    <div class="login-container">
        <div class="login-form">
            <h1 class="login-title text-center">Login</h1>
            <?php get_message(); ?>
            <form method="POST" action="../includes/login.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <button type="submit" class="btn btn-admin-primary w-100" name="login">Login</button>
            </form>
        </div>
    </div>
</body>

</html>
