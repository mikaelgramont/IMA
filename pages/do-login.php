<?php
if (!isset($_POST['email']) || !isset($_POST['password'])) {
	$error = "Missing password or email";
	header("Location:" . BASE_URL . 'login?error='.urlencode($error));
	exit();
}

$identity = $_POST['email'];
$password = $_POST['password'];

Auth::saveAuthStatus($identity, Auth::validateAuth($identity, $password));

$redirect = isset($_POST['redirect-after-login']) ? $_POST['redirect-after-login'] : BASE_URL . 'admin';

if (Auth::hasAuth()) {
	header("Location: " . $redirect);
	exit();	
} else {
	$error = "Wrong password or email";	
	header("Location:" . BASE_URL . 'login?error='.urlencode($error));
	exit();
}