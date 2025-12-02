<?php
// logout.php
// Destroys the session and sends the user back to the login page

session_start();
session_destroy(); // remove all session data
header("Location: index.php"); // back to login page
exit;
