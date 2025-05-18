<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

if ($email === 'cens.n469@gmail.com' && $password === '123cens469') {
    $_SESSION['admin'] = true;
    header('Location: admin.php');
} else {
    header('Location: login.php?error=1');
}
