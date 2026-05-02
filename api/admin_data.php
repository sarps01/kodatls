<?php
// =============================================================
// api/admin_data.php - TAM ADMIN API
// =============================================================
session_start();
require_once __DIR__.'/db.php';

header('Content-Type: application/json; charset=utf-8');

if(!isset($_SESSION['user_id'])||!in_array($_SESSION['user_role'],['admin','manager'])){
    jsonResponse(false,'Yetkisiz erişim',[],403);
}

$action=$_GET['action']??'';
$pdo=db();
$body=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $raw=file_get_contents('php://input');
    $body=json_decode($raw,true);
    if(!is_array($body))$body=$_POST;
}

$uid=$_SESSION['user_id'];
$uname=$_SESSION['user_name'];

switch($action){

// ══════════════════════════════════════════════════════════
// DASHBOARD
// ══════════════════════════════════════════════════════════
case 'dashboard_stats':
    $userCount=$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $adminCount=$pdo->query("SELECT COUNT(*) FROM users WHERE role IN('admin','manager')")->fetchColumn();
    $msgCount=$pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
    $unreadCount=$pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read=0")->fetchColumn();
    $starredCount=$pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_starred=1")->fetchColumn();
    $svcCount=$pdo->query("SELECT COUNT(*) FROM services WHERE is_active=1")->fetchColumn();
    $portCount=$pdo->query("SELECT COUNT(*) FROM portfolio WHERE is_active=1")->fetchColumn();
    $logCount=$pdo->query("SELECT COUNT(*) FROM activity_logs")->fetchColumn();
    jsonResponse(true,'OK',[
        'users'=>$userCount,'admins'=>$adminCount,
        'messages'=>$msgCount,'unread'=>$unreadCount,'starred'=>$starredCount,
        'services'=>$svcCount,'portfolio'=>$portCount,'logs'=>$logCount
    ]);
    break;

case 'recent_logs':
    $limit=(int)($_GET['limit']??20);
    $rows=$pdo->query("SELECT * FROM activity_logs ORDER BY id DESC LIMIT $limit")->fetchAll();
    jsonResponse(true,'OK',$rows);
    break;

// ══════════════════════════════════════════════════════════
// MESAJLAR
// ══════════════════════════════════════════════════════════
case 'messages':
    $limit=(int)($_GET['limit']??200);
    $filter=clean($_GET['filter']??'all');
    $search=clean($_GET['search']??'');
    $sql="SELECT * FROM contact_messages WHERE 1";
    $params=[];
    if($filter==='unread')  {$sql.=" AND is_read=0";}
    if($filter==='starred') {$sql.=" AND is_starred=1";}
    if($search){$sql.=" AND (name LIKE ? OR email LIKE ? OR subject LIKE ? OR message LIKE ?)";$s="%$search%";$params=[$s,$s,$s,$s];}
    $sql.=" ORDER BY id DESC LIMIT $limit";
    $stmt=$pdo->prepare($sql);$stmt->execute($params);
    jsonResponse(true,'OK',$stmt->fetchAll());
    break;

case 'get_message':
    $id=(int)($_GET['id']??0);
    $stmt=$pdo->prepare("SELECT * FROM contact_messages WHERE id=?");
    $stmt->execute([$id]);
    $row=$stmt->fetch();
    jsonResponse(true,'OK',$row?:[]);
    break;

case 'mark_read':
    $id=(int)($body['id']??0);
    $pdo->prepare("UPDATE contact_messages SET is_read=1 WHERE id=?")->execute([$id]);
    jsonResponse(true,'Okundu işaretlendi');
    break;

case 'mark_all_read':
    $pdo->query("UPDATE contact_messages SET is_read=1");
    logAction('mark_all_read','Tüm mesajlar okundu işaretlendi',$uid,$uname);
    jsonResponse(true,'Tümü okundu');
    break;

case 'toggle_star':
    $id=(int)($body['id']??0);
    $pdo->prepare("UPDATE contact_messages SET is_starred=IF(is_starred=1,0,1) WHERE id=?")->execute([$id]);
    jsonResponse(true,'OK');
    break;

case 'reply_message':
    $id=(int)($body['id']??0);
    $reply=clean($body['reply']??'');
    if(!$reply)jsonResponse(false,'Yanıt boş olamaz');
    $pdo->prepare("UPDATE contact_messages SET reply_text=?,replied_at=NOW(),is_read=1 WHERE id=?")
        ->execute([$reply,$id]);
    logAction('reply_message',"Mesaj #$id yanıtlandı",$uid,$uname);
    jsonResponse(true,'Yanıt kaydedildi');
    break;

case 'delete_message':
    $id=(int)($body['id']??0);
    $pdo->prepare("DELETE FROM contact_messages WHERE id=?")->execute([$id]);
    logAction('delete_message',"Mesaj #$id silindi",$uid,$uname);
    jsonResponse(true,'Mesaj silindi');
    break;

case 'bulk_delete_messages':
    $ids=$body['ids']??[];
    if(!is_array($ids)||empty($ids))jsonResponse(false,'ID listesi boş');
    $placeholders=implode(',',array_fill(0,count($ids),'?'));
    $pdo->prepare("DELETE FROM contact_messages WHERE id IN($placeholders)")->execute(array_map('intval',$ids));
    logAction('bulk_delete_messages',count($ids)." mesaj silindi",$uid,$uname);
    jsonResponse(true,count($ids)." mesaj silindi");
    break;

// ══════════════════════════════════════════════════════════
// KULLANICILAR & ADMİN YÖNETİMİ
// ══════════════════════════════════════════════════════════
case 'users':
    $limit=(int)($_GET['limit']??500);
    $role=clean($_GET['role']??'');
    $search=clean($_GET['search']??'');
    $sql="SELECT id,first_name,last_name,email,phone,company,role,is_active,last_login,created_at FROM users WHERE 1";
    $params=[];
    if($role){$sql.=" AND role=?";$params[]=$role;}
    if($search){$sql.=" AND (first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR company LIKE ?)";$s="%$search%";$params=array_merge($params,[$s,$s,$s,$s]);}
    $sql.=" ORDER BY id DESC LIMIT $limit";
    $stmt=$pdo->prepare($sql);$stmt->execute($params);
    jsonResponse(true,'OK',$stmt->fetchAll());
    break;

case 'get_user':
    $id=(int)($_GET['id']??0);
    $stmt=$pdo->prepare("SELECT id,first_name,last_name,email,phone,company,role,is_active FROM users WHERE id=?");
    $stmt->execute([$id]);
    jsonResponse(true,'OK',$stmt->fetch()?:[]);
    break;

case 'add_user':
    $fname=clean($body['first_name']??'');
    $lname=clean($body['last_name']??'');
    $email=filter_var($body['email']??'',FILTER_SANITIZE_EMAIL);
    $password=(string)($body['password']??'');
    $phone=clean($body['phone']??'');
    $company=clean($body['company']??'');
    $role=in_array($body['role']??'',['admin','manager','customer'])?$body['role']:'customer';

    if(strlen($fname)<2)jsonResponse(false,'Ad en az 2 karakter olmalı');
    if(!filter_var($email,FILTER_VALIDATE_EMAIL))jsonResponse(false,'Geçerli e-posta girin');
    if(strlen($password)<6)jsonResponse(false,'Şifre en az 6 karakter olmalı');

    $chk=$pdo->prepare("SELECT id FROM users WHERE email=?");
    $chk->execute([$email]);
    if($chk->fetch())jsonResponse(false,'Bu e-posta zaten kayıtlı');

    $hash=password_hash($password,PASSWORD_DEFAULT);
    $pdo->prepare("INSERT INTO users(first_name,last_name,email,password_hash,phone,company,role) VALUES(?,?,?,?,?,?,?)")
        ->execute([$fname,$lname,$email,$hash,$phone?:null,$company?:null,$role]);
    $newId=$pdo->lastInsertId();
    logAction('add_user',"Yeni kullanıcı: $fname $lname ($email) rol: $role",$uid,$uname);
    jsonResponse(true,'Kullanıcı eklendi',['id'=>$newId]);
    break;

case 'update_user':
    $id=(int)($body['id']??0);
    $fname=clean($body['first_name']??'');
    $lname=clean($body['last_name']??'');
    $email=filter_var($body['email']??'',FILTER_SANITIZE_EMAIL);
    $phone=clean($body['phone']??'');
    $company=clean($body['company']??'');
    $role=in_array($body['role']??'',['admin','manager','customer'])?$body['role']:'customer';
    $is_active=(int)($body['is_active']??1);

    if($id==$uid&&$role!=='admin'){
        jsonResponse(false,'Kendi rolünüzü değiştiremezsiniz');
    }

    $pdo->prepare("UPDATE users SET first_name=?,last_name=?,email=?,phone=?,company=?,role=?,is_active=?,updated_at=NOW() WHERE id=?")
        ->execute([$fname,$lname,$email,$phone?:null,$company?:null,$role,$is_active,$id]);

    // Şifre güncellemesi
    if(!empty($body['new_password'])&&strlen($body['new_password'])>=6){
        $hash=password_hash($body['new_password'],PASSWORD_DEFAULT);
        $pdo->prepare("UPDATE users SET password_hash=? WHERE id=?")->execute([$hash,$id]);
    }

    logAction('update_user',"Kullanıcı güncellendi: #$id $fname $lname",$uid,$uname);
    jsonResponse(true,'Kullanıcı güncellendi');
    break;

case 'toggle_user_status':
    $id=(int)($body['id']??0);
    if($id==$uid)jsonResponse(false,'Kendi hesabınızı pasif yapamazsınız');
    $pdo->prepare("UPDATE users SET is_active=IF(is_active=1,0,1) WHERE id=?")->execute([$id]);
    logAction('toggle_user',"Kullanıcı #$id durum değiştirildi",$uid,$uname);
    jsonResponse(true,'Durum güncellendi');
    break;

case 'delete_user':
    $id=(int)($body['id']??0);
    if($id==$uid)jsonResponse(false,'Kendi hesabınızı silemezsiniz');
    $pdo->prepare("DELETE FROM users WHERE id=?")->execute([$id]);
    logAction('delete_user',"Kullanıcı #$id silindi",$uid,$uname);
    jsonResponse(true,'Kullanıcı silindi');
    break;

case 'set_admin':
    $id=(int)($body['id']??0);
    $newRole=in_array($body['role']??'',['admin','manager','customer'])?$body['role']:'customer';
    if($id==$uid)jsonResponse(false,'Kendi rolünüzü değiştiremezsiniz');
    $pdo->prepare("UPDATE users SET role=? WHERE id=?")->execute([$newRole,$id]);
    logAction('set_role',"Kullanıcı #$id rolü: $newRole",$uid,$uname);
    jsonResponse(true,'Rol güncellendi');
    break;

// ══════════════════════════════════════════════════════════
// HİZMETLER
// ══════════════════════════════════════════════════════════
case 'services':
    jsonResponse(true,'OK',$pdo->query("SELECT * FROM services ORDER BY sort_order ASC")->fetchAll());
    break;

case 'get_service':
    $id=(int)($_GET['id']??0);
    $s=$pdo->prepare("SELECT * FROM services WHERE id=?");$s->execute([$id]);
    jsonResponse(true,'OK',$s->fetch()?:[]);
    break;

case 'add_service':
    $pdo->prepare("INSERT INTO services(icon,title,description,sort_order,is_active) VALUES(?,?,?,?,?)")
        ->execute([clean($body['icon']??'⚙️'),clean($body['title']??''),clean($body['description']??''),(int)($body['sort_order']??0),(int)($body['is_active']??1)]);
    logAction('add_service',"Hizmet eklendi: ".clean($body['title']??''),$uid,$uname);
    jsonResponse(true,'Hizmet eklendi');
    break;

case 'update_service':
    $id=(int)($body['id']??0);
    $pdo->prepare("UPDATE services SET icon=?,title=?,description=?,sort_order=?,is_active=? WHERE id=?")
        ->execute([clean($body['icon']??''),clean($body['title']??''),clean($body['description']??''),(int)($body['sort_order']??0),(int)($body['is_active']??1),$id]);
    logAction('update_service',"Hizmet güncellendi #$id",$uid,$uname);
    jsonResponse(true,'Hizmet güncellendi');
    break;

case 'delete_service':
    $id=(int)($body['id']??0);
    $pdo->prepare("DELETE FROM services WHERE id=?")->execute([$id]);
    logAction('delete_service',"Hizmet silindi #$id",$uid,$uname);
    jsonResponse(true,'Hizmet silindi');
    break;

// ══════════════════════════════════════════════════════════
// PORTFOLYO
// ══════════════════════════════════════════════════════════
case 'portfolio':
    jsonResponse(true,'OK',$pdo->query("SELECT * FROM portfolio ORDER BY id DESC")->fetchAll());
    break;

case 'get_portfolio':
    $id=(int)($_GET['id']??0);
    $s=$pdo->prepare("SELECT * FROM portfolio WHERE id=?");$s->execute([$id]);
    jsonResponse(true,'OK',$s->fetch()?:[]);
    break;

case 'add_portfolio':
    $pdo->prepare("INSERT INTO portfolio(emoji,title,category,description,bg_gradient,project_url,is_active) VALUES(?,?,?,?,?,?,?)")
        ->execute([clean($body['emoji']??'💼'),clean($body['title']??''),clean($body['category']??''),clean($body['description']??''),clean($body['bg_gradient']??''),clean($body['project_url']??''),(int)($body['is_active']??1)]);
    logAction('add_portfolio',"Proje eklendi: ".clean($body['title']??''),$uid,$uname);
    jsonResponse(true,'Proje eklendi');
    break;

case 'update_portfolio':
    $id=(int)($body['id']??0);
    $pdo->prepare("UPDATE portfolio SET emoji=?,title=?,category=?,description=?,bg_gradient=?,project_url=?,is_active=? WHERE id=?")
        ->execute([clean($body['emoji']??''),clean($body['title']??''),clean($body['category']??''),clean($body['description']??''),clean($body['bg_gradient']??''),clean($body['project_url']??''),(int)($body['is_active']??1),$id]);
    logAction('update_portfolio',"Proje güncellendi #$id",$uid,$uname);
    jsonResponse(true,'Proje güncellendi');
    break;

case 'delete_portfolio':
    $id=(int)($body['id']??0);
    $pdo->prepare("DELETE FROM portfolio WHERE id=?")->execute([$id]);
    logAction('delete_portfolio',"Proje silindi #$id",$uid,$uname);
    jsonResponse(true,'Proje silindi');
    break;

// ══════════════════════════════════════════════════════════
// AYARLAR
// ══════════════════════════════════════════════════════════
case 'get_settings':
    $rows=$pdo->query("SELECT setting_key,setting_value FROM site_settings")->fetchAll();
    $out=[];foreach($rows as $r)$out[$r['setting_key']]=$r['setting_value'];
    jsonResponse(true,'OK',$out);
    break;

case 'save_settings':
    $allowed=['site_name','site_slogan','site_desc','phone','email','address','maintenance',
        'color_primary','color_secondary','color_bg','color_card','color_text',
        'instagram','twitter','linkedin','github','youtube','whatsapp',
        'meta_title','meta_desc','meta_keywords','ga_id','favicon',
        'hero_title1','hero_title2','hero_desc','hero_btn1','hero_btn2',
        'stat1_num','stat1_text','stat2_num','stat2_text','stat3_num','stat3_text','stat4_num','stat4_text',
        'footer_text','ci_phone1','ci_phone2','ci_email1','ci_email2',
        'ci_address','ci_hours_wd','ci_hours_we','ci_maps'];
    $stmt=$pdo->prepare("INSERT INTO site_settings(setting_key,setting_value) VALUES(?,?) ON DUPLICATE KEY UPDATE setting_value=?");
    foreach($body as $k=>$v){
        if(in_array($k,$allowed)){$cv=clean($v);$stmt->execute([$k,$cv,$cv]);}
    }
    logAction('save_settings','Site ayarları güncellendi',$uid,$uname);
    jsonResponse(true,'Ayarlar kaydedildi');
    break;

// ══════════════════════════════════════════════════════════
// DUYURULAR
// ══════════════════════════════════════════════════════════
case 'announcements':
    jsonResponse(true,'OK',$pdo->query("SELECT * FROM announcements ORDER BY id DESC")->fetchAll());
    break;

case 'add_announcement':
    $pdo->prepare("INSERT INTO announcements(title,content,type,is_active) VALUES(?,?,?,?)")
        ->execute([clean($body['title']??''),clean($body['content']??''),clean($body['type']??'info'),(int)($body['is_active']??1)]);
    jsonResponse(true,'Duyuru eklendi');
    break;

case 'delete_announcement':
    $id=(int)($body['id']??0);
    $pdo->prepare("DELETE FROM announcements WHERE id=?")->execute([$id]);
    jsonResponse(true,'Duyuru silindi');
    break;

// ══════════════════════════════════════════════════════════
// SERVICE COUNT (dashboard için)
// ══════════════════════════════════════════════════════════
case 'service_count':
    $c=$pdo->query("SELECT COUNT(*) FROM services WHERE is_active=1")->fetchColumn();
    jsonResponse(true,'OK',['count'=>$c]);
    break;

default:
    jsonResponse(false,'Geçersiz işlem');
}