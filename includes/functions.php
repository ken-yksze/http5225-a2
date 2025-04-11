<?php

define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/');

// Start the session
session_start();

/**
 * Check login status
 */
function secure() {
  if (!isset($_SESSION['id'])) {
      header('Location: ..index.php');
      exit;
  }
}

/**
 * Auto-login redirect
 */
function autoLogin()
{
  if (isset($_SESSION['id']) && isset($_SESSION['username']) && isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
    header('Location: ../admin/dashboard.php');
  }
}

/**
 * Set a session message
 *
 * @param string $message The message content
 * @param string $className The Bootstrap class for styling
 */
function set_message($message, $className)
{
  $_SESSION['message'] = $message;
  $_SESSION['className'] = $className;
}

/**
 * Display the session message
 */
function get_message()
{
  if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-' . $_SESSION['className'] . '" role="alert">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
    unset($_SESSION['className']);
  }
}
