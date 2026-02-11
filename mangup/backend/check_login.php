<?php
session_start();
header('Content-Type: application/json');

$response = [
    'logged_in' => false,
    'username' => ''
];

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    $response['logged_in'] = true;
    $response['username'] = $_SESSION['admin_username'];
}

echo json_encode($response);
?>