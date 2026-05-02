<?php
session_start();
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Geçersiz istek', [], 405);
}

$data = getRequestData();
$email = trim($data['email'] ?? '');
$code = trim($data['code'] ?? '');

if (!$email || !$code) {
    jsonResponse(false, 'E-posta ve kod gerekli');
}

$pdo = db();

// Find valid code
$stmt = $pdo->prepare("SELECT * FROM email_verifications WHERE email = ? AND code = ? AND used = 0 AND expires_at > NOW() ORDER BY id DESC LIMIT 1");
$stmt->execute([$email, $code]);
$row = $stmt->fetch();

if (!$row) {
    jsonResponse(false, 'Geçersiz veya süresi dolmuş kod');
}

$tempData = json_decode($row['temp_data'], true);
if (!$tempData) {
    jsonResponse(false, 'Kayıt verisi bulunamadı');
}

// Check email not already registered
$check = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
$check->execute([$email]);
if ($check->fetch()) {
    jsonResponse(false, 'Bu e-posta zaten kayıtlı');
}

// Register user
$ins = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password_hash, phone, phone_country_code, company, role, email_verified) VALUES (?, ?, ?, ?, ?, ?, ?, 'customer', 1)");
$ins->execute([
    $tempData['first_name'],
    $tempData['last_name'],
    $email,
    $tempData['password_hash'],
    $tempData['phone'] ?: null,
    $tempData['phone_country_code'] ?: null,
    $tempData['company'] ?: null
]);

$userId = (int)$pdo->lastInsertId();

// Mark code as used
$pdo->prepare("UPDATE email_verifications SET used = 1 WHERE id = ?")->execute([$row['id']]);

// Start session
$_SESSION['user_id'] = $userId;
$_SESSION['user_name'] = $tempData['first_name'] . ' ' . $tempData['last_name'];
$_SESSION['user_email'] = $email;
$_SESSION['user_role'] = 'customer';

jsonResponse(true, 'Kayıt başarılı! Hoş geldiniz.', [
    'id' => $userId,
    'full_name' => $tempData['first_name'] . ' ' . $tempData['last_name'],
    'email' => $email,
    'role' => 'customer'
]);