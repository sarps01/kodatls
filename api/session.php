<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (isset($_SESSION['user_id'])) {
    echo json_encode([
        'logged_in' => true,
        'id' => $_SESSION['user_id'],
        'full_name' => $_SESSION['user_name'],
        'email' => $_SESSION['user_email'],
        'role' => $_SESSION['user_role']
    ], JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode([
        'logged_in' => false
    ], JSON_UNESCAPED_UNICODE);
}