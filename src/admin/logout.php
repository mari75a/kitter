<?php
session_start();
session_unset(); // clear all session variables
session_destroy(); // destroy the session
header("Location: ../index.php"); // redirect to login page
exit();
