<?php

$password = "sample";
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo $hashedPassword;

?>