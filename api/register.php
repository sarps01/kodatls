<?php
session_start();
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Geçersiz istek türü', [], 405);
}

$data = getRequestData();

$first_name = clean($data['first_name'] ?? '');
$last_name = clean($data['last_name'] ?? '');
$email = trim($data['email'] ?? '');
$password = (string)($data['password'] ?? '');
$phone = clean($data['phone'] ?? '');
$company = clean($data['company'] ?? '');

if (mb_strlen($first_name) < 2) {
    jsonResponse(false, 'Ad en az 2 karakter olmalı');
}

if (mb_strlen($last_name) < 2) {
    jsonResponse(false, 'Soyad en az 2 karakter olmalı');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(false, 'Geçerli bir e-posta adresi girin');
}

if (strlen($password) < 6) {
    jsonResponse(false, 'Şifre en az 6 karakter olmalı');
}

$pdo = db();

$check = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
$check->execute([$email]);

if ($check->fetch()) {
    jsonResponse(false, 'Bu e-posta zaten kayıtlı');
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
    INSERT INTO users (first_name, last_name, email, password_hash, phone, company, role)
    VALUES (?, ?, ?, ?, ?, ?, 'customer')
");

$stmt->execute([
    $first_name,
    $last_name,
    $email,
    $password_hash,
    $phone ?: null,
    $company ?: null
]);

$userId = (int)$pdo->lastInsertId();

$_SESSION['user_id'] = $userId;
$_SESSION['user_name'] = $first_name . ' ' . $last_name;
$_SESSION['user_email'] = $email;
$_SESSION['user_role'] = 'customer';

jsonResponse(true, 'Kayıt başarılı', [
    'id' => $userId,
    'full_name' => $first_name . ' ' . $last_name,
    'email' => $email,
    'role' => 'customer'
]);