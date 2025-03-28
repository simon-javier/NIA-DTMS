<?php
$plain = "sysadmin";

// Create a password hash
$hashed_password = password_hash($plain, PASSWORD_DEFAULT);

// Output the hashed password
echo "Hashed Password: " . $hashed_password;
?>
