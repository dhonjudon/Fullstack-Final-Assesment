<?php
// Check admin login (session_start() is called in the page that includes this)
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: _admin_login.php');
    exit;
}
