<?php
session_start();

if ($_SESSION['login'] != 'true') {
    header('Location: http://localhost/www/C-PeRA/admin/pages/login.php');

    exit;
}

if (isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];

if (isset($_SESSION['user_type']))
    $user_type = $_SESSION['user_type'];



// var_dump($user_id);
// var_dump($user_type);
