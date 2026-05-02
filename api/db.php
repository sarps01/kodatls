<?php
// =============================================================
// api/db.php
// =============================================================
function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=localhost;dbname=kodatlas;charset=utf8mb4',
                'root', '',
                [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                 PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
                 PDO::ATTR_EMULATE_PREPARES=>false]
            );
        } catch (PDOException $e) {
            jsonResponse(false,'Veritabanı bağlantı hatası',[],500);
        }
    }
    return $pdo;
}
function jsonResponse($s,$m,$d=[],$c=200):void{
    http_response_code($c);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success'=>$s,'message'=>$m,'data'=>$d],JSON_UNESCAPED_UNICODE);
    exit;
}
// api/db.php içindeki ilgili kısmı şöyle güncelle:
function getRequestData(): array {
    $json = json_decode(file_get_contents('php://input'), true);
    return is_array($json) ? $json : $_POST;
}
function clean($v):string{
    return htmlspecialchars(trim((string)$v),ENT_QUOTES,'UTF-8');
}
function logAction($action,$detail='',$userId=null,$userName=null):void{
    try{
        $pdo=db();
        $pdo->prepare("INSERT INTO activity_logs(user_id,user_name,action,detail,ip_address) VALUES(?,?,?,?,?)")
            ->execute([$userId,$userName,$action,$detail,$_SERVER['REMOTE_ADDR']??'']);
    }catch(Exception $e){}
}
?>