<?php
session_start();
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Geçersiz istek türü', [], 405);
}

$data = getRequestData();

$email = trim($data['email'] ?? '');
$password = (string)($data['password'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(false, 'Geçerli bir e-posta girin');
}

if ($password === '') {
    jsonResponse(false, 'Şifre girin');
}

$pdo = db();

$stmt = $pdo->prepare("
    SELECT id, first_name, last_name, email, password_hash, role, is_active
    FROM users
    WHERE email = ?
    LIMIT 1
");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    jsonResponse(false, 'Kullanıcı bulunamadı');
}

if (!(int)$user['is_active']) {
    jsonResponse(false, 'Hesap pasif durumda');
}

if (!password_verify($password, $user['password_hash'])) {
    jsonResponse(false, 'Şifre yanlış');
}

session_regenerate_id(true);

$_SESSION['user_id'] = (int)$user['id'];
$_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['user_role'] = $user['role'];

jsonResponse(true, 'Giriş başarılı', [
    'id' => (int)$user['id'],
    'full_name' => $user['first_name'] . ' ' . $user['last_name'],
    'email' => $user['email'],
    'role' => $user['role']
]);