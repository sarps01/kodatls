<?php
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Geçersiz istek türü', [], 405);
}

$data = getRequestData();

$name = clean($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$phone = clean($data['phone'] ?? '');
$subject = clean($data['subject'] ?? '');
$message = clean($data['message'] ?? '');

if (mb_strlen($name) < 2) {
    jsonResponse(false, 'Ad soyad girin');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(false, 'Geçerli bir e-posta girin');
}

if (mb_strlen($message) < 5) {
    jsonResponse(false, 'Mesaj çok kısa');
}

$pdo = db();

$stmt = $pdo->prepare("
    INSERT INTO contact_messages (name, email, phone, subject, message)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->execute([
    $name,
    $email,
    $phone ?: null,
    $subject ?: null,
    $message
]);

jsonResponse(true, 'Mesajınız gönderildi');