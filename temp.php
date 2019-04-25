<?php
session_name("session_name");
session_start();

if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
    session_destroy();
    header("Location:login.php");
}

if (isset($_SESSION['admin'])) {
    unset($_SESSION['admin']);
    session_destroy();
    header("Location:admin.php");
}