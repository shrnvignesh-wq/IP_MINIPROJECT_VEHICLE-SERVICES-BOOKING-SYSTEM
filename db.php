<?php
/* ============================================================
   Database Connection File (XAMPP defaults)
   Vehicle Services Booking System
   ------------------------------------------------------------
   XAMPP's MySQL/MariaDB ships with user "root" and NO password
   by default. If you set a root password in phpMyAdmin, update
   $db_pass below to match.
   ============================================================ */

$db_host = "localhost";
$db_user = "root";
$db_pass = "";                       // default XAMPP password is blank
$db_name = "vehicle_service_db";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
