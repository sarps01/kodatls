<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>KodAtlas | Yazılım Şirketi</title>
<meta name="description" content="KodAtlas yazılım şirketi. Kurumsal web sitesi, e-ticaret, mobil uygulama ve özel yazılım çözümleri.">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{
--bg:#040d18;
--bg2:#070f1e;
--card:rgba(255,255,255,.04);
--line:rgba(255,255,255,.08);
--text:#e8f4ff;
--muted:#6b8aaa;
--cyan:#00e5ff;
--blue:#2563eb;
--green:#00d68f;
--red:#ff4757;
--purple:#7c3aed;
}
html{scroll-behavior:smooth}
body{
font-family:'Space Grotesk',sans-serif;
background:var(--bg);
color:var(--text);
line-height:1.6;
overflow-x:hidden;
}

/* ── GRID BG ── */
body::before{
content:'';
position:fixed;inset:0;
background-image:
  linear-gradient(rgba(0,229,255,.03) 1px,transparent 1px),
  linear-gradient(90deg,rgba(0,229,255,.03) 1px,transparent 1px);
background-size:60px 60px;
pointer-events:none;z-index:0;
animation:gridShift 20s linear infinite;
}
@keyframes gridShift{from{background-position:0 0}to{background-position:60px 60px}}

/* ── GLOW ORBS ── */
.orb{position:fixed;border-radius:50%;filter:blur(80px);opacity:.18;pointer-events:none;animation:orbFloat 8s ease-in-out infinite}
.orb1{width:500px;height:500px;background:var(--cyan);top:-150px;left:-150px;animation-delay:0s}
.orb2{width:400px;height:400px;background:var(--blue);bottom:-100px;right:-100px;animation-delay:3s}
.orb3{width:300px;height:300px;background:var(--purple);top:40%;left:60%;animation-delay:6s}
@keyframes orbFloat{0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(30px,-30px) scale(1.05)}}

.container{width:min(1180px,92%);margin:auto;position:relative;z-index:1}

/* ── NAV ── */
nav{
position:sticky;top:0;z-index:50;
background:rgba(4,13,24,.8);
backdrop-filter:blur(20px);
border-bottom:1px solid rgba(0,229,255,.1);
}
.nav-inner{display:flex;align-items:center;justify-content:space-between;padding:14px 0;gap:20px}
.logo{font-size:22px;font-weight:800;text-decoration:none;color:#fff;letter-spacing:-0.5px;display:flex;align-items:center;gap:6px}
.logo-mark{
  width:32px;height:32px;
  background:linear-gradient(135deg,var(--cyan),var(--blue));
  border-radius:8px;
  display:flex;align-items:center;justify-content:center;
  font-size:14px;font-weight:900;color:#001018;
}
.logo span{color:var(--cyan)}
.nav-links{display:flex;gap:28px;list-style:none}
.nav-links a{text-decoration:none;color:var(--muted);font-size:14px;font-weight:500;transition:.2s;position:relative}
.nav-links a::after{content:'';position:absolute;bottom:-3px;left:0;width:0;height:1px;background:var(--cyan);transition:.3s}
.nav-links a:hover{color:var(--cyan)}
.nav-links a:hover::after{width:100%}
.nav-actions{display:flex;gap:10px;align-items:center;flex-wrap:wrap}

/* ── BUTTONS ── */
.btn{
border:none;cursor:pointer;text-decoration:none;
display:inline-flex;align-items:center;justify-content:center;
gap:8px;padding:11px 22px;border-radius:10px;
font-weight:700;font-size:14px;transition:.2s;
font-family:'Space Grotesk',sans-serif;
}
.btn-primary{
  background:linear-gradient(135deg,var(--cyan),var(--blue));
  color:#001a2e;
  box-shadow:0 4px 20px rgba(0,229,255,.25);
}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(0,229,255,.4)}
.btn-outline{background:transparent;color:var(--text);border:1px solid rgba(255,255,255,.12)}
.btn-outline:hover{border-color:var(--cyan);color:var(--cyan);background:rgba(0,229,255,.05)}

/* ── HERO ── */
.hero{padding:100px 0 80px}
.hero-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:50px;align-items:center}
.badge{
display:inline-flex;align-items:center;gap:8px;
padding:7px 14px;border-radius:8px;
background:rgba(0,229,255,.08);border:1px solid rgba(0,229,255,.2);
color:var(--cyan);font-size:12px;font-weight:700;margin-bottom:20px;
font-family:'JetBrains Mono',monospace;
}
.badge-dot{width:6px;height:6px;border-radius:50%;background:var(--cyan);animation:pulse 2s ease-in-out infinite}
@keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(.8)}}
h1{
font-size:clamp(40px,6vw,72px);
line-height:1.0;
margin-bottom:20px;
letter-spacing:-2px;font-weight:800;
}
.gradient{
background:linear-gradient(135deg,var(--cyan) 0%,var(--blue) 60%,var(--purple) 100%);
-webkit-background-clip:text;
-webkit-text-fill-color:transparent;
}
.hero p{color:var(--muted);font-size:17px;max-width:580px;margin-bottom:32px;line-height:1.7}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap}

/* ── HERO CARD ── */
.hero-card{
background:rgba(7,15,30,.8);
border:1px solid rgba(0,229,255,.15);
border-radius:20px;padding:28px;
box-shadow:0 0 60px rgba(0,229,255,.06),inset 0 1px 0 rgba(255,255,255,.05);
position:relative;overflow:hidden;
}
.hero-card::before{
content:'';position:absolute;top:0;left:0;right:0;height:1px;
background:linear-gradient(90deg,transparent,var(--cyan),transparent);
animation:scanLine 3s ease-in-out infinite;
}
@keyframes scanLine{0%,100%{opacity:0;transform:translateX(-100%)}50%{opacity:1;transform:translateX(0)}}
.mini{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-top:20px}
.mini-box{
background:rgba(0,229,255,.04);
border:1px solid rgba(0,229,255,.1);
border-radius:14px;padding:16px;
transition:.3s;cursor:default;
}
.mini-box:hover{background:rgba(0,229,255,.08);border-color:rgba(0,229,255,.25);transform:translateY(-2px)}
.mini-box h3{font-size:26px;color:var(--cyan);font-weight:800;font-family:'JetBrains Mono',monospace}

/* ── SECTIONS ── */
.section{padding:90px 0}
.section-head{text-align:center;margin-bottom:50px}
.kicker{color:var(--cyan);font-size:11px;font-weight:700;letter-spacing:3px;text-transform:uppercase;font-family:'JetBrains Mono',monospace}
.section-head h2{font-size:clamp(30px,4.4vw,50px);margin-top:10px;margin-bottom:12px;letter-spacing:-1px}
.section-head p{color:var(--muted);max-width:640px;margin:auto;font-size:16px}

/* ── CARDS ── */
.grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
.card{
background:rgba(7,15,30,.7);
border:1px solid rgba(255,255,255,.07);
border-radius:18px;
padding:24px;
transition:.3s;
position:relative;overflow:hidden;
}
.card::after{
content:'';position:absolute;inset:0;
background:radial-gradient(circle at 50% 0,rgba(0,229,255,.06),transparent 70%);
opacity:0;transition:.3s;
}
.card:hover{transform:translateY(-6px);border-color:rgba(0,229,255,.2)}
.card:hover::after{opacity:1}
.icon{
width:52px;height:52px;border-radius:14px;
display:flex;align-items:center;justify-content:center;
font-size:22px;margin-bottom:16px;
background:rgba(0,229,255,.07);border:1px solid rgba(0,229,255,.15);
}
.card h3{margin-bottom:8px;font-size:18px;font-weight:700}
.card p{color:var(--muted);font-size:14px;line-height:1.6}

/* ── ABOUT ── */
.about{display:grid;grid-template-columns:1fr 1fr;gap:28px;align-items:center}
.about-box{
background:rgba(7,15,30,.7);border:1px solid rgba(255,255,255,.07);
border-radius:20px;padding:32px;
}
.about-box ul{list-style:none;margin-top:18px;display:grid;gap:10px}
.about-box li{
background:rgba(0,229,255,.03);
border:1px solid rgba(0,229,255,.08);
border-radius:12px;padding:11px 14px;
font-size:14px;transition:.2s;
}
.about-box li:hover{background:rgba(0,229,255,.07);border-color:rgba(0,229,255,.2)}

/* ── PORTFOLIO ── */
.portfolio-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
.project{
background:rgba(7,15,30,.7);border:1px solid rgba(255,255,255,.07);
border-radius:18px;overflow:hidden;transition:.3s;
}
.project:hover{transform:translateY(-6px);border-color:rgba(0,229,255,.2)}
.project-cover{
height:180px;display:flex;align-items:center;justify-content:center;
font-size:56px;
}
.project-body{padding:20px}
.tag{display:inline-block;font-size:11px;font-weight:700;color:var(--cyan);margin-bottom:8px;font-family:'JetBrains Mono',monospace;letter-spacing:1px}
.project p{color:var(--muted);font-size:13px;margin-top:4px}

/* ── CONTACT ── */
.contact-wrap{display:grid;grid-template-columns:1fr 1fr;gap:24px}
.info-box,.form-box{
background:rgba(7,15,30,.7);border:1px solid rgba(255,255,255,.07);
border-radius:20px;padding:28px;
}
.info-list{display:grid;gap:12px;margin-top:20px}
.info-item{
padding:14px 16px;border-radius:12px;
border:1px solid rgba(255,255,255,.07);background:rgba(0,229,255,.03);
font-size:14px;
}
form .row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.input{
width:100%;padding:13px 16px;border-radius:12px;
border:1px solid rgba(255,255,255,.1);
background:rgba(255,255,255,.04);
color:#fff;outline:none;font-size:14px;
font-family:'Space Grotesk',sans-serif;
transition:.2s;
}
.input:focus{border-color:var(--cyan);background:rgba(0,229,255,.05);box-shadow:0 0 0 3px rgba(0,229,255,.1)}
textarea.input{min-height:120px;resize:vertical}

/* ── FOOTER ── */
footer{
border-top:1px solid rgba(255,255,255,.07);
padding:28px 0;margin-top:20px;color:var(--muted);font-size:14px;
position:relative;z-index:1;
}

/* ── USER CHIP ── */
.user-chip{
display:flex;align-items:center;gap:8px;
padding:8px 14px;border-radius:10px;background:rgba(0,229,255,.07);
border:1px solid rgba(0,229,255,.2);font-size:13px;
}
.hidden{display:none!important}

/* ── MODAL ── */
.modal{
position:fixed;inset:0;
background:rgba(0,0,0,.8);
backdrop-filter:blur(8px);
display:none;align-items:center;justify-content:center;
padding:20px;z-index:100;
}
.modal.show{display:flex}
.modal-card{
width:min(480px,100%);
background:rgba(6,14,26,.98);
border:1px solid rgba(0,229,255,.2);
border-radius:20px;padding:28px;
box-shadow:0 30px 80px rgba(0,0,0,.6),0 0 40px rgba(0,229,255,.05);
position:relative;overflow:hidden;
animation:modalIn .3s cubic-bezier(.34,1.56,.64,1);
}
@keyframes modalIn{from{opacity:0;transform:scale(.92) translateY(20px)}to{opacity:1;transform:scale(1) translateY(0)}}
.modal-card::before{
content:'';position:absolute;top:0;left:0;right:0;height:1px;
background:linear-gradient(90deg,transparent,var(--cyan),transparent);
}
.modal-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:6px}
.modal-head h3{font-size:22px;font-weight:800}
.close-btn{
width:36px;height:36px;border:none;cursor:pointer;
border-radius:9px;background:rgba(255,255,255,.06);color:#fff;
font-size:16px;transition:.2s;
}
.close-btn:hover{background:rgba(255,255,255,.12)}
.modal small{color:var(--muted);font-size:13px}
.modal-footer{text-align:center;margin-top:16px;color:var(--muted);font-size:13px}
.modal-footer a{color:var(--cyan);cursor:pointer;font-weight:600}

/* ── PHONE FIELD ── */
.phone-wrap{display:flex;gap:0}
.country-select{
  flex-shrink:0;
  background:rgba(255,255,255,.06);
  border:1px solid rgba(255,255,255,.1);
  border-right:none;
  color:#fff;
  border-radius:12px 0 0 12px;
  padding:13px 10px;
  font-size:13px;
  font-family:'Space Grotesk',sans-serif;
  cursor:pointer;
  outline:none;
  min-width:110px;
  transition:.2s;
  -webkit-appearance:none;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2300e5ff'/%3E%3C/svg%3E");
  background-repeat:no-repeat;
  background-position:right 8px center;
  padding-right:24px;
}
.country-select:focus{border-color:var(--cyan);background-color:rgba(0,229,255,.05)}
.country-select option{background:#0a1628;color:#fff}
.phone-input{border-radius:0 12px 12px 0!important}

/* ── EMAIL VERIFY STEP ── */
.verify-step{display:none;animation:fadeUp .4s ease}
.verify-step.show{display:block}
@keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
.code-inputs{display:flex;gap:8px;justify-content:center;margin:20px 0}
.code-input{
  width:50px;height:56px;
  border:2px solid rgba(255,255,255,.12);
  border-radius:12px;
  background:rgba(255,255,255,.04);
  color:var(--cyan);
  font-size:24px;font-weight:800;
  text-align:center;
  font-family:'JetBrains Mono',monospace;
  outline:none;
  transition:.2s;
  caret-color:var(--cyan);
}
.code-input:focus{border-color:var(--cyan);background:rgba(0,229,255,.07);box-shadow:0 0 0 3px rgba(0,229,255,.15)}
.code-timer{text-align:center;color:var(--muted);font-size:13px;margin-top:8px}
.code-timer span{color:var(--cyan);font-weight:700;font-family:'JetBrains Mono',monospace}

/* ── TOAST ── */
.toast-wrap{
position:fixed;right:18px;bottom:80px;z-index:200;
display:flex;flex-direction:column;gap:8px;
}
.toast{
min-width:260px;max-width:340px;
padding:14px 18px;border-radius:12px;
background:rgba(6,14,26,.98);border:1px solid rgba(255,255,255,.1);
box-shadow:0 20px 50px rgba(0,0,0,.4);
animation:toastIn .3s cubic-bezier(.34,1.56,.64,1);
font-size:14px;
}
@keyframes toastIn{from{opacity:0;transform:translateX(60px)}to{opacity:1;transform:translateX(0)}}
.toast.success{border-color:rgba(0,214,143,.3);box-shadow:0 0 20px rgba(0,214,143,.1)}
.toast.error{border-color:rgba(255,71,87,.3);box-shadow:0 0 20px rgba(255,71,87,.1)}
.toast.info{border-color:rgba(0,229,255,.3);box-shadow:0 0 20px rgba(0,229,255,.1)}
.toast-icon{margin-right:6px}

/* ── LIVE CHAT WIDGET ── */
#chatWidget{
  position:fixed;bottom:24px;right:24px;z-index:1000;
  display:flex;flex-direction:column;align-items:flex-end;gap:12px;
}
.chat-toggle{
  width:58px;height:58px;border-radius:50%;
  background:linear-gradient(135deg,var(--cyan),var(--blue));
  border:none;cursor:pointer;
  display:flex;align-items:center;justify-content:center;
  box-shadow:0 8px 30px rgba(0,229,255,.4);
  transition:.3s;
  position:relative;
  animation:chatBounce 3s ease-in-out infinite;
}
@keyframes chatBounce{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}
.chat-toggle:hover{transform:scale(1.1)!important;animation:none}
.chat-toggle svg{width:26px;height:26px;fill:#001a2e}
.chat-badge{
  position:absolute;top:-4px;right:-4px;
  background:var(--red);color:#fff;
  font-size:11px;font-weight:800;
  width:20px;height:20px;border-radius:50%;
  display:flex;align-items:center;justify-content:center;
  border:2px solid var(--bg);
  display:none;
}
.chat-panel{
  width:340px;
  background:rgba(4,13,24,.97);
  border:1px solid rgba(0,229,255,.2);
  border-radius:20px;
  overflow:hidden;
  box-shadow:0 30px 80px rgba(0,0,0,.6),0 0 40px rgba(0,229,255,.08);
  display:none;
  flex-direction:column;
  max-height:520px;
  animation:chatOpen .3s cubic-bezier(.34,1.56,.64,1);
}
@keyframes chatOpen{from{opacity:0;transform:scale(.9) translateY(20px)}to{opacity:1;transform:scale(1) translateY(0)}}
.chat-panel.open{display:flex}
.chat-header{
  background:linear-gradient(135deg,rgba(0,229,255,.15),rgba(37,99,235,.15));
  border-bottom:1px solid rgba(0,229,255,.15);
  padding:16px 18px;
  display:flex;align-items:center;gap:12px;
}
.chat-avatar{
  width:40px;height:40px;border-radius:50%;
  background:linear-gradient(135deg,var(--cyan),var(--blue));
  display:flex;align-items:center;justify-content:center;
  font-size:18px;flex-shrink:0;
}
.chat-header-info .name{font-size:15px;font-weight:700}
.chat-header-info .status{font-size:12px;color:var(--green);display:flex;align-items:center;gap:5px}
.status-dot{width:6px;height:6px;border-radius:50%;background:var(--green);animation:pulse 2s infinite}
.chat-close{margin-left:auto;background:none;border:none;color:var(--muted);cursor:pointer;font-size:18px;padding:4px;transition:.2s}
.chat-close:hover{color:#fff}

/* ── CHAT START FORM ── */
.chat-start{padding:20px}
.chat-start h4{font-size:16px;font-weight:700;margin-bottom:6px}
.chat-start p{font-size:13px;color:var(--muted);margin-bottom:16px}

/* ── CHAT MESSAGES ── */
.chat-messages{
  flex:1;overflow-y:auto;padding:16px;
  display:flex;flex-direction:column;gap:10px;
  min-height:200px;max-height:300px;
  scrollbar-width:thin;scrollbar-color:rgba(0,229,255,.2) transparent;
}
.msg-bubble{
  max-width:85%;padding:10px 14px;
  border-radius:14px;font-size:13px;line-height:1.5;
  animation:msgIn .25s ease;
}
@keyframes msgIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}
.msg-bubble.admin{
  background:rgba(0,229,255,.1);
  border:1px solid rgba(0,229,255,.15);
  align-self:flex-start;
  border-bottom-left-radius:4px;
}
.msg-bubble.visitor{
  background:linear-gradient(135deg,rgba(37,99,235,.3),rgba(0,229,255,.2));
  border:1px solid rgba(0,229,255,.2);
  align-self:flex-end;
  border-bottom-right-radius:4px;
  text-align:right;
}
.msg-time{font-size:10px;color:var(--muted);margin-top:3px;font-family:'JetBrains Mono',monospace}
.chat-typing{
  display:flex;align-items:center;gap:5px;
  padding:8px 14px;
  background:rgba(0,229,255,.06);
  border-radius:14px;
  align-self:flex-start;
  display:none;
}
.typing-dot{width:7px;height:7px;border-radius:50%;background:var(--cyan);animation:typingDot 1.4s infinite}
.typing-dot:nth-child(2){animation-delay:.2s}
.typing-dot:nth-child(3){animation-delay:.4s}
@keyframes typingDot{0%,80%,100%{transform:scale(.6);opacity:.4}40%{transform:scale(1);opacity:1}}

.chat-input-area{
  border-top:1px solid rgba(255,255,255,.07);
  padding:12px;display:flex;gap:8px;
}
.chat-input{
  flex:1;background:rgba(255,255,255,.05);
  border:1px solid rgba(255,255,255,.1);
  border-radius:10px;padding:10px 13px;
  color:#fff;font-size:13px;outline:none;
  font-family:'Space Grotesk',sans-serif;
  resize:none;max-height:80px;
  transition:.2s;
}
.chat-input:focus{border-color:var(--cyan);background:rgba(0,229,255,.05)}
.chat-send{
  width:38px;height:38px;background:linear-gradient(135deg,var(--cyan),var(--blue));
  border:none;border-radius:10px;cursor:pointer;
  display:flex;align-items:center;justify-content:center;
  flex-shrink:0;align-self:flex-end;
  transition:.2s;
}
.chat-send:hover{transform:scale(1.08)}
.chat-send svg{width:16px;height:16px;fill:#001a2e}
.chat-closed-msg{
  text-align:center;padding:16px;
  color:var(--muted);font-size:13px;
}

/* ── SCAN LINES ── */
@keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
.loading-shimmer{
background:linear-gradient(90deg,rgba(255,255,255,.03) 25%,rgba(0,229,255,.08) 50%,rgba(255,255,255,.03) 75%);
background-size:200% 100%;
animation:shimmer 1.5s infinite;
}

@media(max-width:900px){.hero-grid,.about,.contact-wrap{grid-template-columns:1fr}.grid-3,.portfolio-grid{grid-template-columns:1fr 1fr}}
@media(max-width:700px){.nav-links{display:none}.grid-3,.portfolio-grid,form .row{grid-template-columns:1fr}.hero{padding-top:60px}.chat-panel{width:calc(100vw - 32px)}}
</style>
</head>
<body>

<!-- Glow orbs -->
<div class="orb orb1"></div>
<div class="orb orb2"></div>
<div class="orb orb3"></div>

<nav>
<div class="container nav-inner">
<a href="#home" class="logo">
  <div class="logo-mark">K</div>
  Kod<span>Atlas</span>
</a>

<ul class="nav-links">
<li><a href="#services">Hizmetler</a></li>
<li><a href="#about">Hakkımızda</a></li>
<li><a href="#portfolio">Portfolyo</a></li>
<li><a href="#contact">İletişim</a></li>
</ul>

<div class="nav-actions">
<button class="btn btn-outline" id="loginBtn" onclick="openModal('loginModal')">Giriş</button>
<button class="btn btn-primary" id="registerBtn" onclick="openModal('registerModal')">Kayıt Ol</button>
<div class="user-chip hidden" id="userChip"></div>
<button class="btn btn-outline hidden" id="adminBtn" onclick="window.location.href='admin/'">Admin</button>
<button class="btn btn-outline hidden" id="logoutBtn" onclick="logoutUser()">Çıkış</button>
</div>
</div>
</nav>

<header class="hero" id="home">
<div class="container hero-grid">
<div>
<div class="badge"><span class="badge-dot"></span> Kurumsal Yazılım • Web • Mobil • E-Ticaret</div>
<h1>Resmi, güçlü ve modern <span class="gradient">yazılım çözümleri</span></h1>
<p>KodAtlas olarak kurumsal web siteleri, e-ticaret sistemleri, mobil uygulamalar ve özel yazılım projeleri geliştiriyoruz. Hızlı, güvenli ve prestijli çözümler sunuyoruz.</p>
<div class="hero-actions">
<a href="#contact" class="btn btn-primary">Ücretsiz Teklif Al</a>
<a href="#portfolio" class="btn btn-outline">Projelerimizi İncele</a>
</div>
</div>

<div class="hero-card">
<h2 style="font-size:26px;margin-bottom:10px;font-weight:800">KodAtlas ile dijital görünümünüzü güçlendirin</h2>
<p style="color:var(--muted);font-size:14px">Şirketiniz için güven veren, resmi duruşa sahip, yüksek performanslı ve modern dijital ürünler geliştiriyoruz.</p>
<div class="mini">
<div class="mini-box"><div style="font-size:11px;color:var(--muted);margin-bottom:4px">// teslim edilen proje</div><h3>150+</h3></div>
<div class="mini-box"><div style="font-size:11px;color:var(--muted);margin-bottom:4px">// memnuniyet</div><h3>%98</h3></div>
<div class="mini-box"><div style="font-size:11px;color:var(--muted);margin-bottom:4px">// destek</div><h3>7/24</h3></div>
<div class="mini-box"><div style="font-size:11px;color:var(--muted);margin-bottom:4px">// deneyim</div><h3>12 Yıl</h3></div>
</div>
</div>
</div>
</header>

<section class="section" id="services">
<div class="container">
<div class="section-head">
<div class="kicker">// hizmetlerimiz</div>
<h2>İşinizi büyüten <span class="gradient">profesyonel çözümler</span></h2>
<p>Web sitesi yapmak bizim ana işimizdir. Bunun yanında e-ticaret, özel yazılım ve mobil uygulama çözümleri de sunuyoruz.</p>
</div>
<div class="grid-3">
<div class="card"><div class="icon">🌐</div><h3>Kurumsal Web Sitesi</h3><p>Şirketiniz için güven veren, modern, hızlı ve mobil uyumlu kurumsal web siteleri tasarlıyoruz.</p></div>
<div class="card"><div class="icon">🛒</div><h3>E-Ticaret Çözümleri</h3><p>Satış odaklı, ödeme sistemli, panel destekli e-ticaret siteleri geliştiriyoruz.</p></div>
<div class="card"><div class="icon">📱</div><h3>Mobil Uygulama</h3><p>Android ve iOS için hızlı, sade ve kullanıcı odaklı mobil uygulamalar geliştiriyoruz.</p></div>
<div class="card"><div class="icon">⚙️</div><h3>Özel Yazılım</h3><p>İş akışınıza özel yönetim panelleri, CRM sistemleri ve veritabanlı çözümler hazırlıyoruz.</p></div>
<div class="card"><div class="icon">🔐</div><h3>Güvenlik ve Performans</h3><p>Projelerinizi yüksek performanslı, güvenli ve uzun vadeli bakım yapılabilir şekilde kuruyoruz.</p></div>
<div class="card"><div class="icon">📈</div><h3>SEO ve Kurumsal Görünüm</h3><p>Google uyumlu, profesyonel ve prestijli görünüm sunan tasarımlar oluşturuyoruz.</p></div>
</div>
</div>
</section>

<section class="section" id="about">
<div class="container about">
<div class="about-box">
<div class="kicker">// hakkımızda</div>
<h2 style="font-size:38px;margin:10px 0 14px;letter-spacing:-1px">KodAtlas neden tercih ediliyor?</h2>
<p style="color:var(--muted)">Resmi bir marka dili, güçlü tasarım anlayışı ve sağlam yazılım mimarisi ile çalışıyoruz.</p>
<ul>
<li>✅ Hızlı açılan, hafif ve modern arayüzler</li>
<li>✅ MySQL tabanlı kayıt ve giriş sistemleri</li>
<li>✅ Kurumsal renk uyumu ve prestijli tasarım dili</li>
<li>✅ Yönetim paneli ve özel yazılım entegrasyonları</li>
</ul>
</div>
<div class="about-box">
<div class="kicker">// teknoloji</div>
<h2 style="font-size:38px;margin:10px 0 14px;letter-spacing:-1px">Yapımız güçlü ve ölçeklenebilir</h2>
<p style="color:var(--muted)">PHP, MySQL, yönetim panelleri, kurumsal arayüzler ve özel sistemlerle şirketinizin dijital altyapısını kuruyoruz.</p>
<div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:18px">
<span class="btn btn-outline" style="padding:7px 14px;font-size:13px">PHP</span>
<span class="btn btn-outline" style="padding:7px 14px;font-size:13px">MySQL</span>
<span class="btn btn-outline" style="padding:7px 14px;font-size:13px">Admin Panel</span>
<span class="btn btn-outline" style="padding:7px 14px;font-size:13px">Responsive</span>
<span class="btn btn-outline" style="padding:7px 14px;font-size:13px">SEO</span>
<span class="btn btn-outline" style="padding:7px 14px;font-size:13px">Kurumsal UI</span>
</div>
</div>
</div>
</section>

<section class="section" id="portfolio">
<div class="container">
<div class="section-head">
<div class="kicker">// portfolyo</div>
<h2>Hazırladığımız <span class="gradient">örnek işler</span></h2>
<p>Farklı sektörler için hazırladığımız projelerden bazı örnekler.</p>
</div>
<div class="portfolio-grid">
<div class="project"><div class="project-cover" style="background:linear-gradient(135deg,#0a1628,#0d2847)">🏢</div><div class="project-body"><div class="tag">// KURUMSAL SİTE</div><h3>Hukuk Bürosu Web Sitesi</h3><p>Güven veren, resmi ve prestijli kurumsal görünüm.</p></div></div>
<div class="project"><div class="project-cover" style="background:linear-gradient(135deg,#0d1b2a,#0a2540)">🛍️</div><div class="project-body"><div class="tag">// E-TİCARET</div><h3>Online Satış Platformu</h3><p>Ürün yönetimi, ödeme sistemi ve kullanıcı paneli destekli yapı.</p></div></div>
<div class="project"><div class="project-cover" style="background:linear-gradient(135deg,#0f1729,#152040)">📱</div><div class="project-body"><div class="tag">// MOBİL UYGULAMA</div><h3>Rezervasyon Uygulaması</h3><p>Basit, hızlı ve kullanıcı dostu mobil deneyim.</p></div></div>
</div>
</div>
</section>

<section class="section" id="contact">
<div class="container">
<div class="section-head">
<div class="kicker">// iletişim</div>
<h2>Projenizi bizimle <span class="gradient">paylaşın</span></h2>
<p>Formu doldurun, size dönüş sağlayalım.</p>
</div>
<div class="contact-wrap">
<div class="info-box">
<h3 style="font-size:24px;margin-bottom:12px;font-weight:800">KodAtlas İletişim</h3>
<p style="color:var(--muted)">Kurumsal web sitesi, özel yazılım veya e-ticaret projeniz için bize ulaşabilirsiniz.</p>
<div class="info-list">
<div class="info-item"><strong>E-posta:</strong><br><span style="color:var(--cyan)">info@kodatlas.com</span></div>
<div class="info-item"><strong>Telefon:</strong><br><span style="color:var(--cyan)">+90 212 000 00 00</span></div>
<div class="info-item"><strong>Konum:</strong><br>İstanbul / Türkiye</div>
</div>
</div>
<div class="form-box">
<form id="contactForm">
<div class="row">
<input class="input" type="text" name="name" placeholder="Ad Soyad" required>
<input class="input" type="email" name="email" placeholder="E-posta" required>
</div>
<div class="row" style="margin-top:12px">
<input class="input" type="text" name="phone" placeholder="Telefon">
<input class="input" type="text" name="subject" placeholder="Konu">
</div>
<div style="margin-top:12px">
<textarea class="input" name="message" placeholder="Mesajınız" required></textarea>
</div>
<div style="margin-top:12px">
<button class="btn btn-primary" type="submit" style="width:100%">Mesaj Gönder</button>
</div>
</form>
</div>
</div>
</div>
</section>

<footer>
<div class="container" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px">
<span>© 2026 KodAtlas Yazılım Şirketi. Tüm hakları saklıdır.</span>
<span style="font-family:'JetBrains Mono',monospace;font-size:12px;color:rgba(0,229,255,.4)">v3.1 // build 2026</span>
</div>
</footer>

<!-- ══════════════════════════════════════════════════════
     LOGIN MODAL
══════════════════════════════════════════════════════ -->
<div class="modal" id="loginModal">
<div class="modal-card">
<div class="modal-head">
<h3>Giriş Yap</h3>
<button class="close-btn" onclick="closeModal('loginModal')">✕</button>
</div>
<small>Hesabınıza giriş yapın</small>

<form id="loginForm" style="margin-top:18px">
<div style="margin-top:12px">
<input class="input" type="email" name="email" placeholder="E-posta adresi" required>
</div>
<div style="margin-top:10px">
<input class="input" type="password" name="password" placeholder="Şifre" required>
</div>
<div style="margin-top:14px">
<button class="btn btn-primary" type="submit" style="width:100%" id="loginSubmitBtn">Giriş Yap</button>
</div>
</form>

<div class="modal-footer">
Hesabınız yok mu? <a onclick="switchModal('loginModal','registerModal')">Kayıt ol</a>
</div>
</div>
</div>

<!-- ══════════════════════════════════════════════════════
     REGISTER MODAL
══════════════════════════════════════════════════════ -->
<div class="modal" id="registerModal">
<div class="modal-card">
<div class="modal-head">
<h3>Kayıt Ol</h3>
<button class="close-btn" onclick="closeModal('registerModal')">✕</button>
</div>
<small>Yeni hesap oluşturun</small>

<!-- STEP 1: Register Form -->
<div id="registerStep1">
<form id="registerForm" style="margin-top:18px">
<div class="row">
<input class="input" type="text" name="first_name" placeholder="Ad" required>
<input class="input" type="text" name="last_name" placeholder="Soyad" required>
</div>
<div style="margin-top:10px">
<input class="input" type="email" name="email" placeholder="E-posta adresi" required>
</div>
<!-- Phone with country code -->
<div style="margin-top:10px">
<div class="phone-wrap">
<select class="country-select" name="phone_country_code" id="countryCodeSelect">
  <option value="+90" data-flag="🇹🇷">🇹🇷 +90</option>
  <option value="+1" data-flag="🇺🇸">🇺🇸 +1</option>
  <option value="+44" data-flag="🇬🇧">🇬🇧 +44</option>
  <option value="+49" data-flag="🇩🇪">🇩🇪 +49</option>
  <option value="+33" data-flag="🇫🇷">🇫🇷 +33</option>
  <option value="+39" data-flag="🇮🇹">🇮🇹 +39</option>
  <option value="+34" data-flag="🇪🇸">🇪🇸 +34</option>
  <option value="+31" data-flag="🇳🇱">🇳🇱 +31</option>
  <option value="+46" data-flag="🇸🇪">🇸🇪 +46</option>
  <option value="+47" data-flag="🇳🇴">🇳🇴 +47</option>
  <option value="+45" data-flag="🇩🇰">🇩🇰 +45</option>
  <option value="+358" data-flag="🇫🇮">🇫🇮 +358</option>
  <option value="+48" data-flag="🇵🇱">🇵🇱 +48</option>
  <option value="+7" data-flag="🇷🇺">🇷🇺 +7</option>
  <option value="+380" data-flag="🇺🇦">🇺🇦 +380</option>
  <option value="+30" data-flag="🇬🇷">🇬🇷 +30</option>
  <option value="+40" data-flag="🇷🇴">🇷🇴 +40</option>
  <option value="+36" data-flag="🇭🇺">🇭🇺 +36</option>
  <option value="+420" data-flag="🇨🇿">🇨🇿 +420</option>
  <option value="+43" data-flag="🇦🇹">🇦🇹 +43</option>
  <option value="+41" data-flag="🇨🇭">🇨🇭 +41</option>
  <option value="+32" data-flag="🇧🇪">🇧🇪 +32</option>
  <option value="+351" data-flag="🇵🇹">🇵🇹 +351</option>
  <option value="+353" data-flag="🇮🇪">🇮🇪 +353</option>
  <option value="+90">🇹🇷 +90</option>
  <option value="+966" data-flag="🇸🇦">🇸🇦 +966</option>
  <option value="+971" data-flag="🇦🇪">🇦🇪 +971</option>
  <option value="+974" data-flag="🇶🇦">🇶🇦 +974</option>
  <option value="+965" data-flag="🇰🇼">🇰🇼 +965</option>
  <option value="+20" data-flag="🇪🇬">🇪🇬 +20</option>
  <option value="+212" data-flag="🇲🇦">🇲🇦 +212</option>
  <option value="+27" data-flag="🇿🇦">🇿🇦 +27</option>
  <option value="+91" data-flag="🇮🇳">🇮🇳 +91</option>
  <option value="+86" data-flag="🇨🇳">🇨🇳 +86</option>
  <option value="+81" data-flag="🇯🇵">🇯🇵 +81</option>
  <option value="+82" data-flag="🇰🇷">🇰🇷 +82</option>
  <option value="+65" data-flag="🇸🇬">🇸🇬 +65</option>
  <option value="+60" data-flag="🇲🇾">🇲🇾 +60</option>
  <option value="+62" data-flag="🇮🇩">🇮🇩 +62</option>
  <option value="+55" data-flag="🇧🇷">🇧🇷 +55</option>
  <option value="+52" data-flag="🇲🇽">🇲🇽 +52</option>
  <option value="+54" data-flag="🇦🇷">🇦🇷 +54</option>
  <option value="+61" data-flag="🇦🇺">🇦🇺 +61</option>
  <option value="+64" data-flag="🇳🇿">🇳🇿 +64</option>
  <option value="+1-CA" data-flag="🇨🇦">🇨🇦 +1</option>
</select>
<input class="input phone-input" type="tel" name="phone" placeholder="Telefon numarası">
</div>
</div>
<div style="margin-top:10px">
<input class="input" type="text" name="company" placeholder="Şirket adı (isteğe bağlı)">
</div>
<div style="margin-top:10px">
<input class="input" type="password" name="password" placeholder="Şifre (min. 6 karakter)" required>
</div>
<div style="margin-top:14px">
<button class="btn btn-primary" type="submit" style="width:100%" id="registerSubmitBtn">
  <span>Doğrulama Kodu Gönder</span>
  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2L15 22 11 13 2 9l20-7z"/></svg>
</button>
</div>
</form>
<div class="modal-footer">
Zaten hesabınız var mı? <a onclick="switchModal('registerModal','loginModal')">Giriş yap</a>
</div>
</div>

<!-- STEP 2: Email Verification -->
<div id="registerStep2" class="verify-step" style="margin-top:16px">
<div style="text-align:center;margin-bottom:20px">
  <div style="font-size:48px;margin-bottom:10px">📧</div>
  <h4 style="font-size:17px;font-weight:800">E-posta Doğrulama</h4>
  <p style="color:var(--muted);font-size:13px;margin-top:6px">
    <span id="verifyEmailDisplay"></span><br>adresine 6 haneli kod gönderdik
  </p>
</div>
<div class="code-inputs" id="codeInputs">
  <input class="code-input" maxlength="1" type="text" inputmode="numeric" pattern="[0-9]">
  <input class="code-input" maxlength="1" type="text" inputmode="numeric" pattern="[0-9]">
  <input class="code-input" maxlength="1" type="text" inputmode="numeric" pattern="[0-9]">
  <input class="code-input" maxlength="1" type="text" inputmode="numeric" pattern="[0-9]">
  <input class="code-input" maxlength="1" type="text" inputmode="numeric" pattern="[0-9]">
  <input class="code-input" maxlength="1" type="text" inputmode="numeric" pattern="[0-9]">
</div>
<div class="code-timer">Kodun geçerliliği: <span id="timerDisplay">15:00</span></div>
<div id="devCodeHint" style="text-align:center;margin-top:10px;padding:8px;background:rgba(0,229,255,.08);border:1px solid rgba(0,229,255,.2);border-radius:8px;font-family:'JetBrains Mono',monospace;font-size:12px;display:none">
  🛠️ Dev Mode — Kod: <strong id="devCodeValue" style="color:var(--cyan)"></strong>
</div>
<div style="margin-top:16px">
  <button class="btn btn-primary" onclick="submitVerification()" style="width:100%" id="verifyBtn">Doğrula ve Kayıt Ol</button>
</div>
<div style="margin-top:10px;text-align:center">
  <a style="color:var(--cyan);cursor:pointer;font-size:13px" onclick="showRegisterStep1()">← Geri dön</a>
  &nbsp;·&nbsp;
  <a style="color:var(--muted);cursor:pointer;font-size:13px" id="resendBtn" onclick="resendCode()">Kodu tekrar gönder</a>
</div>
</div>

</div>
</div>

<!-- ══════════════════════════════════════════════════════
     LIVE CHAT WIDGET
══════════════════════════════════════════════════════ -->
<div id="chatWidget">
  <div class="chat-panel" id="chatPanel">
    <!-- Start form -->
    <div id="chatStartForm">
      <div class="chat-header">
        <div class="chat-avatar">💬</div>
        <div class="chat-header-info">
          <div class="name">KodAtlas Destek</div>
          <div class="status"><span class="status-dot"></span> Çevrimiçi</div>
        </div>
        <button class="chat-close" onclick="toggleChat()">✕</button>
      </div>
      <div class="chat-start">
        <h4>Merhaba! 👋</h4>
        <p>Size nasıl yardımcı olabiliriz? Adınızı girerek sohbeti başlatın.</p>
        <div style="display:flex;flex-direction:column;gap:8px">
          <input class="input" type="text" id="chatName" placeholder="Adınız" style="font-size:13px">
          <input class="input" type="email" id="chatEmail" placeholder="E-posta (isteğe bağlı)" style="font-size:13px">
          <button class="btn btn-primary" onclick="startChat()" style="width:100%;margin-top:4px">
            Sohbeti Başlat
          </button>
        </div>
      </div>
    </div>

    <!-- Chat area -->
    <div id="chatArea" style="display:none;flex-direction:column;height:100%">
      <div class="chat-header">
        <div class="chat-avatar">💬</div>
        <div class="chat-header-info">
          <div class="name">KodAtlas Destek</div>
          <div class="status"><span class="status-dot"></span> Çevrimiçi</div>
        </div>
        <button class="chat-close" onclick="toggleChat()">✕</button>
      </div>
      <div class="chat-messages" id="chatMessages">
        <div class="chat-typing" id="chatTyping">
          <div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div>
        </div>
      </div>
      <div class="chat-input-area" id="chatInputArea">
        <textarea class="chat-input" id="chatInput" placeholder="Mesajınızı yazın..." rows="1" onkeydown="chatKeyDown(event)"></textarea>
        <button class="chat-send" onclick="sendChatMessage()">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M2 21L23 12 2 3v7l15 2-15 2z"/></svg>
        </button>
      </div>
      <div class="chat-closed-msg" id="chatClosedMsg" style="display:none">Sohbet kapatıldı. Tekrar açmak için sayfayı yenileyin.</div>
    </div>
  </div>

  <button class="chat-toggle" onclick="toggleChat()" title="Canlı Destek">
    <span class="chat-badge" id="chatBadge">0</span>
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
  </button>
</div>

<div class="toast-wrap" id="toastWrap"></div>

<script>
// ══════════════════════════════════════════════
// MODAL HELPERS
// ══════════════════════════════════════════════
function openModal(id){document.getElementById(id).classList.add('show')}
function closeModal(id){document.getElementById(id).classList.remove('show')}
function switchModal(closeId,openId){closeModal(closeId);setTimeout(()=>openModal(openId),150)}
window.addEventListener('click',function(e){
  document.querySelectorAll('.modal').forEach(m=>{if(e.target===m)m.classList.remove('show')});
});

// ══════════════════════════════════════════════
// TOAST
// ══════════════════════════════════════════════
function showToast(message,type='info'){
  const wrap=document.getElementById('toastWrap');
  const div=document.createElement('div');
  div.className='toast '+type;
  const icons={success:'✅',error:'❌',info:'💡'};
  div.innerHTML=`<span class="toast-icon">${icons[type]||'ℹ️'}</span>${message}`;
  wrap.appendChild(div);
  setTimeout(()=>{div.style.animation='toastOut .3s ease forwards';setTimeout(()=>div.remove(),300)},3200);
}

// ══════════════════════════════════════════════
// USER SESSION
// ══════════════════════════════════════════════
function setLoggedInUser(user){
  document.getElementById('loginBtn').classList.add('hidden');
  document.getElementById('registerBtn').classList.add('hidden');
  document.getElementById('logoutBtn').classList.remove('hidden');
  const chip=document.getElementById('userChip');
  chip.classList.remove('hidden');
  chip.innerHTML='👤 '+user.full_name;
  if(user.role==='admin'||user.role==='manager'){
    document.getElementById('adminBtn').classList.remove('hidden');
  }
  // Pre-fill chat name
  document.getElementById('chatName').value=user.full_name||'';
}
function setLoggedOutUser(){
  document.getElementById('loginBtn').classList.remove('hidden');
  document.getElementById('registerBtn').classList.remove('hidden');
  document.getElementById('logoutBtn').classList.add('hidden');
  document.getElementById('adminBtn').classList.add('hidden');
  document.getElementById('userChip').classList.add('hidden');
}
async function checkSession(){
  try{
    const res=await fetch('api/session.php');
    const data=await res.json();
    if(data.logged_in)setLoggedInUser(data);
    else setLoggedOutUser();
  }catch(e){setLoggedOutUser()}
}

// ══════════════════════════════════════════════
// REGISTER - STEP 1: Send verification
// ══════════════════════════════════════════════
let pendingEmail='';
let verifyTimer=null;

document.getElementById('registerForm').addEventListener('submit',async function(e){
  e.preventDefault();
  const btn=document.getElementById('registerSubmitBtn');
  btn.disabled=true;btn.innerHTML='<span>Gönderiliyor...</span>';

  const fd=new FormData(this);
  const payload={
    first_name:fd.get('first_name'),
    last_name:fd.get('last_name'),
    email:fd.get('email'),
    phone:fd.get('phone'),
    phone_country_code:fd.get('phone_country_code'),
    company:fd.get('company'),
    password:fd.get('password')
  };

  try{
    const res=await fetch('api/send_verification.php',{
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body:JSON.stringify(payload)
    });
    const data=await res.json();
    if(data.success){
      pendingEmail=payload.email;
      showVerifyStep(data.data);
      showToast('Doğrulama kodu gönderildi!','success');
    }else{
      showToast(data.message,'error');
    }
  }catch(err){
    showToast('Bağlantı hatası oluştu','error');
  }
  btn.disabled=false;
  btn.innerHTML='<span>Doğrulama Kodu Gönder</span><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2L15 22 11 13 2 9l20-7z"/></svg>';
});

function showVerifyStep(devData){
  document.getElementById('registerStep1').style.display='none';
  const step2=document.getElementById('registerStep2');
  step2.classList.add('show');
  document.getElementById('verifyEmailDisplay').textContent=pendingEmail;
  
  // Dev code hint
  if(devData&&devData.dev_code){
    document.getElementById('devCodeHint').style.display='block';
    document.getElementById('devCodeValue').textContent=devData.dev_code;
  }
  
  // Focus first input
  document.querySelectorAll('.code-input')[0].focus();
  
  // Start timer
  startVerifyTimer(15*60);
}

function showRegisterStep1(){
  document.getElementById('registerStep1').style.display='block';
  document.getElementById('registerStep2').classList.remove('show');
  clearInterval(verifyTimer);
  // Clear code inputs
  document.querySelectorAll('.code-input').forEach(i=>i.value='');
}

function startVerifyTimer(seconds){
  clearInterval(verifyTimer);
  let remaining=seconds;
  function update(){
    const m=Math.floor(remaining/60);
    const s=remaining%60;
    document.getElementById('timerDisplay').textContent=`${m}:${s.toString().padStart(2,'0')}`;
    if(remaining<=0){clearInterval(verifyTimer);document.getElementById('timerDisplay').textContent='Süresi doldu';}
    remaining--;
  }
  update();
  verifyTimer=setInterval(update,1000);
}

async function resendCode(){
  const form=document.getElementById('registerForm');
  const fd=new FormData(form);
  const payload={
    first_name:fd.get('first_name'),last_name:fd.get('last_name'),
    email:fd.get('email'),phone:fd.get('phone'),
    phone_country_code:fd.get('phone_country_code'),
    company:fd.get('company'),password:fd.get('password')
  };
  try{
    const res=await fetch('api/send_verification.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(payload)});
    const data=await res.json();
    if(data.success){
      showToast('Kod yeniden gönderildi','info');
      startVerifyTimer(15*60);
      if(data.data&&data.data.dev_code){
        document.getElementById('devCodeValue').textContent=data.data.dev_code;
        document.getElementById('devCodeHint').style.display='block';
      }
    }
  }catch(e){showToast('Hata','error')}
}

// Code input auto-advance
document.querySelectorAll('.code-input').forEach((input,i,inputs)=>{
  input.addEventListener('input',function(){
    this.value=this.value.replace(/[^0-9]/g,'').slice(0,1);
    if(this.value&&i<inputs.length-1)inputs[i+1].focus();
    if(i===inputs.length-1&&this.value)submitVerification();
  });
  input.addEventListener('keydown',function(e){
    if(e.key==='Backspace'&&!this.value&&i>0)inputs[i-1].focus();
    if(e.key==='ArrowLeft'&&i>0)inputs[i-1].focus();
    if(e.key==='ArrowRight'&&i<inputs.length-1)inputs[i+1].focus();
  });
  input.addEventListener('paste',function(e){
    e.preventDefault();
    const paste=(e.clipboardData||window.clipboardData).getData('text').replace(/\D/g,'');
    inputs.forEach((inp,j)=>{if(paste[j])inp.value=paste[j]});
    inputs[Math.min(paste.length,inputs.length-1)].focus();
    if(paste.length>=6)submitVerification();
  });
});

async function submitVerification(){
  const code=Array.from(document.querySelectorAll('.code-input')).map(i=>i.value).join('');
  if(code.length!==6){showToast('6 haneli kodu eksiksiz girin','error');return;}
  
  const btn=document.getElementById('verifyBtn');
  btn.disabled=true;btn.textContent='Doğrulanıyor...';
  
  try{
    const res=await fetch('api/verify_register.php',{
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body:JSON.stringify({email:pendingEmail,code})
    });
    const data=await res.json();
    if(data.success){
      showToast(data.message,'success');
      closeModal('registerModal');
      document.getElementById('registerForm').reset();
      showRegisterStep1();
      setLoggedInUser(data.data);
    }else{
      showToast(data.message,'error');
      document.querySelectorAll('.code-input').forEach(i=>{
        i.style.borderColor='var(--red)';
        setTimeout(()=>i.style.borderColor='',1000);
      });
    }
  }catch(err){
    showToast('Bağlantı hatası','error');
  }
  btn.disabled=false;btn.textContent='Doğrula ve Kayıt Ol';
}

// ══════════════════════════════════════════════
// LOGIN
// ══════════════════════════════════════════════
document.getElementById('loginForm').addEventListener('submit',async function(e){
  e.preventDefault();
  const btn=document.getElementById('loginSubmitBtn');
  btn.disabled=true;btn.textContent='Giriş yapılıyor...';
  
  const fd=new FormData(this);
  try{
    const res=await fetch('api/login.php',{
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body:JSON.stringify({email:fd.get('email'),password:fd.get('password')})
    });
    const data=await res.json();
    if(data.success){
      showToast(data.message,'success');
      closeModal('loginModal');
      this.reset();
      setLoggedInUser(data.data);
    }else{
      showToast(data.message,'error');
    }
  }catch(err){showToast('Bağlantı hatası','error')}
  btn.disabled=false;btn.textContent='Giriş Yap';
});

async function logoutUser(){
  try{await fetch('api/logout.php');setLoggedOutUser();showToast('Çıkış yapıldı','info')}
  catch(err){showToast('Çıkış işlemi başarısız','error')}
}

// ══════════════════════════════════════════════
// CONTACT FORM
// ══════════════════════════════════════════════
document.getElementById('contactForm').addEventListener('submit',async function(e){
  e.preventDefault();
  const fd=new FormData(this);
  try{
    const res=await fetch('api/contact.php',{
      method:'POST',headers:{'Content-Type':'application/json'},
      body:JSON.stringify({name:fd.get('name'),email:fd.get('email'),phone:fd.get('phone'),subject:fd.get('subject'),message:fd.get('message')})
    });
    const data=await res.json();
    if(data.success){showToast(data.message,'success');this.reset();}
    else showToast(data.message,'error');
  }catch(err){showToast('Mesaj gönderilirken hata oluştu','error')}
});

// ══════════════════════════════════════════════
// LIVE CHAT
// ══════════════════════════════════════════════
let chatToken=null;
let chatSessionId=null;
let lastMsgId=0;
let chatPollInterval=null;
let chatOpen=false;
let unreadCount=0;

function toggleChat(){
  chatOpen=!chatOpen;
  const panel=document.getElementById('chatPanel');
  if(chatOpen){
    panel.classList.add('open');
    unreadCount=0;
    updateChatBadge();
  }else{
    panel.classList.remove('open');
  }
}

function updateChatBadge(){
  const badge=document.getElementById('chatBadge');
  if(unreadCount>0){
    badge.style.display='flex';
    badge.textContent=unreadCount;
  }else{
    badge.style.display='none';
  }
}

async function startChat(){
  const name=document.getElementById('chatName').value.trim()||'Ziyaretçi';
  const email=document.getElementById('chatEmail').value.trim();
  
  try{
    const res=await fetch('api/chat.php?action=start',{
      method:'POST',headers:{'Content-Type':'application/json'},
      body:JSON.stringify({name,email})
    });
    const data=await res.json();
    if(data.success){
      chatToken=data.data.token;
      chatSessionId=data.data.session_id;
      document.getElementById('chatStartForm').style.display='none';
      const area=document.getElementById('chatArea');
      area.style.display='flex';
      area.style.flexDirection='column';
      
      // Start polling
      pollChatMessages();
      chatPollInterval=setInterval(pollChatMessages,2000);
    }else{
      showToast(data.message,'error');
    }
  }catch(e){showToast('Bağlantı hatası','error')}
}

async function pollChatMessages(){
  if(!chatToken)return;
  try{
    const res=await fetch(`api/chat.php?action=messages&token=${chatToken}&since=${lastMsgId}`);
    const data=await res.json();
    if(data.success){
      data.data.messages.forEach(renderChatMsg);
      if(data.data.status==='closed'){
        document.getElementById('chatInputArea').style.display='none';
        document.getElementById('chatClosedMsg').style.display='block';
        clearInterval(chatPollInterval);
      }
    }
  }catch(e){}
}

function renderChatMsg(msg){
  if(msg.id<=lastMsgId)return;
  lastMsgId=msg.id;
  
  const container=document.getElementById('chatMessages');
  const div=document.createElement('div');
  div.className='msg-bubble '+msg.sender_type;
  
  const time=new Date(msg.created_at).toLocaleTimeString('tr-TR',{hour:'2-digit',minute:'2-digit'});
  div.innerHTML=`<div>${escapeHtml(msg.message)}</div><div class="msg-time">${msg.sender_name||''} ${time}</div>`;
  container.insertBefore(div,document.getElementById('chatTyping'));
  container.scrollTop=container.scrollHeight;
  
  if(!chatOpen&&msg.sender_type==='admin'){
    unreadCount++;
    updateChatBadge();
  }
}

async function sendChatMessage(){
  const input=document.getElementById('chatInput');
  const msg=input.value.trim();
  if(!msg||!chatToken)return;
  
  input.value='';
  
  try{
    await fetch('api/chat.php?action=send',{
      method:'POST',headers:{'Content-Type':'application/json'},
      body:JSON.stringify({token:chatToken,message:msg})
    });
    pollChatMessages();
  }catch(e){}
}

function chatKeyDown(e){
  if(e.key==='Enter'&&!e.shiftKey){e.preventDefault();sendChatMessage();}
}

function escapeHtml(text){
  const div=document.createElement('div');
  div.appendChild(document.createTextNode(text));
  return div.innerHTML;
}

// Init
checkSession();
</script>
</body>
</html>