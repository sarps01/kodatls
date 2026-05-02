<?php
session_start();
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Geçersiz istek', [], 405);
}

$data = getRequestData();
$email = trim($data['email'] ?? '');
$first_name = clean($data['first_name'] ?? '');
$last_name = clean($data['last_name'] ?? '');
$phone = clean($data['phone'] ?? '');
$phone_country_code = clean($data['phone_country_code'] ?? '');
$company = clean($data['company'] ?? '');
$password = (string)($data['password'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(false, 'Geçerli bir e-posta adresi girin');
}
if (mb_strlen($first_name) < 2) jsonResponse(false, 'Ad en az 2 karakter olmalı');
if (mb_strlen($last_name) < 2) jsonResponse(false, 'Soyad en az 2 karakter olmalı');
if (strlen($password) < 6) jsonResponse(false, 'Şifre en az 6 karakter olmalı');

$pdo = db();
$check = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
$check->execute([$email]);
if ($check->fetch()) {
    jsonResponse(false, 'Bu e-posta zaten kayıtlı');
}

// Generate 6-digit code
$code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

// Store temp data
$tempData = json_encode([
    'first_name' => $first_name,
    'last_name' => $last_name,
    'email' => $email,
    'phone' => $phone,
    'phone_country_code' => $phone_country_code,
    'company' => $company,
    'password_hash' => password_hash($password, PASSWORD_DEFAULT)
]);

// Delete old codes for this email
$pdo->prepare("DELETE FROM email_verifications WHERE email = ?")->execute([$email]);

// Insert new code (expires in 15 minutes)
$stmt = $pdo->prepare("INSERT INTO email_verifications (email, code, temp_data, expires_at) VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL 15 MINUTE))");
$stmt->execute([$email, $code, $tempData]);

// Send email (using PHP mail - configure SMTP in production)
$subject = "KodAtlas - E-posta Doğrulama Kodu";
$body = "
<!DOCTYPE html>
<html>
<head><meta charset='UTF-8'></head>
<body style='font-family:Arial,sans-serif;background:#07111f;color:#ecf3ff;padding:40px;margin:0'>
<div style='max-width:480px;margin:auto;background:#0b1728;border:1px solid rgba(34,211,238,.2);border-radius:20px;padding:36px'>
  <div style='text-align:center;margin-bottom:28px'>
    <h1 style='font-size:28px;font-weight:900;color:#fff;margin:0'>Kod<span style='color:#22d3ee'>Atlas</span></h1>
    <p style='color:#94a3b8;font-size:14px;margin-top:6px'>Yazılım Şirketi</p>
  </div>
  <h2 style='font-size:22px;margin-bottom:12px;color:#ecf3ff'>E-posta Doğrulama</h2>
  <p style='color:#94a3b8;font-size:15px;margin-bottom:28px'>Kayıt işleminizi tamamlamak için aşağıdaki doğrulama kodunu girin:</p>
  <div style='background:rgba(34,211,238,.08);border:2px solid rgba(34,211,238,.3);border-radius:16px;padding:24px;text-align:center;margin-bottom:28px'>
    <span style='font-size:48px;font-weight:900;letter-spacing:12px;color:#22d3ee;font-family:monospace'>{$code}</span>
  </div>
  <p style='color:#94a3b8;font-size:13px;text-align:center'>Bu kod <strong style='color:#ecf3ff'>15 dakika</strong> geçerlidir.</p>
  <p style='color:#94a3b8;font-size:13px;text-align:center;margin-top:8px'>Eğer bu kaydı siz yapmadıysanız bu e-postayı görmezden gelin.</p>
  <hr style='border:none;border-top:1px solid rgba(255,255,255,.08);margin:24px 0'>
  <p style='color:#475569;font-size:12px;text-align:center'>© 2026 KodAtlas Yazılım Şirketi</p>
</div>
</body>
</html>
";

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "From: KodAtlas <noreply@kodatlas.com>\r\n";

$mailSent = mail($email, $subject, $body, $headers);

// In development, also return the code for testing
$devMode = !$mailSent; // If mail fails, we're likely in dev mode

jsonResponse(true, 'Doğrulama kodu e-posta adresinize gönderildi', [
    'email' => $email,
    'dev_code' => $devMode ? $code : null // Only show in dev when mail fails
]);