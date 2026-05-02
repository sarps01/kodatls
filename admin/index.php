<?php
// =============================================================
// admin/index.php - GELİŞMİŞ ADMİN PANELİ
// =============================================================
session_start();
if(!isset($_SESSION['user_id'])){header('Location: ../index.php');exit;}
if(!in_array($_SESSION['user_role'],['admin','manager'])){header('Location: ../index.php');exit;}
require_once __DIR__.'/../api/db.php';
$pdo=db();
$page=$_GET['page']??'dashboard';
$isAdmin=$_SESSION['user_role']==='admin';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>KodAtlas Admin Panel</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{
--bg:#07111f;--sidebar:#0b1728;--card:rgba(255,255,255,.05);--line:rgba(255,255,255,.08);
--text:#ecf3ff;--muted:#94a3b8;--cyan:#22d3ee;--blue:#3b82f6;
--green:#22c55e;--red:#ef4444;--yellow:#f59e0b;--purple:#8b5cf6;--orange:#f97316;
}
body{font-family:Arial,sans-serif;background:var(--bg);color:var(--text);display:flex;min-height:100vh}

/* SIDEBAR */
.sidebar{width:260px;min-height:100vh;background:var(--sidebar);border-right:1px solid var(--line);display:flex;flex-direction:column;position:fixed;top:0;left:0;z-index:40}
.sb-logo{padding:20px;border-bottom:1px solid var(--line);display:flex;align-items:center;gap:10px}
.sb-logo .ic{width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,var(--cyan),var(--blue));display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:900;color:#001018;flex-shrink:0}
.sb-logo span{font-size:17px;font-weight:800}
.sb-logo b{color:var(--cyan)}
.sb-nav{flex:1;padding:12px;overflow-y:auto;display:flex;flex-direction:column;gap:2px}
.sb-section{font-size:10px;font-weight:800;letter-spacing:2px;color:var(--muted);padding:10px 10px 4px;text-transform:uppercase}
.ni{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;color:var(--muted);font-size:14px;cursor:pointer;transition:.2s}
.ni:hover{background:rgba(255,255,255,.06);color:#fff}
.ni.active{background:linear-gradient(135deg,rgba(34,211,238,.15),rgba(59,130,246,.1));color:var(--cyan);border:1px solid rgba(34,211,238,.2)}
.ni .nic{font-size:16px;min-width:20px;text-align:center}
.ni .nb{margin-left:auto;background:var(--red);color:#fff;font-size:10px;font-weight:700;padding:2px 6px;border-radius:999px}
.sb-foot{padding:12px;border-top:1px solid var(--line)}
.sb-user{display:flex;align-items:center;gap:8px;padding:10px 12px;border-radius:10px;background:rgba(255,255,255,.04);border:1px solid var(--line)}
.av{width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--cyan),var(--blue));display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;color:#001018;flex-shrink:0}
.um{flex:1;min-width:0}
.um .un{font-size:13px;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.um .ur{font-size:11px;color:var(--muted)}
.lob{width:28px;height:28px;border:none;border-radius:7px;background:rgba(239,68,68,.15);color:var(--red);cursor:pointer;font-size:14px;flex-shrink:0}

/* MAIN */
.main{margin-left:260px;flex:1;display:flex;flex-direction:column}
.topbar{height:60px;background:rgba(7,17,31,.9);backdrop-filter:blur(10px);border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;padding:0 24px;position:sticky;top:0;z-index:30}
.topbar h1{font-size:17px;font-weight:700}
.tb-right{display:flex;align-items:center;gap:10px}
.tb-badge{padding:5px 12px;border-radius:999px;font-size:12px;font-weight:700}
.content{padding:24px;flex:1}

/* STAT GRID */
.sg{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:22px}
.sc{background:var(--card);border:1px solid var(--line);border-radius:18px;padding:20px;position:relative;overflow:hidden;transition:.25s;cursor:pointer}
.sc:hover{transform:translateY(-3px);border-color:rgba(34,211,238,.2)}
.sc .glow{position:absolute;top:-20px;right:-20px;width:80px;height:80px;border-radius:50%;opacity:.2;filter:blur(16px)}
.sc .sl{font-size:12px;color:var(--muted);margin-bottom:8px}
.sc .sn{font-size:32px;font-weight:800;line-height:1}
.sc .ss{font-size:11px;color:var(--muted);margin-top:5px}
.sc .si{font-size:24px;margin-bottom:8px}

/* PANEL */
.panel{background:var(--card);border:1px solid var(--line);border-radius:18px;overflow:hidden;margin-bottom:20px}
.ph{padding:16px 20px;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}
.ph h2{font-size:15px;font-weight:700}
.ph-right{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
.pb{padding:20px}

/* TABLE */
table{width:100%;border-collapse:collapse}
th{padding:11px 14px;text-align:left;font-size:11px;color:var(--muted);font-weight:700;text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid var(--line)}
td{padding:12px 14px;font-size:13px;border-bottom:1px solid rgba(255,255,255,.04);vertical-align:middle}
tr:last-child td{border-bottom:none}
tr:hover td{background:rgba(255,255,255,.02)}

/* BADGE */
.badge{display:inline-block;padding:3px 9px;border-radius:999px;font-size:11px;font-weight:700}
.bg-green{background:rgba(34,197,94,.1);color:var(--green)}
.bg-red{background:rgba(239,68,68,.1);color:var(--red)}
.bg-blue{background:rgba(59,130,246,.1);color:var(--blue)}
.bg-yellow{background:rgba(245,158,11,.1);color:var(--yellow)}
.bg-purple{background:rgba(139,92,246,.1);color:var(--purple)}
.bg-cyan{background:rgba(34,211,238,.1);color:var(--cyan)}
.bg-orange{background:rgba(249,115,22,.1);color:var(--orange)}

/* BTN */
.btn{display:inline-flex;align-items:center;gap:5px;padding:8px 16px;border-radius:9px;border:none;font-size:13px;font-weight:700;cursor:pointer;transition:.2s;text-decoration:none}
.btn:hover{opacity:.88;transform:translateY(-1px)}
.btn-pr{background:linear-gradient(135deg,var(--cyan),var(--blue));color:#001018}
.btn-out{background:transparent;border:1px solid var(--line);color:var(--text)}
.btn-out:hover{border-color:var(--cyan);color:var(--cyan)}
.btn-red{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);color:var(--red)}
.btn-green{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.2);color:var(--green)}
.btn-yellow{background:rgba(245,158,11,.1);border:1px solid rgba(245,158,11,.2);color:var(--yellow)}
.btn-purple{background:rgba(139,92,246,.1);border:1px solid rgba(139,92,246,.2);color:var(--purple)}
.btn-sm{padding:5px 11px;font-size:12px;border-radius:7px}

/* FORM */
.fg{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.fgroup{display:flex;flex-direction:column;gap:6px}
.fgroup.full{grid-column:1/-1}
label{font-size:12px;color:var(--muted);font-weight:700;text-transform:uppercase;letter-spacing:.5px}
.input{width:100%;padding:11px 13px;border-radius:11px;border:1px solid var(--line);background:rgba(255,255,255,.04);color:var(--text);outline:none;font-size:14px;transition:.2s}
.input:focus{border-color:var(--cyan);background:rgba(34,211,238,.04)}
textarea.input{min-height:90px;resize:vertical}
select.input option{background:#0f172a}

/* TABS */
.tabs{display:flex;gap:4px;border-bottom:1px solid var(--line);margin-bottom:20px;flex-wrap:wrap}
.tab{padding:9px 16px;font-size:13px;font-weight:600;cursor:pointer;border-bottom:2px solid transparent;color:var(--muted);transition:.2s}
.tab.active{border-bottom-color:var(--cyan);color:var(--cyan)}

/* MODAL */
.mbg{position:fixed;inset:0;background:rgba(0,0,0,.8);display:none;align-items:center;justify-content:center;padding:20px;z-index:200}
.mbg.show{display:flex}
.mbox{width:min(580px,100%);background:#0c1626;border:1px solid var(--line);border-radius:20px;padding:26px;box-shadow:0 30px 80px rgba(0,0,0,.6);max-height:90vh;overflow-y:auto}
.mh{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
.mh h3{font-size:18px;font-weight:800}
.cx{width:34px;height:34px;border:none;border-radius:50%;background:rgba(255,255,255,.06);color:var(--text);cursor:pointer;font-size:16px}

/* COLOR */
.cr{display:flex;align-items:center;gap:12px;padding:12px;background:rgba(255,255,255,.03);border-radius:10px;border:1px solid var(--line);margin-bottom:10px}
.cr label{flex:1;font-size:13px;color:var(--text);text-transform:none;letter-spacing:0}
input[type=color]{width:44px;height:32px;border:none;border-radius:7px;cursor:pointer;padding:0;background:none}

/* TOGGLE */
.tr{display:flex;align-items:center;justify-content:space-between;padding:12px 14px;background:rgba(255,255,255,.03);border-radius:10px;border:1px solid var(--line);margin-bottom:8px}
.ti{flex:1}.ti .tl{font-size:13px;font-weight:600}.ti .ts{font-size:11px;color:var(--muted);margin-top:2px}
.sw{position:relative;width:44px;height:24px;flex-shrink:0}
.sw input{display:none}
.sl{position:absolute;inset:0;border-radius:999px;background:rgba(255,255,255,.15);cursor:pointer;transition:.3s}
.sl::after{content:'';position:absolute;top:3px;left:3px;width:18px;height:18px;border-radius:50%;background:#fff;transition:.3s}
.sw input:checked+.sl{background:var(--cyan)}
.sw input:checked+.sl::after{transform:translateX(20px)}

/* TOAST */
.tw{position:fixed;right:18px;bottom:18px;z-index:999;display:flex;flex-direction:column;gap:8px;max-width:320px}
.toast{padding:13px 16px;border-radius:12px;background:#0f172a;border:1px solid var(--line);font-size:13px;box-shadow:0 10px 40px rgba(0,0,0,.4);animation:tin .3s ease}
@keyframes tin{from{opacity:0;transform:translateX(60px)}to{opacity:1;transform:translateX(0)}}
.toast.success{border-color:rgba(34,197,94,.3)}.toast.error{border-color:rgba(239,68,68,.3)}.toast.info{border-color:rgba(34,211,238,.3)}.toast.warning{border-color:rgba(245,158,11,.3)}

/* PAGE */
.psec{display:none}.psec.active{display:block}

/* MSG CARD */
.msg-card{background:rgba(255,255,255,.03);border:1px solid var(--line);border-radius:14px;padding:16px;margin-bottom:12px;transition:.2s}
.msg-card:hover{border-color:rgba(34,211,238,.2);background:rgba(34,211,238,.03)}
.msg-card.unread{border-left:3px solid var(--cyan)}
.msg-card.starred{border-left:3px solid var(--yellow)}
.msg-meta{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:8px}
.msg-actions{display:flex;gap:6px;margin-top:10px;flex-wrap:wrap}

/* SEARCH BAR */
.search-bar{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
.search-bar .input{padding:8px 12px;max-width:220px}

/* USER CARD */
.user-row-actions{display:flex;gap:5px;flex-wrap:wrap}

/* LOG */
.log-item{display:flex;gap:12px;padding:10px 0;border-bottom:1px solid rgba(255,255,255,.04)}
.log-item:last-child{border-bottom:none}
.log-time{font-size:11px;color:var(--muted);white-space:nowrap;min-width:120px}
.log-action{font-size:13px}
.log-detail{font-size:12px;color:var(--muted)}

/* EMPTY */
.empty{text-align:center;padding:40px;color:var(--muted)}
.empty .ei{font-size:48px;margin-bottom:12px}

/* RESP */
@media(max-width:1024px){.sg{grid-template-columns:1fr 1fr}}
@media(max-width:768px){.sidebar{display:none}.main{margin-left:0}.sg{grid-template-columns:1fr 1fr}.fg{grid-template-columns:1fr}}
</style>
</head>
<body>

<!-- ═══════════════════════════════ SIDEBAR ═══════════════════════════════ -->
<aside class="sidebar">
    <div class="sb-logo">
        <div class="ic">K</div>
        <span>Kod<b>Atlas</b> Admin</span>
    </div>

    <nav class="sb-nav">
        <div class="sb-section">Genel</div>
        <div class="ni active" onclick="goPage('dashboard')"><span class="nic">📊</span> Dashboard</div>
        <div class="ni" onclick="goPage('messages')"><span class="nic">✉️</span> Mesajlar <span class="nb" id="sb-unread" style="display:none">0</span></div>
        <div class="ni" onclick="goPage('livechat')"><span class="nic">💬</span> Canlı Destek <span class="nb" id="sb-chat-badge" style="display:none">0</span></div>
        <div class="ni" onclick="goPage('logs')"><span class="nic">📋</span> Aktivite Logu</div>

        <div class="sb-section">İçerik</div>
        <div class="ni" onclick="goPage('homepage')"><span class="nic">🏠</span> Ana Sayfa</div>
        <div class="ni" onclick="goPage('services')"><span class="nic">⚙️</span> Hizmetler</div>
        <div class="ni" onclick="goPage('portfolio')"><span class="nic">💼</span> Portfolyo</div>
        <div class="ni" onclick="goPage('announcements')"><span class="nic">📢</span> Duyurular</div>

        <div class="sb-section">Kullanıcı Yönetimi</div>
        <div class="ni" onclick="goPage('users')"><span class="nic">👥</span> Tüm Kullanıcılar</div>
        <div class="ni" onclick="goPage('admins')"><span class="nic">👑</span> Admin Yönetimi</div>

        <div class="sb-section">Ayarlar</div>
        <div class="ni" onclick="goPage('site_settings')"><span class="nic">🎨</span> Site Ayarları</div>
        <div class="ni" onclick="goPage('contact_settings')"><span class="nic">📍</span> İletişim</div>
        <div class="ni" onclick="goPage('seo_settings')"><span class="nic">🔍</span> SEO</div>
    </nav>

    <div class="sb-foot">
        <div class="sb-user">
            <div class="av"><?= strtoupper(substr($_SESSION['user_name'],0,1)) ?></div>
            <div class="um">
                <div class="un"><?= htmlspecialchars($_SESSION['user_name']) ?></div>
                <div class="ur"><?= $_SESSION['user_role'] === 'admin' ? '👑 Admin' : '🔧 Yönetici' ?></div>
            </div>
            <button class="lob" onclick="logoutAdmin()" title="Çıkış">⏻</button>
        </div>
        <a href="../index.php" class="btn btn-out" style="width:100%;justify-content:center;margin-top:8px;font-size:12px">← Siteye Dön</a>
    </div>
</aside>

<!-- ═══════════════════════════════ MAIN ═══════════════════════════════ -->
<div class="main">
    <div class="topbar">
        <h1 id="pageTitle">📊 Dashboard</h1>
        <div class="tb-right">
            <span class="tb-badge bg-cyan">v3.0</span>
            <span class="tb-badge <?= $isAdmin ? 'bg-red' : 'bg-purple' ?>"><?= $isAdmin ? '👑 Admin' : '🔧 Manager' ?></span>
        </div>
    </div>

    <div class="content">

    <!-- ══════════ DASHBOARD ══════════ -->
    <div class="psec active" id="page-dashboard">
        <div class="sg" id="statGrid">
            <div class="sc" onclick="goPage('users')"><div class="glow" style="background:var(--cyan)"></div><div class="si">👥</div><div class="sl">Toplam Kullanıcı</div><div class="sn" id="st-users" style="color:var(--cyan)">—</div><div class="ss">Kayıtlı üye</div></div>
            <div class="sc" onclick="goPage('admins')"><div class="glow" style="background:var(--red)"></div><div class="si">👑</div><div class="sl">Admin / Manager</div><div class="sn" id="st-admins" style="color:var(--red)">—</div><div class="ss">Yönetici sayısı</div></div>
            <div class="sc" onclick="goPage('messages')"><div class="glow" style="background:var(--green)"></div><div class="si">✉️</div><div class="sl">Toplam Mesaj</div><div class="sn" id="st-msg" style="color:var(--green)">—</div><div class="ss" id="st-unread-sub">okunmamış</div></div>
            <div class="sc" onclick="goPage('services')"><div class="glow" style="background:var(--purple)"></div><div class="si">⚙️</div><div class="sl">Hizmet / Proje</div><div class="sn" id="st-svc" style="color:var(--purple)">—</div><div class="ss">Aktif içerikler</div></div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
            <div class="panel">
                <div class="ph"><h2>✉️ Son Mesajlar</h2><button class="btn btn-out btn-sm" onclick="goPage('messages')">Tümü →</button></div>
                <table><thead><tr><th>Kişi</th><th>Konu</th><th>Tarih</th></tr></thead><tbody id="dash-msgs"><tr><td colspan="3" class="empty">Yükleniyor...</td></tr></tbody></table>
            </div>
            <div class="panel">
                <div class="ph"><h2>👥 Son Kullanıcılar</h2><button class="btn btn-out btn-sm" onclick="goPage('users')">Tümü →</button></div>
                <table><thead><tr><th>Ad</th><th>E-posta</th><th>Rol</th></tr></thead><tbody id="dash-users"><tr><td colspan="3" class="empty">Yükleniyor...</td></tr></tbody></table>
            </div>
        </div>

        <div class="panel" style="margin-top:20px">
            <div class="ph"><h2>📋 Son Aktiviteler</h2><button class="btn btn-out btn-sm" onclick="goPage('logs')">Tümü →</button></div>
            <div class="pb" id="dash-logs">Yükleniyor...</div>
        </div>
    </div>

    <!-- ══════════ MESAJLAR ══════════ -->
    <div class="psec" id="page-messages">
        <div class="panel">
            <div class="ph">
                <h2>✉️ Gelen Kutusu</h2>
                <div class="ph-right">
                    <div class="search-bar">
                        <input class="input" placeholder="Ara..." id="msgSearch" oninput="loadMessages()">
                        <select class="input" id="msgFilter" onchange="loadMessages()" style="max-width:130px">
                            <option value="all">Tümü</option>
                            <option value="unread">Okunmamış</option>
                            <option value="starred">Yıldızlı</option>
                        </select>
                    </div>
                    <button class="btn btn-out btn-sm" onclick="markAllRead()">✓ Tümü Okundu</button>
                    <button class="btn btn-red btn-sm" onclick="bulkDeleteMessages()">🗑️ Seçilenleri Sil</button>
                </div>
            </div>
            <div class="pb" id="messagesContainer">Yükleniyor...</div>
        </div>
    </div>

    <!-- ══════════ CANLI DESTEK ══════════ -->
    <div class="psec" id="page-livechat">
        <style>
        .chat-layout{display:grid;grid-template-columns:300px 1fr;gap:16px;height:calc(100vh - 140px)}
        .sessions-panel{background:var(--card);border:1px solid var(--line);border-radius:18px;overflow:hidden;display:flex;flex-direction:column}
        .sessions-header{padding:14px 16px;border-bottom:1px solid var(--line);font-size:14px;font-weight:700;display:flex;align-items:center;justify-content:space-between}
        .sessions-list{flex:1;overflow-y:auto;padding:8px}
        .session-item{padding:12px;border-radius:12px;cursor:pointer;transition:.2s;margin-bottom:4px;border:1px solid transparent}
        .session-item:hover{background:rgba(255,255,255,.04);border-color:var(--line)}
        .session-item.active{background:rgba(34,211,238,.08);border-color:rgba(34,211,238,.2)}
        .session-item .sname{font-size:14px;font-weight:700;display:flex;align-items:center;gap:6px}
        .session-item .slast{font-size:12px;color:var(--muted);margin-top:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .session-item .sbadge{margin-left:auto;background:var(--red);color:#fff;font-size:10px;font-weight:700;padding:2px 6px;border-radius:999px;flex-shrink:0}
        .session-waiting{display:inline-block;width:8px;height:8px;border-radius:50%;background:var(--yellow);animation:pulse 1.5s infinite;flex-shrink:0}
        .session-active{display:inline-block;width:8px;height:8px;border-radius:50%;background:var(--green);flex-shrink:0}
        .chat-area-panel{background:var(--card);border:1px solid var(--line);border-radius:18px;overflow:hidden;display:flex;flex-direction:column}
        .chat-area-header{padding:14px 18px;border-bottom:1px solid var(--line);display:flex;align-items:center;gap:12px}
        .chat-area-messages{flex:1;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:10px}
        .amsg{max-width:75%;padding:10px 14px;border-radius:14px;font-size:13px;line-height:1.5;animation:msgIn .25s ease}
        @keyframes msgIn{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
        .amsg.visitor{background:rgba(255,255,255,.06);border:1px solid var(--line);align-self:flex-start;border-bottom-left-radius:4px}
        .amsg.admin{background:linear-gradient(135deg,rgba(34,211,238,.15),rgba(59,130,246,.1));border:1px solid rgba(34,211,238,.2);align-self:flex-end;border-bottom-right-radius:4px}
        .amsg-time{font-size:10px;color:var(--muted);margin-top:4px;font-family:monospace}
        .chat-area-input{padding:14px;border-top:1px solid var(--line);display:flex;gap:8px}
        .chat-area-input textarea{flex:1;background:rgba(255,255,255,.04);border:1px solid var(--line);border-radius:10px;padding:10px 13px;color:var(--text);font-size:13px;outline:none;resize:none;height:60px;font-family:inherit;transition:.2s}
        .chat-area-input textarea:focus{border-color:var(--cyan)}
        .empty-chat{display:flex;align-items:center;justify-content:center;flex-direction:column;height:100%;color:var(--muted);gap:12px}
        .empty-chat .ei{font-size:56px}
        @media(max-width:768px){.chat-layout{grid-template-columns:1fr;height:auto}}
        </style>

        <div class="chat-layout">
            <!-- Sessions list -->
            <div class="sessions-panel">
                <div class="sessions-header">
                    💬 Aktif Sohbetler
                    <button class="btn btn-out btn-sm" onclick="loadChatSessions()">🔄</button>
                </div>
                <div class="sessions-list" id="adminSessionsList">
                    <div class="empty" style="padding:20px;font-size:13px">Yükleniyor...</div>
                </div>
            </div>

            <!-- Chat area -->
            <div class="chat-area-panel">
                <div id="adminChatEmpty" class="empty-chat">
                    <div class="ei">💬</div>
                    <div>Soldaki listeden bir sohbet seçin</div>
                    <div style="font-size:12px">Yeni sohbetler otomatik yenilenir</div>
                </div>
                <div id="adminChatActive" style="display:none;flex-direction:column;height:100%">
                    <div class="chat-area-header">
                        <div>
                            <div style="font-size:15px;font-weight:700" id="adminChatVisitorName">—</div>
                            <div style="font-size:12px;color:var(--muted)" id="adminChatVisitorEmail">—</div>
                        </div>
                        <div style="margin-left:auto;display:flex;gap:8px">
                            <button class="btn btn-red btn-sm" onclick="closeAdminChat()">✕ Kapat</button>
                        </div>
                    </div>
                    <div class="chat-area-messages" id="adminChatMessages"></div>
                    <div class="chat-area-input" id="adminChatInputArea">
                        <textarea id="adminChatInput" placeholder="Yanıt yazın... (Enter = gönder, Shift+Enter = yeni satır)" onkeydown="adminChatKeyDown(event)"></textarea>
                        <button class="btn btn-pr" onclick="sendAdminReply()" style="align-self:flex-end;height:40px">Gönder</button>
                    </div>
                    <div id="adminChatClosed" style="display:none;text-align:center;padding:12px;color:var(--muted);font-size:13px;border-top:1px solid var(--line)">
                        Bu sohbet kapatılmış.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ══════════ LOGS ══════════ -->
    <div class="psec" id="page-logs">
        <div class="panel">
            <div class="ph"><h2>📋 Aktivite Logu</h2><button class="btn btn-out btn-sm" onclick="loadLogs()">🔄 Yenile</button></div>
            <div class="pb" id="logsContainer">Yükleniyor...</div>
        </div>
    </div>

    <!-- ══════════ ANA SAYFA ══════════ -->
    <div class="psec" id="page-homepage">
        <div class="panel">
            <div class="ph"><h2>🏠 Ana Sayfa İçeriği</h2></div>
            <div class="pb">
                <form id="homepageForm">
                <div class="fg">
                    <div class="fgroup full"><label>Hero Başlık 1</label><input class="input" name="hero_title1" id="h_t1" placeholder="Resmi, güçlü ve modern"></div>
                    <div class="fgroup full"><label>Hero Başlık 2 (Gradient)</label><input class="input" name="hero_title2" id="h_t2" placeholder="yazılım çözümleri"></div>
                    <div class="fgroup full"><label>Hero Açıklama</label><textarea class="input" name="hero_desc" id="h_d"></textarea></div>
                    <div class="fgroup"><label>Buton 1</label><input class="input" name="hero_btn1" id="h_b1"></div>
                    <div class="fgroup"><label>Buton 2</label><input class="input" name="hero_btn2" id="h_b2"></div>
                    <div class="fgroup"><label>İstatistik 1 Sayı</label><input class="input" name="stat1_num" id="h_s1n"></div>
                    <div class="fgroup"><label>İstatistik 1 Metin</label><input class="input" name="stat1_text" id="h_s1t"></div>
                    <div class="fgroup"><label>İstatistik 2 Sayı</label><input class="input" name="stat2_num" id="h_s2n"></div>
                    <div class="fgroup"><label>İstatistik 2 Metin</label><input class="input" name="stat2_text" id="h_s2t"></div>
                    <div class="fgroup"><label>İstatistik 3 Sayı</label><input class="input" name="stat3_num" id="h_s3n"></div>
                    <div class="fgroup"><label>İstatistik 3 Metin</label><input class="input" name="stat3_text" id="h_s3t"></div>
                    <div class="fgroup"><label>İstatistik 4 Sayı</label><input class="input" name="stat4_num" id="h_s4n"></div>
                    <div class="fgroup"><label>İstatistik 4 Metin</label><input class="input" name="stat4_text" id="h_s4t"></div>
                    <div class="fgroup full"><label>Footer Metni</label><input class="input" name="footer_text" id="h_ft"></div>
                </div>
                <div style="margin-top:16px"><button type="submit" class="btn btn-pr">💾 Kaydet</button></div>
                </form>
            </div>
        </div>
    </div>

    <!-- ══════════ HİZMETLER ══════════ -->
    <div class="psec" id="page-services">
        <div class="panel">
            <div class="ph"><h2>⚙️ Hizmetler</h2><button class="btn btn-pr btn-sm" onclick="openSvcModal()">+ Yeni Hizmet</button></div>
            <table><thead><tr><th>İkon</th><th>Başlık</th><th>Açıklama</th><th>Sıra</th><th>Durum</th><th>İşlem</th></tr></thead>
            <tbody id="svcTable"><tr><td colspan="6" class="empty">Yükleniyor...</td></tr></tbody></table>
        </div>
    </div>

    <!-- ══════════ PORTFOLYO ══════════ -->
    <div class="psec" id="page-portfolio">
        <div class="panel">
            <div class="ph"><h2>💼 Portfolyo</h2><button class="btn btn-pr btn-sm" onclick="openPortModal()">+ Yeni Proje</button></div>
            <table><thead><tr><th>Emoji</th><th>Başlık</th><th>Kategori</th><th>Durum</th><th>İşlem</th></tr></thead>
            <tbody id="portTable"><tr><td colspan="5" class="empty">Yükleniyor...</td></tr></tbody></table>
        </div>
    </div>

    <!-- ══════════ DUYURULAR ══════════ -->
    <div class="psec" id="page-announcements">
        <div class="panel">
            <div class="ph"><h2>📢 Duyurular</h2><button class="btn btn-pr btn-sm" onclick="openModal('annModal')">+ Yeni Duyuru</button></div>
            <table><thead><tr><th>Başlık</th><th>Tür</th><th>Durum</th><th>Tarih</th><th>İşlem</th></tr></thead>
            <tbody id="annTable"><tr><td colspan="5" class="empty">Yükleniyor...</td></tr></tbody></table>
        </div>
    </div>

    <!-- ══════════ KULLANICILAR ══════════ -->
    <div class="psec" id="page-users">
        <div class="panel">
            <div class="ph">
                <h2>👥 Tüm Kullanıcılar</h2>
                <div class="ph-right">
                    <input class="input" style="max-width:180px" placeholder="Ara..." id="userSearch" oninput="loadUsers()">
                    <select class="input" id="userRoleFilter" onchange="loadUsers()" style="max-width:130px">
                        <option value="">Tüm Roller</option>
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                        <option value="customer">Müşteri</option>
                    </select>
                    <button class="btn btn-pr btn-sm" onclick="openAddUserModal('customer')">+ Kullanıcı Ekle</button>
                </div>
            </div>
            <table><thead><tr><th>ID</th><th>Ad Soyad</th><th>E-posta</th><th>Şirket</th><th>Rol</th><th>Durum</th><th>Kayıt</th><th>İşlem</th></tr></thead>
            <tbody id="usersTable"><tr><td colspan="8" class="empty">Yükleniyor...</td></tr></tbody></table>
        </div>
    </div>

    <!-- ══════════ ADMİN YÖNETİMİ ══════════ -->
    <div class="psec" id="page-admins">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">
            <div class="panel">
                <div class="ph"><h2>👑 Admin Ekle</h2></div>
                <div class="pb">
                    <form id="addAdminForm">
                    <div class="fg">
                        <div class="fgroup"><label>Ad</label><input class="input" name="first_name" placeholder="Ad" required></div>
                        <div class="fgroup"><label>Soyad</label><input class="input" name="last_name" placeholder="Soyad" required></div>
                        <div class="fgroup full"><label>E-posta</label><input class="input" type="email" name="email" placeholder="admin@kodatlas.com" required></div>
                        <div class="fgroup"><label>Şifre</label><input class="input" type="password" name="password" placeholder="Min. 6 karakter" required></div>
                        <div class="fgroup"><label>Telefon</label><input class="input" name="phone" placeholder="+90 555 ..."></div>
                        <div class="fgroup full"><label>Rol</label>
                            <select class="input" name="role">
                                <option value="admin">👑 Admin (Tam yetki)</option>
                                <option value="manager">🔧 Manager (Sınırlı yetki)</option>
                            </select>
                        </div>
                    </div>
                    <div style="margin-top:14px"><button type="submit" class="btn btn-pr">👑 Admin Ekle</button></div>
                    </form>
                </div>
            </div>
            <div class="panel">
                <div class="ph"><h2>📊 Admin Rolleri Hakkında</h2></div>
                <div class="pb">
                    <div style="display:flex;flex-direction:column;gap:12px">
                        <div style="padding:14px;background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:12px">
                            <div style="font-weight:700;color:var(--red);margin-bottom:6px">👑 Admin</div>
                            <div style="font-size:13px;color:var(--muted)">Tüm panele erişim, kullanıcı ekleme/silme, ayar değiştirme, diğer adminleri yönetme yetkisi.</div>
                        </div>
                        <div style="padding:14px;background:rgba(139,92,246,.08);border:1px solid rgba(139,92,246,.2);border-radius:12px">
                            <div style="font-weight:700;color:var(--purple);margin-bottom:6px">🔧 Manager</div>
                            <div style="font-size:13px;color:var(--muted)">İçerik yönetimi, mesaj okuma, portfolyo/hizmet ekleme. Admin ekleme ve silme yetkisi yok.</div>
                        </div>
                        <div style="padding:14px;background:rgba(59,130,246,.08);border:1px solid rgba(59,130,246,.2);border-radius:12px">
                            <div style="font-weight:700;color:var(--blue);margin-bottom:6px">👤 Customer</div>
                            <div style="font-size:13px;color:var(--muted)">Sadece siteyi kullanabilir. Admin paneline erişimi yoktur.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="ph"><h2>👑 Mevcut Admin & Yöneticiler</h2></div>
            <table><thead><tr><th>ID</th><th>Ad Soyad</th><th>E-posta</th><th>Rol</th><th>Durum</th><th>İşlem</th></tr></thead>
            <tbody id="adminsTable"><tr><td colspan="6" class="empty">Yükleniyor...</td></tr></tbody></table>
        </div>
    </div>

    <!-- ══════════ SİTE AYARLARI ══════════ -->
    <div class="psec" id="page-site_settings">
        <div class="panel">
            <div class="ph"><h2>🎨 Site Ayarları</h2></div>
            <div class="pb">
                <div class="tabs">
                    <div class="tab active" onclick="stab(this,'st-genel')">Genel</div>
                    <div class="tab" onclick="stab(this,'st-renk')">Renkler</div>
                    <div class="tab" onclick="stab(this,'st-sosyal')">Sosyal Medya</div>
                </div>

                <div id="st-genel" class="tab-content" style="display:block">
                    <form id="siteForm">
                    <div class="fg">
                        <div class="fgroup"><label>Site Adı</label><input class="input" name="site_name" id="ss_name"></div>
                        <div class="fgroup"><label>Slogan</label><input class="input" name="site_slogan" id="ss_slogan"></div>
                        <div class="fgroup full"><label>Açıklama</label><textarea class="input" name="site_desc" id="ss_desc" rows="2"></textarea></div>
                        <div class="fgroup"><label>Telefon</label><input class="input" name="phone" id="ss_phone"></div>
                        <div class="fgroup"><label>E-posta</label><input class="input" name="email" id="ss_email"></div>
                        <div class="fgroup full"><label>Adres</label><input class="input" name="address" id="ss_addr"></div>
                    </div>
                    <div class="tr" style="margin-top:14px">
                        <div class="ti"><div class="tl">Bakım Modu</div><div class="ts">Aktifken site ziyaretçilere bakım sayfası gösterir</div></div>
                        <label class="sw"><input type="checkbox" id="ss_maint" name="maintenance"><div class="sl"></div></label>
                    </div>
                    <div style="margin-top:14px"><button type="submit" class="btn btn-pr">💾 Kaydet</button></div>
                    </form>
                </div>

                <div id="st-renk" class="tab-content" style="display:none">
                    <form id="colorForm">
                    <div class="cr"><label>Ana Renk</label><input type="color" name="color_primary" id="cp1" value="#22d3ee"><span id="cp1v" style="font-size:12px;color:var(--muted)">#22d3ee</span></div>
                    <div class="cr"><label>İkincil Renk</label><input type="color" name="color_secondary" id="cp2" value="#3b82f6"><span id="cp2v" style="font-size:12px;color:var(--muted)">#3b82f6</span></div>
                    <div class="cr"><label>Arkaplan</label><input type="color" name="color_bg" id="cp3" value="#07111f"><span id="cp3v" style="font-size:12px;color:var(--muted)">#07111f</span></div>
                    <div style="margin-top:14px;display:flex;gap:8px">
                        <button type="submit" class="btn btn-pr">💾 Kaydet</button>
                        <button type="button" class="btn btn-out" onclick="resetColors()">🔄 Sıfırla</button>
                    </div>
                    </form>
                </div>

                <div id="st-sosyal" class="tab-content" style="display:none">
                    <form id="socialForm">
                    <div class="fg">
                        <div class="fgroup"><label>Instagram</label><input class="input" name="instagram" id="ss_ig"></div>
                        <div class="fgroup"><label>Twitter</label><input class="input" name="twitter" id="ss_tw"></div>
                        <div class="fgroup"><label>LinkedIn</label><input class="input" name="linkedin" id="ss_li"></div>
                        <div class="fgroup"><label>GitHub</label><input class="input" name="github" id="ss_gh"></div>
                        <div class="fgroup"><label>YouTube</label><input class="input" name="youtube" id="ss_yt"></div>
                        <div class="fgroup"><label>WhatsApp</label><input class="input" name="whatsapp" id="ss_wa"></div>
                    </div>
                    <div style="margin-top:14px"><button type="submit" class="btn btn-pr">💾 Kaydet</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ══════════ İLETİŞİM AYARLARI ══════════ -->
    <div class="psec" id="page-contact_settings">
        <div class="panel">
            <div class="ph"><h2>📍 İletişim Bilgileri</h2></div>
            <div class="pb">
                <form id="contactSettingsForm">
                <div class="fg">
                    <div class="fgroup"><label>Telefon 1</label><input class="input" name="ci_phone1" id="ci1"></div>
                    <div class="fgroup"><label>Telefon 2</label><input class="input" name="ci_phone2" id="ci2"></div>
                    <div class="fgroup"><label>E-posta 1</label><input class="input" name="ci_email1" id="ci3"></div>
                    <div class="fgroup"><label>E-posta 2</label><input class="input" name="ci_email2" id="ci4"></div>
                    <div class="fgroup full"><label>Adres</label><textarea class="input" name="ci_address" id="ci5" rows="2"></textarea></div>
                    <div class="fgroup"><label>Hafta İçi Saatler</label><input class="input" name="ci_hours_wd" id="ci6"></div>
                    <div class="fgroup"><label>Hafta Sonu Saatler</label><input class="input" name="ci_hours_we" id="ci7"></div>
                    <div class="fgroup full"><label>Google Maps Embed URL</label><input class="input" name="ci_maps" id="ci8"></div>
                </div>
                <div style="margin-top:14px"><button type="submit" class="btn btn-pr">💾 Kaydet</button></div>
                </form>
            </div>
        </div>
    </div>

    <!-- ══════════ SEO ══════════ -->
    <div class="psec" id="page-seo_settings">
        <div class="panel">
            <div class="ph"><h2>🔍 SEO Ayarları</h2></div>
            <div class="pb">
                <form id="seoForm">
                <div class="fg">
                    <div class="fgroup full"><label>Meta Title</label><input class="input" name="meta_title" id="se1"></div>
                    <div class="fgroup full"><label>Meta Description</label><textarea class="input" name="meta_desc" id="se2" rows="2"></textarea></div>
                    <div class="fgroup full"><label>Meta Keywords</label><input class="input" name="meta_keywords" id="se3"></div>
                    <div class="fgroup"><label>Google Analytics ID</label><input class="input" name="ga_id" id="se4" placeholder="G-XXXXXXXXXX"></div>
                    <div class="fgroup"><label>Favicon URL</label><input class="input" name="favicon" id="se5" placeholder="/favicon.ico"></div>
                </div>
                <div style="margin-top:14px"><button type="submit" class="btn btn-pr">💾 Kaydet</button></div>
                </form>
            </div>
        </div>
    </div>

    </div><!-- /content -->
</div><!-- /main -->

<!-- ═══════════════════════════════ MODALS ═══════════════════════════════ -->

<!-- Hizmet Modal -->
<div class="mbg" id="svcModal">
    <div class="mbox">
        <div class="mh"><h3 id="svcModalT">Hizmet</h3><button class="cx" onclick="closeModal('svcModal')">✕</button></div>
        <form id="svcForm">
        <input type="hidden" name="id" id="sf_id">
        <div class="fg">
            <div class="fgroup"><label>İkon (Emoji)</label><input class="input" name="icon" id="sf_ic" placeholder="🌐" required></div>
            <div class="fgroup"><label>Sıra No</label><input class="input" type="number" name="sort_order" id="sf_so" value="0"></div>
            <div class="fgroup full"><label>Başlık</label><input class="input" name="title" id="sf_ti" required></div>
            <div class="fgroup full"><label>Açıklama</label><textarea class="input" name="description" id="sf_de" rows="3" required></textarea></div>
            <div class="fgroup"><label>Durum</label><select class="input" name="is_active" id="sf_ac"><option value="1">Aktif</option><option value="0">Pasif</option></select></div>
        </div>
        <div style="margin-top:14px;display:flex;gap:8px"><button type="submit" class="btn btn-pr">💾 Kaydet</button><button type="button" class="btn btn-out" onclick="closeModal('svcModal')">İptal</button></div>
        </form>
    </div>
</div>

<!-- Portfolyo Modal -->
<div class="mbg" id="portModal">
    <div class="mbox">
        <div class="mh"><h3 id="portModalT">Proje</h3><button class="cx" onclick="closeModal('portModal')">✕</button></div>
        <form id="portForm">
        <input type="hidden" name="id" id="pf_id">
        <div class="fg">
            <div class="fgroup"><label>Emoji</label><input class="input" name="emoji" id="pf_em" placeholder="🏢" required></div>
            <div class="fgroup"><label>Kategori</label><input class="input" name="category" id="pf_ca" placeholder="Kurumsal" required></div>
            <div class="fgroup full"><label>Proje Adı</label><input class="input" name="title" id="pf_ti" required></div>
            <div class="fgroup full"><label>Açıklama</label><textarea class="input" name="description" id="pf_de" rows="3" required></textarea></div>
            <div class="fgroup"><label>Arka Plan (CSS)</label><input class="input" name="bg_gradient" id="pf_bg" placeholder="linear-gradient(...)"></div>
            <div class="fgroup"><label>URL (opsiyonel)</label><input class="input" name="project_url" id="pf_ur"></div>
            <div class="fgroup"><label>Durum</label><select class="input" name="is_active" id="pf_ac"><option value="1">Aktif</option><option value="0">Pasif</option></select></div>
        </div>
        <div style="margin-top:14px;display:flex;gap:8px"><button type="submit" class="btn btn-pr">💾 Kaydet</button><button type="button" class="btn btn-out" onclick="closeModal('portModal')">İptal</button></div>
        </form>
    </div>
</div>

<!-- Kullanıcı Ekle/Düzenle Modal -->
<div class="mbg" id="userModal">
    <div class="mbox">
        <div class="mh"><h3 id="userModalT">Kullanıcı</h3><button class="cx" onclick="closeModal('userModal')">✕</button></div>
        <form id="userForm">
        <input type="hidden" name="id" id="uf_id">
        <div class="fg">
            <div class="fgroup"><label>Ad</label><input class="input" name="first_name" id="uf_fn" required></div>
            <div class="fgroup"><label>Soyad</label><input class="input" name="last_name" id="uf_ln" required></div>
            <div class="fgroup"><label>E-posta</label><input class="input" type="email" name="email" id="uf_em" required></div>
            <div class="fgroup"><label>Telefon</label><input class="input" name="phone" id="uf_ph"></div>
            <div class="fgroup"><label>Şirket</label><input class="input" name="company" id="uf_co"></div>
            <div class="fgroup"><label>Yeni Şifre (boş=değişmez)</label><input class="input" type="password" name="new_password" id="uf_pw" placeholder="En az 6 karakter"></div>
            <div class="fgroup"><label>Rol</label><select class="input" name="role" id="uf_ro"><option value="customer">Müşteri</option><option value="manager">Manager</option><option value="admin">Admin</option></select></div>
            <div class="fgroup"><label>Durum</label><select class="input" name="is_active" id="uf_ac"><option value="1">Aktif</option><option value="0">Pasif</option></select></div>
        </div>
        <div style="margin-top:14px;display:flex;gap:8px"><button type="submit" class="btn btn-pr">💾 Kaydet</button><button type="button" class="btn btn-out" onclick="closeModal('userModal')">İptal</button></div>
        </form>
    </div>
</div>

<!-- Mesaj Detay Modal -->
<div class="mbg" id="msgModal">
    <div class="mbox">
        <div class="mh"><h3>✉️ Mesaj Detayı</h3><button class="cx" onclick="closeModal('msgModal')">✕</button></div>
        <div id="msgModalContent"></div>
    </div>
</div>

<!-- Duyuru Modal -->
<div class="mbg" id="annModal">
    <div class="mbox">
        <div class="mh"><h3>📢 Duyuru Ekle</h3><button class="cx" onclick="closeModal('annModal')">✕</button></div>
        <form id="annForm">
        <div class="fg">
            <div class="fgroup full"><label>Başlık</label><input class="input" name="title" required></div>
            <div class="fgroup full"><label>İçerik</label><textarea class="input" name="content" rows="4" required></textarea></div>
            <div class="fgroup"><label>Tür</label><select class="input" name="type"><option value="info">ℹ️ Bilgi</option><option value="success">✅ Başarı</option><option value="warning">⚠️ Uyarı</option><option value="danger">🚨 Tehlike</option></select></div>
            <div class="fgroup"><label>Durum</label><select class="input" name="is_active"><option value="1">Aktif</option><option value="0">Pasif</option></select></div>
        </div>
        <div style="margin-top:14px;display:flex;gap:8px"><button type="submit" class="btn btn-pr">💾 Kaydet</button><button type="button" class="btn btn-out" onclick="closeModal('annModal')">İptal</button></div>
        </form>
    </div>
</div>

<div class="tw" id="toastWrap"></div>

<script>
// ════════════════════════════════════════════════════════
// YARDIMCI FONKSİYONLAR
// ════════════════════════════════════════════════════════
function esc(s){if(!s)return'';return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;')}
function showToast(m,t='info'){const w=document.getElementById('toastWrap');const d=document.createElement('div');d.className='toast '+t;d.innerHTML=m;w.appendChild(d);setTimeout(()=>{d.style.opacity='0';d.style.transition='.3s';setTimeout(()=>d.remove(),300)},3500)}
function openModal(id){document.getElementById(id).classList.add('show')}
function closeModal(id){document.getElementById(id).classList.remove('show')}
document.querySelectorAll('.mbg').forEach(m=>m.addEventListener('click',e=>{if(e.target===m)m.classList.remove('show')}));
async function api(endpoint,method='GET',data=null){
    const opts={method,headers:{'Content-Type':'application/json'}};
    if(data)opts.body=JSON.stringify(data);
    const res=await fetch('../api/'+endpoint,opts);
    return await res.json();
}
function setv(id,v){const e=document.getElementById(id);if(e&&v!==undefined&&v!==null)e.value=v}
function getv(id){const e=document.getElementById(id);return e?e.value:''}
function roleBadge(r){
    if(r==='admin')return'bg-red';
    if(r==='manager')return'bg-purple';
    return'bg-blue';
}
function roleLabel(r){
    if(r==='admin')return'👑 Admin';
    if(r==='manager')return'🔧 Manager';
    return'👤 Müşteri';
}

// Tab
function stab(el,id){
    el.closest('.pb').querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
    el.classList.add('active');
    el.closest('.pb').querySelectorAll('.tab-content').forEach(c=>c.style.display='none');
    document.getElementById(id).style.display='block';
}

// ════════════════════════════════════════════════════════
// SAYFA YÖNETİMİ
// ════════════════════════════════════════════════════════
const pageTitles={
    dashboard:'📊 Dashboard',messages:'✉️ Mesajlar',logs:'📋 Aktivite Logu',
    homepage:'🏠 Ana Sayfa',services:'⚙️ Hizmetler',portfolio:'💼 Portfolyo',
    announcements:'📢 Duyurular',users:'👥 Kullanıcılar',admins:'👑 Admin Yönetimi',
    site_settings:'🎨 Site Ayarları',contact_settings:'📍 İletişim',seo_settings:'🔍 SEO'
};

function goPage(p){
    document.querySelectorAll('.psec').forEach(s=>s.classList.remove('active'));
    document.getElementById('page-'+p)?.classList.add('active');
    document.querySelectorAll('.ni').forEach(n=>n.classList.remove('active'));
    document.querySelectorAll('.ni').forEach(n=>{
        const oc=n.getAttribute('onclick')||'';
        if(oc.includes("'"+p+"'")||oc.includes('"'+p+'"'))n.classList.add('active');
    });
    document.getElementById('pageTitle').textContent=pageTitles[p]||p;
    history.pushState({},'','?page='+p);
    loadPage(p);
}

function loadPage(p){
    if(p==='dashboard')loadDashboard();
    else if(p==='messages')loadMessages();
    else if(p==='logs')loadLogs();
    else if(p==='services')loadServices();
    else if(p==='portfolio')loadPortfolio();
    else if(p==='users')loadUsers();
    else if(p==='admins')loadAdmins();
    else if(p==='announcements')loadAnnouncements();
    else if(p==='homepage'||p==='site_settings'||p==='contact_settings'||p==='seo_settings')loadSettings();
}

// ════════════════════════════════════════════════════════
// DASHBOARD
// ════════════════════════════════════════════════════════
async function loadDashboard(){
    const r=await api('admin_data.php?action=dashboard_stats');
    if(r.success){
        document.getElementById('st-users').textContent=r.data.users;
        document.getElementById('st-admins').textContent=r.data.admins;
        document.getElementById('st-msg').textContent=r.data.messages;
        document.getElementById('st-unread-sub').textContent=r.data.unread+' okunmamış';
        document.getElementById('st-svc').textContent=r.data.services+' / '+r.data.portfolio;
        const nb=document.getElementById('sb-unread');
        if(r.data.unread>0){nb.style.display='inline';nb.textContent=r.data.unread;}
        else{nb.style.display='none';}
    }
    // Son mesajlar
    const m=await api('admin_data.php?action=messages&limit=5');
    const mb=document.getElementById('dash-msgs');
    if(m.success&&m.data.length>0){
        mb.innerHTML=m.data.map(x=>`<tr>
            <td>${x.is_read=='0'?'<span class="badge bg-cyan" style="font-size:10px">Yeni</span> ':''}<strong>${esc(x.name)}</strong></td>
            <td style="color:var(--muted)">${esc(x.subject||'—')}</td>
            <td style="color:var(--muted);font-size:11px">${x.created_at}</td>
        </tr>`).join('');
    }else{mb.innerHTML='<tr><td colspan="3" style="text-align:center;padding:16px;color:var(--muted)">Mesaj yok</td></tr>';}
    // Son kullanıcılar
    const u=await api('admin_data.php?action=users&limit=5');
    const ub=document.getElementById('dash-users');
    if(u.success&&u.data.length>0){
        ub.innerHTML=u.data.map(x=>`<tr>
            <td><strong>${esc(x.first_name)} ${esc(x.last_name)}</strong></td>
            <td style="color:var(--muted)">${esc(x.email)}</td>
            <td><span class="badge ${roleBadge(x.role)}">${roleLabel(x.role)}</span></td>
        </tr>`).join('');
    }else{ub.innerHTML='<tr><td colspan="3" style="text-align:center;padding:16px;color:var(--muted)">Kullanıcı yok</td></tr>';}
    // Loglar
    loadLogsInto('dash-logs',8);
}

// ════════════════════════════════════════════════════════
// MESAJLAR
// ════════════════════════════════════════════════════════
let selectedMsgIds=[];
async function loadMessages(){
    const filter=getv('msgFilter')||'all';
    const search=getv('msgSearch')||'';
    const r=await api(`admin_data.php?action=messages&filter=${filter}&search=${encodeURIComponent(search)}`);
    const c=document.getElementById('messagesContainer');
    if(!r.success||r.data.length===0){
        c.innerHTML='<div class="empty"><div class="ei">📭</div><p>Mesaj bulunamadı</p></div>';
        return;
    }
    selectedMsgIds=[];
    c.innerHTML=`
    <div style="margin-bottom:12px;display:flex;align-items:center;gap:8px;font-size:13px;color:var(--muted)">
        <label><input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)"> Tümünü Seç</label>
        <span>${r.data.length} mesaj</span>
    </div>
    `+r.data.map(m=>`
    <div class="msg-card ${m.is_read=='0'?'unread':''} ${m.is_starred=='1'?'starred':''}" id="msg-${m.id}">
        <div style="display:flex;align-items:flex-start;gap:10px">
            <input type="checkbox" class="msg-cb" value="${m.id}" onchange="toggleMsgSelect(this)">
            <div style="flex:1">
                <div class="msg-meta">
                    ${m.is_read=='0'?'<span class="badge bg-cyan">Yeni</span>':''}
                    ${m.is_starred=='1'?'<span style="color:var(--yellow)">⭐</span>':''}
                    <strong>${esc(m.name)}</strong>
                    <span style="color:var(--muted)">&lt;${esc(m.email)}&gt;</span>
                    ${m.phone?`<span style="color:var(--muted)">📞 ${esc(m.phone)}</span>`:''}
                    <span style="color:var(--muted);font-size:11px;margin-left:auto">${m.created_at}</span>
                </div>
                ${m.subject?`<div style="font-weight:700;margin-bottom:4px">${esc(m.subject)}</div>`:''}
                <div style="color:var(--muted);font-size:13px">${esc(m.message).substring(0,150)}${m.message.length>150?'...':''}</div>
                ${m.reply_text?`<div style="margin-top:8px;padding:8px;background:rgba(34,211,238,.06);border-radius:8px;font-size:12px;color:var(--cyan)">✅ Yanıtlandı: ${esc(m.reply_text).substring(0,80)}...</div>`:''}
                <div class="msg-actions">
                    <button class="btn btn-out btn-sm" onclick="viewMessage(${m.id})">👁️ Detay</button>
                    <button class="btn btn-yellow btn-sm" onclick="toggleStar(${m.id})">⭐ ${m.is_starred=='1'?'Yıldızı Kaldır':'Yıldızla'}</button>
                    <button class="btn btn-red btn-sm" onclick="deleteMessage(${m.id})">🗑️ Sil</button>
                </div>
            </div>
        </div>
    </div>`).join('');
}

function toggleSelectAll(cb){
    document.querySelectorAll('.msg-cb').forEach(c=>{
        c.checked=cb.checked;
        const id=parseInt(c.value);
        if(cb.checked){if(!selectedMsgIds.includes(id))selectedMsgIds.push(id);}
        else{selectedMsgIds=selectedMsgIds.filter(x=>x!==id);}
    });
}

function toggleMsgSelect(cb){
    const id=parseInt(cb.value);
    if(cb.checked){if(!selectedMsgIds.includes(id))selectedMsgIds.push(id);}
    else{selectedMsgIds=selectedMsgIds.filter(x=>x!==id);}
}

async function viewMessage(id){
    const r=await api('admin_data.php?action=get_message&id='+id);
    if(!r.success)return;
    const m=r.data;
    document.getElementById('msgModalContent').innerHTML=`
    <div class="fg" style="margin-bottom:16px">
        <div><label>Ad Soyad</label><div style="padding:8px 0;font-weight:700">${esc(m.name)}</div></div>
        <div><label>E-posta</label><div style="padding:8px 0;color:var(--muted)">${esc(m.email)}</div></div>
        <div><label>Telefon</label><div style="padding:8px 0;color:var(--muted)">${esc(m.phone||'—')}</div></div>
        <div><label>Konu</label><div style="padding:8px 0">${esc(m.subject||'—')}</div></div>
        <div class="full"><label>Mesaj</label><div style="padding:12px;background:rgba(255,255,255,.04);border-radius:10px;margin-top:6px;line-height:1.7">${esc(m.message)}</div></div>
        <div><label>Tarih</label><div style="padding:8px 0;color:var(--muted);font-size:12px">${m.created_at}</div></div>
        <div><label>IP Adresi</label><div style="padding:8px 0;color:var(--muted);font-size:12px">${m.ip_address||'—'}</div></div>
    </div>
    ${m.reply_text?`<div style="padding:12px;background:rgba(34,211,238,.06);border:1px solid rgba(34,211,238,.2);border-radius:10px;margin-bottom:16px"><strong style="color:var(--cyan)">Yanıt:</strong><br>${esc(m.reply_text)}</div>`:''}
    <div>
        <label>Yanıt Yaz</label>
        <textarea class="input" id="replyText" rows="3" style="margin-top:6px" placeholder="Yanıt metni...">${esc(m.reply_text||'')}</textarea>
        <div style="margin-top:10px;display:flex;gap:8px">
            <button class="btn btn-pr" onclick="replyMessage(${m.id})">✉️ Yanıtı Kaydet</button>
            <button class="btn btn-red btn-sm" onclick="deleteMessage(${m.id});closeModal('msgModal')">🗑️ Sil</button>
        </div>
    </div>`;
    openModal('msgModal');
    if(m.is_read=='0'){await api('admin_data.php?action=mark_read','POST',{id});loadDashboard();}
}

async function replyMessage(id){
    const reply=document.getElementById('replyText').value;
    if(!reply.trim()){showToast('Yanıt boş olamaz','error');return;}
    const r=await api('admin_data.php?action=reply_message','POST',{id,reply});
    if(r.success){showToast('Yanıt kaydedildi','success');closeModal('msgModal');loadMessages();}
    else showToast(r.message,'error');
}

async function toggleStar(id){
    await api('admin_data.php?action=toggle_star','POST',{id});
    loadMessages();
}

async function deleteMessage(id){
    if(!confirm('Bu mesajı silmek istediğinize emin misiniz?'))return;
    const r=await api('admin_data.php?action=delete_message','POST',{id});
    if(r.success){showToast('Mesaj silindi','success');loadMessages();loadDashboard();}
    else showToast(r.message,'error');
}

async function markAllRead(){
    const r=await api('admin_data.php?action=mark_all_read','POST',{});
    if(r.success){showToast('Tümü okundu','success');loadMessages();loadDashboard();}
}

async function bulkDeleteMessages(){
    if(selectedMsgIds.length===0){showToast('Mesaj seçin','warning');return;}
    if(!confirm(selectedMsgIds.length+' mesajı silmek istediğinize emin misiniz?'))return;
    const r=await api('admin_data.php?action=bulk_delete_messages','POST',{ids:selectedMsgIds});
    if(r.success){showToast(r.message,'success');loadMessages();loadDashboard();}
}

// ════════════════════════════════════════════════════════
// LOGLAR
// ════════════════════════════════════════════════════════
async function loadLogs(){
    loadLogsInto('logsContainer',100);
}

async function loadLogsInto(targetId,limit){
    const r=await api('admin_data.php?action=recent_logs&limit='+limit);
    const c=document.getElementById(targetId);
    if(!r.success||r.data.length===0){c.innerHTML='<div class="empty"><div class="ei">📋</div><p>Log bulunamadı</p></div>';return;}
    c.innerHTML=r.data.map(l=>`
    <div class="log-item">
        <div class="log-time">${l.created_at}</div>
        <div>
            <div class="log-action"><strong>${esc(l.user_name||'Sistem')}</strong> — ${esc(l.action)}</div>
            ${l.detail?`<div class="log-detail">${esc(l.detail)}</div>`:''}
            ${l.ip_address?`<div style="font-size:10px;color:var(--muted)">IP: ${l.ip_address}</div>`:''}
        </div>
    </div>`).join('');
}

// ════════════════════════════════════════════════════════
// HİZMETLER
// ════════════════════════════════════════════════════════
async function loadServices(){
    const r=await api('admin_data.php?action=services');
    const t=document.getElementById('svcTable');
    if(!r.success||r.data.length===0){t.innerHTML='<tr><td colspan="6"><div class="empty"><div class="ei">⚙️</div><p>Hizmet yok</p></div></td></tr>';return;}
    t.innerHTML=r.data.map(s=>`<tr>
        <td style="font-size:22px">${esc(s.icon)}</td>
        <td><strong>${esc(s.title)}</strong></td>
        <td style="color:var(--muted);max-width:200px;font-size:12px">${esc(s.description||'').substring(0,80)}...</td>
        <td>${s.sort_order}</td>
        <td><span class="badge ${s.is_active=='1'?'bg-green':'bg-red'}">${s.is_active=='1'?'Aktif':'Pasif'}</span></td>
        <td><div style="display:flex;gap:5px">
            <button class="btn btn-out btn-sm" onclick="editService(${s.id})">✏️</button>
            <button class="btn btn-red btn-sm" onclick="delService(${s.id})">🗑️</button>
        </div></td>
    </tr>`).join('');
}

function openSvcModal(reset=true){
    if(reset){document.getElementById('svcForm').reset();document.getElementById('sf_id').value='';document.getElementById('svcModalT').textContent='Yeni Hizmet';}
    openModal('svcModal');
}

async function editService(id){
    const r=await api('admin_data.php?action=get_service&id='+id);
    if(!r.success)return;
    const s=r.data;
    setv('sf_id',s.id);setv('sf_ic',s.icon);setv('sf_ti',s.title);setv('sf_de',s.description);setv('sf_so',s.sort_order);setv('sf_ac',s.is_active);
    document.getElementById('svcModalT').textContent='Hizmet Düzenle';
    openSvcModal(false);
}

async function delService(id){
    if(!confirm('Hizmeti silmek istediğinize emin misiniz?'))return;
    const r=await api('admin_data.php?action=delete_service','POST',{id});
    if(r.success){showToast('Hizmet silindi','success');loadServices();}else showToast(r.message,'error');
}

document.getElementById('svcForm').addEventListener('submit',async function(e){
    e.preventDefault();
    const fd=new FormData(this);
    const data=Object.fromEntries(fd.entries());
    const action=data.id?'update_service':'add_service';
    const r=await api('admin_data.php?action='+action,'POST',data);
    if(r.success){showToast(r.message,'success');closeModal('svcModal');this.reset();document.getElementById('sf_id').value='';loadServices();}
    else showToast(r.message,'error');
});

// ════════════════════════════════════════════════════════
// PORTFOLYO
// ════════════════════════════════════════════════════════
async function loadPortfolio(){
    const r=await api('admin_data.php?action=portfolio');
    const t=document.getElementById('portTable');
    if(!r.success||r.data.length===0){t.innerHTML='<tr><td colspan="5"><div class="empty"><div class="ei">💼</div><p>Proje yok</p></div></td></tr>';return;}
    t.innerHTML=r.data.map(p=>`<tr>
        <td style="font-size:26px">${esc(p.emoji)}</td>
        <td><strong>${esc(p.title)}</strong></td>
        <td><span class="badge bg-cyan">${esc(p.category)}</span></td>
        <td><span class="badge ${p.is_active=='1'?'bg-green':'bg-red'}">${p.is_active=='1'?'Aktif':'Pasif'}</span></td>
        <td><div style="display:flex;gap:5px">
            <button class="btn btn-out btn-sm" onclick="editPortfolio(${p.id})">✏️</button>
            <button class="btn btn-red btn-sm" onclick="delPortfolio(${p.id})">🗑️</button>
        </div></td>
    </tr>`).join('');
}

function openPortModal(reset=true){
    if(reset){document.getElementById('portForm').reset();document.getElementById('pf_id').value='';document.getElementById('portModalT').textContent='Yeni Proje';}
    openModal('portModal');
}

async function editPortfolio(id){
    const r=await api('admin_data.php?action=get_portfolio&id='+id);
    if(!r.success)return;
    const p=r.data;
    setv('pf_id',p.id);setv('pf_em',p.emoji);setv('pf_ti',p.title);setv('pf_ca',p.category);setv('pf_de',p.description);setv('pf_bg',p.bg_gradient);setv('pf_ur',p.project_url);setv('pf_ac',p.is_active);
    document.getElementById('portModalT').textContent='Proje Düzenle';
    openPortModal(false);
}

async function delPortfolio(id){
    if(!confirm('Projeyi silmek istediğinize emin misiniz?'))return;
    const r=await api('admin_data.php?action=delete_portfolio','POST',{id});
    if(r.success){showToast('Proje silindi','success');loadPortfolio();}else showToast(r.message,'error');
}

document.getElementById('portForm').addEventListener('submit',async function(e){
    e.preventDefault();
    const fd=new FormData(this);
    const data=Object.fromEntries(fd.entries());
    const action=data.id?'update_portfolio':'add_portfolio';
    const r=await api('admin_data.php?action='+action,'POST',data);
    if(r.success){showToast(r.message,'success');closeModal('portModal');this.reset();document.getElementById('pf_id').value='';loadPortfolio();}
    else showToast(r.message,'error');
});

// ════════════════════════════════════════════════════════
// KULLANICILAR
// ════════════════════════════════════════════════════════
async function loadUsers(){
    const search=getv('userSearch');
    const role=getv('userRoleFilter');
    const r=await api(`admin_data.php?action=users&search=${encodeURIComponent(search)}&role=${role}`);
    const t=document.getElementById('usersTable');
    if(!r.success||r.data.length===0){t.innerHTML='<tr><td colspan="8"><div class="empty"><div class="ei">👥</div><p>Kullanıcı bulunamadı</p></div></td></tr>';return;}
    t.innerHTML=r.data.map(u=>`<tr>
        <td style="color:var(--muted)">#${u.id}</td>
        <td><strong>${esc(u.first_name)} ${esc(u.last_name)}</strong></td>
        <td style="color:var(--muted);font-size:12px">${esc(u.email)}</td>
        <td style="color:var(--muted);font-size:12px">${esc(u.company||'—')}</td>
        <td><span class="badge ${roleBadge(u.role)}">${roleLabel(u.role)}</span></td>
        <td><span class="badge ${u.is_active=='1'?'bg-green':'bg-red'}">${u.is_active=='1'?'Aktif':'Pasif'}</span></td>
        <td style="color:var(--muted);font-size:11px">${u.created_at}</td>
        <td><div class="user-row-actions">
            <button class="btn btn-out btn-sm" onclick="editUser(${u.id})">✏️</button>
            <button class="btn btn-yellow btn-sm" onclick="toggleStatus(${u.id})">⏯️</button>
            <button class="btn btn-red btn-sm" onclick="deleteUser(${u.id})">🗑️</button>
        </div></td>
    </tr>`).join('');
}

function openAddUserModal(defaultRole='customer'){
    document.getElementById('userForm').reset();
    document.getElementById('uf_id').value='';
    document.getElementById('uf_ro').value=defaultRole;
    document.getElementById('userModalT').textContent='Kullanıcı Ekle';
    openModal('userModal');
}

async function editUser(id){
    const r=await api('admin_data.php?action=get_user&id='+id);
    if(!r.success)return;
    const u=r.data;
    setv('uf_id',u.id);setv('uf_fn',u.first_name);setv('uf_ln',u.last_name);setv('uf_em',u.email);setv('uf_ph',u.phone);setv('uf_co',u.company);setv('uf_ro',u.role);setv('uf_ac',u.is_active);
    document.getElementById('uf_pw').value='';
    document.getElementById('userModalT').textContent='Kullanıcı Düzenle';
    openModal('userModal');
}

document.getElementById('userForm').addEventListener('submit',async function(e){
    e.preventDefault();
    const fd=new FormData(this);
    const data=Object.fromEntries(fd.entries());
    const action=data.id?'update_user':'add_user';
    const r=await api('admin_data.php?action='+action,'POST',data);
    if(r.success){showToast(r.message,'success');closeModal('userModal');this.reset();document.getElementById('uf_id').value='';loadUsers();loadAdmins();}
    else showToast(r.message,'error');
});

async function toggleStatus(id){
    const r=await api('admin_data.php?action=toggle_user_status','POST',{id});
    if(r.success){showToast('Durum güncellendi','success');loadUsers();loadAdmins();}else showToast(r.message,'error');
}

async function deleteUser(id){
    if(!confirm('Bu kullanıcıyı kalıcı olarak silmek istediğinize emin misiniz?'))return;
    const r=await api('admin_data.php?action=delete_user','POST',{id});
    if(r.success){showToast('Kullanıcı silindi','success');loadUsers();loadAdmins();loadDashboard();}else showToast(r.message,'error');
}

// ════════════════════════════════════════════════════════
// ADMİN YÖNETİMİ
// ════════════════════════════════════════════════════════
async function loadAdmins(){
    const r=await api('admin_data.php?action=users&role=admin');
    const r2=await api('admin_data.php?action=users&role=manager');
    const all=[...(r.data||[]),...(r2.data||[])];
    const t=document.getElementById('adminsTable');
    if(all.length===0){t.innerHTML='<tr><td colspan="6"><div class="empty"><div class="ei">👑</div><p>Admin bulunamadı</p></div></td></tr>';return;}
    t.innerHTML=all.map(u=>`<tr>
        <td style="color:var(--muted)">#${u.id}</td>
        <td><strong>${esc(u.first_name)} ${esc(u.last_name)}</strong></td>
        <td style="color:var(--muted);font-size:12px">${esc(u.email)}</td>
        <td><span class="badge ${roleBadge(u.role)}">${roleLabel(u.role)}</span></td>
        <td><span class="badge ${u.is_active=='1'?'bg-green':'bg-red'}">${u.is_active=='1'?'Aktif':'Pasif'}</span></td>
        <td><div style="display:flex;gap:5px">
            <button class="btn btn-out btn-sm" onclick="editUser(${u.id})">✏️ Düzenle</button>
            <button class="btn btn-yellow btn-sm" onclick="changeRole(${u.id},'customer')">↓ Müşteriye Düşür</button>
            <button class="btn btn-red btn-sm" onclick="deleteUser(${u.id})">🗑️ Sil</button>
        </div></td>
    </tr>`).join('');
}

async function changeRole(id,role){
    const label={'customer':'müşteriye düşür','admin':'admin yap','manager':'manager yap'};
    if(!confirm(`Rolü ${label[role]||role} işlemi yapılsın mı?`))return;
    const r=await api('admin_data.php?action=set_admin','POST',{id,role});
    if(r.success){showToast('Rol güncellendi','success');loadAdmins();loadUsers();}else showToast(r.message,'error');
}

document.getElementById('addAdminForm').addEventListener('submit',async function(e){
    e.preventDefault();
    const fd=new FormData(this);
    const data=Object.fromEntries(fd.entries());
    const r=await api('admin_data.php?action=add_user','POST',data);
    if(r.success){showToast('Admin eklendi ✓','success');this.reset();loadAdmins();}else showToast(r.message,'error');
});

// ════════════════════════════════════════════════════════
// DUYURULAR
// ════════════════════════════════════════════════════════
async function loadAnnouncements(){
    const r=await api('admin_data.php?action=announcements');
    const t=document.getElementById('annTable');
    if(!r.success||r.data.length===0){t.innerHTML='<tr><td colspan="5"><div class="empty"><div class="ei">📢</div><p>Duyuru yok</p></div></td></tr>';return;}
    const typeColors={info:'bg-cyan',success:'bg-green',warning:'bg-yellow',danger:'bg-red'};
    t.innerHTML=r.data.map(a=>`<tr>
        <td><strong>${esc(a.title)}</strong><br><span style="font-size:12px;color:var(--muted)">${esc(a.content).substring(0,60)}...</span></td>
        <td><span class="badge ${typeColors[a.type]||'bg-blue'}">${a.type}</span></td>
        <td><span class="badge ${a.is_active=='1'?'bg-green':'bg-red'}">${a.is_active=='1'?'Aktif':'Pasif'}</span></td>
        <td style="font-size:12px;color:var(--muted)">${a.created_at}</td>
        <td><button class="btn btn-red btn-sm" onclick="deleteAnn(${a.id})">🗑️</button></td>
    </tr>`).join('');
}

document.getElementById('annForm').addEventListener('submit',async function(e){
    e.preventDefault();
    const fd=new FormData(this);
    const r=await api('admin_data.php?action=add_announcement','POST',Object.fromEntries(fd.entries()));
    if(r.success){showToast('Duyuru eklendi','success');closeModal('annModal');this.reset();loadAnnouncements();}
    else showToast(r.message,'error');
});

async function deleteAnn(id){
    if(!confirm('Duyuruyu silmek istediğinize emin misiniz?'))return;
    const r=await api('admin_data.php?action=delete_announcement','POST',{id});
    if(r.success){showToast('Duyuru silindi','success');loadAnnouncements();}
}

// ════════════════════════════════════════════════════════
// AYARLAR
// ════════════════════════════════════════════════════════
async function loadSettings(){
    const r=await api('admin_data.php?action=get_settings');
    if(!r.success)return;
    const s=r.data;
    // Homepage
    setv('h_t1',s.hero_title1);setv('h_t2',s.hero_title2);setv('h_d',s.hero_desc);
    setv('h_b1',s.hero_btn1);setv('h_b2',s.hero_btn2);
    setv('h_s1n',s.stat1_num);setv('h_s1t',s.stat1_text);
    setv('h_s2n',s.stat2_num);setv('h_s2t',s.stat2_text);
    setv('h_s3n',s.stat3_num);setv('h_s3t',s.stat3_text);
    setv('h_s4n',s.stat4_num);setv('h_s4t',s.stat4_text);
    setv('h_ft',s.footer_text);
    // Site
    setv('ss_name',s.site_name);setv('ss_slogan',s.site_slogan);setv('ss_desc',s.site_desc);
    setv('ss_phone',s.phone);setv('ss_email',s.email);setv('ss_addr',s.address);
    const maint=document.getElementById('ss_maint');if(maint)maint.checked=s.maintenance==='1';
    // Renkler
    setv('cp1',s.color_primary||'#22d3ee');setv('cp2',s.color_secondary||'#3b82f6');setv('cp3',s.color_bg||'#07111f');
    document.getElementById('cp1v').textContent=s.color_primary||'#22d3ee';
    document.getElementById('cp2v').textContent=s.color_secondary||'#3b82f6';
    document.getElementById('cp3v').textContent=s.color_bg||'#07111f';
    // Sosyal
    setv('ss_ig',s.instagram);setv('ss_tw',s.twitter);setv('ss_li',s.linkedin);
    setv('ss_gh',s.github);setv('ss_yt',s.youtube);setv('ss_wa',s.whatsapp);
    // İletişim
    setv('ci1',s.ci_phone1);setv('ci2',s.ci_phone2);setv('ci3',s.ci_email1);setv('ci4',s.ci_email2);
    setv('ci5',s.ci_address);setv('ci6',s.ci_hours_wd);setv('ci7',s.ci_hours_we);setv('ci8',s.ci_maps);
    // SEO
    setv('se1',s.meta_title);setv('se2',s.meta_desc);setv('se3',s.meta_keywords);
    setv('se4',s.ga_id);setv('se5',s.favicon);
}

async function saveSettings(data){
    const r=await api('admin_data.php?action=save_settings','POST',data);
    if(r.success)showToast('Ayarlar kaydedildi ✓','success');
    else showToast(r.message||'Hata','error');
}

document.getElementById('homepageForm').addEventListener('submit',async function(e){e.preventDefault();await saveSettings(Object.fromEntries(new FormData(this).entries()));});
document.getElementById('siteForm').addEventListener('submit',async function(e){
    e.preventDefault();
    const data=Object.fromEntries(new FormData(this).entries());
    data.maintenance=document.getElementById('ss_maint').checked?'1':'0';
    await saveSettings(data);
});
document.getElementById('colorForm').addEventListener('submit',async function(e){e.preventDefault();await saveSettings(Object.fromEntries(new FormData(this).entries()));});
document.getElementById('socialForm').addEventListener('submit',async function(e){e.preventDefault();await saveSettings(Object.fromEntries(new FormData(this).entries()));});
document.getElementById('contactSettingsForm').addEventListener('submit',async function(e){e.preventDefault();await saveSettings(Object.fromEntries(new FormData(this).entries()));});
document.getElementById('seoForm').addEventListener('submit',async function(e){e.preventDefault();await saveSettings(Object.fromEntries(new FormData(this).entries()));});

// Renk önizleme
['cp1','cp2','cp3'].forEach(id=>{
    document.getElementById(id)?.addEventListener('input',function(){
        document.getElementById(this.id+'v').textContent=this.value;
    });
});

function resetColors(){
    setv('cp1','#22d3ee');setv('cp2','#3b82f6');setv('cp3','#07111f');
    document.getElementById('cp1v').textContent='#22d3ee';
    document.getElementById('cp2v').textContent='#3b82f6';
    document.getElementById('cp3v').textContent='#07111f';
    showToast('Renkler sıfırlandı','info');
}

// ════════════════════════════════════════════════════════
// ÇIKIŞ
// ════════════════════════════════════════════════════════
async function logoutAdmin(){
    await fetch('../api/logout.php');
    window.location.href='../index.php';
}

// ════════════════════════════════════════════════════════
// CANLI DESTEK (ADMIN)
// ════════════════════════════════════════════════════════
let adminActiveChatId=null;
let adminLastMsgId=0;
let adminChatPoll=null;
let adminSessionPoll=null;
let totalChatUnread=0;

async function loadChatSessions(){
    try{
        const res=await fetch('../api/chat.php?action=admin_sessions');
        const data=await res.json();
        if(!data.success)return;
        
        const list=document.getElementById('adminSessionsList');
        const sessions=data.data.sessions;
        
        // Update badge
        totalChatUnread=sessions.reduce((sum,s)=>sum+(parseInt(s.unread_count)||0),0);
        const badge=document.getElementById('sb-chat-badge');
        if(totalChatUnread>0){badge.style.display='flex';badge.textContent=totalChatUnread;}
        else badge.style.display='none';
        
        if(sessions.length===0){
            list.innerHTML='<div class="empty" style="padding:20px;font-size:13px;text-align:center">💬<br>Aktif sohbet yok</div>';
            return;
        }
        
        list.innerHTML=sessions.map(s=>`
            <div class="session-item ${s.id==adminActiveChatId?'active':''}" onclick="selectAdminChat(${s.id},'${esc(s.visitor_name)}','${esc(s.visitor_email||'')}','${s.status}')">
                <div class="sname">
                    <span class="${s.status==='waiting'?'session-waiting':'session-active'}"></span>
                    ${esc(s.visitor_name)}
                    ${s.unread_count>0?`<span class="sbadge">${s.unread_count}</span>`:''}
                </div>
                <div class="slast">${s.last_message?esc(s.last_message):'Yeni sohbet'}</div>
                <div style="font-size:10px;color:var(--muted);margin-top:3px">${s.status==='waiting'?'⏳ Bekliyor':'✅ Aktif'}</div>
            </div>
        `).join('');
    }catch(e){}
}

function selectAdminChat(sessionId,name,email,status){
    adminActiveChatId=sessionId;
    adminLastMsgId=0;
    clearInterval(adminChatPoll);
    
    document.getElementById('adminChatEmpty').style.display='none';
    const active=document.getElementById('adminChatActive');
    active.style.display='flex';
    active.style.flexDirection='column';
    
    document.getElementById('adminChatVisitorName').textContent=name||'Ziyaretçi';
    document.getElementById('adminChatVisitorEmail').textContent=email||'—';
    document.getElementById('adminChatMessages').innerHTML='';
    
    if(status==='closed'){
        document.getElementById('adminChatInputArea').style.display='none';
        document.getElementById('adminChatClosed').style.display='block';
    }else{
        document.getElementById('adminChatInputArea').style.display='flex';
        document.getElementById('adminChatClosed').style.display='none';
    }
    
    loadAdminMessages();
    adminChatPoll=setInterval(loadAdminMessages,2000);
    
    // Refresh sessions list
    loadChatSessions();
}

async function loadAdminMessages(){
    if(!adminActiveChatId)return;
    try{
        const res=await fetch(`../api/chat.php?action=admin_messages&session_id=${adminActiveChatId}&since=${adminLastMsgId}`);
        const data=await res.json();
        if(!data.success)return;
        
        data.data.messages.forEach(renderAdminMsg);
        
        if(data.data.session&&data.data.session.status==='closed'){
            document.getElementById('adminChatInputArea').style.display='none';
            document.getElementById('adminChatClosed').style.display='block';
        }
    }catch(e){}
}

function renderAdminMsg(msg){
    if(msg.id<=adminLastMsgId)return;
    adminLastMsgId=msg.id;
    
    const container=document.getElementById('adminChatMessages');
    const div=document.createElement('div');
    div.className='amsg '+msg.sender_type;
    const time=new Date(msg.created_at).toLocaleTimeString('tr-TR',{hour:'2-digit',minute:'2-digit'});
    div.innerHTML=`<div>${esc(msg.message)}</div><div class="amsg-time">${esc(msg.sender_name||'')} • ${time}</div>`;
    container.appendChild(div);
    container.scrollTop=container.scrollHeight;
}

async function sendAdminReply(){
    const input=document.getElementById('adminChatInput');
    const message=input.value.trim();
    if(!message||!adminActiveChatId)return;
    input.value='';
    
    try{
        await fetch('../api/chat.php?action=admin_reply',{
            method:'POST',headers:{'Content-Type':'application/json'},
            body:JSON.stringify({session_id:adminActiveChatId,message})
        });
        loadAdminMessages();
    }catch(e){}
}

async function closeAdminChat(){
    if(!adminActiveChatId)return;
    if(!confirm('Bu sohbeti kapatmak istediğinize emin misiniz?'))return;
    try{
        await fetch('../api/chat.php?action=admin_close',{
            method:'POST',headers:{'Content-Type':'application/json'},
            body:JSON.stringify({session_id:adminActiveChatId})
        });
        document.getElementById('adminChatInputArea').style.display='none';
        document.getElementById('adminChatClosed').style.display='block';
        loadChatSessions();
        loadAdminMessages();
        showToast('Sohbet kapatıldı','info');
    }catch(e){}
}

function adminChatKeyDown(e){
    if(e.key==='Enter'&&!e.shiftKey){e.preventDefault();sendAdminReply();}
}

// Start polling sessions when on live chat page - hook into goPage
const _origGoPageChat=goPage;
goPage=function(page){
    _origGoPageChat(page);
    if(page==='livechat'){
        clearInterval(adminSessionPoll);
        loadChatSessions();
        adminSessionPoll=setInterval(loadChatSessions,3000);
    }else{
        clearInterval(adminSessionPoll);
        clearInterval(adminChatPoll);
    }
};

// Check for new chats periodically regardless of page
setInterval(async()=>{
    try{
        const res=await fetch('../api/chat.php?action=admin_sessions');
        const data=await res.json();
        if(!data.success)return;
        const total=data.data.sessions.reduce((sum,s)=>sum+(parseInt(s.unread_count)||0),0);
        const badge=document.getElementById('sb-chat-badge');
        if(total>0){badge.style.display='flex';badge.textContent=total;}
        else badge.style.display='none';
    }catch(e){}
},5000);

// ════════════════════════════════════════════════════════
// BAŞLANGIÇ
// ════════════════════════════════════════════════════════
const sp=new URLSearchParams(location.search).get('page')||'dashboard';
goPage(sp);
</script>
</body>
</html>