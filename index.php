<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>KodAtlas | Yazılım Şirketi</title>
<meta name="description" content="KodAtlas yazılım şirketi. Kurumsal web sitesi, e-ticaret, mobil uygulama ve özel yazılım çözümleri.">
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{
--bg:#07111f;
--bg2:#0b1728;
--card:rgba(255,255,255,.05);
--line:rgba(255,255,255,.09);
--text:#ecf3ff;
--muted:#94a3b8;
--cyan:#22d3ee;
--blue:#3b82f6;
--green:#22c55e;
--red:#ef4444;
}
html{scroll-behavior:smooth}
body{
font-family:Arial,sans-serif;
background:
radial-gradient(circle at top left, rgba(34,211,238,.10), transparent 30%),
radial-gradient(circle at bottom right, rgba(59,130,246,.10), transparent 30%),
linear-gradient(180deg,var(--bg),var(--bg2));
color:var(--text);
line-height:1.6;
}
.container{width:min(1180px,92%);margin:auto}
nav{
position:sticky;top:0;z-index:50;
background:rgba(7,17,31,.85);
backdrop-filter:blur(10px);
border-bottom:1px solid var(--line)
}
.nav-inner{display:flex;align-items:center;justify-content:space-between;padding:16px 0;gap:20px}
.logo{font-size:24px;font-weight:800;text-decoration:none;color:#fff}
.logo span{color:var(--cyan)}
.nav-links{display:flex;gap:24px;list-style:none}
.nav-links a{text-decoration:none;color:var(--muted);font-size:14px}
.nav-links a:hover{color:#fff}
.nav-actions{display:flex;gap:10px;align-items:center;flex-wrap:wrap}
.btn{
border:none;cursor:pointer;text-decoration:none;
display:inline-flex;align-items:center;justify-content:center;
gap:8px;padding:12px 22px;border-radius:999px;
font-weight:700;transition:.25s
}
.btn-primary{background:linear-gradient(135deg,var(--cyan),var(--blue));color:#02131d}
.btn-primary:hover{transform:translateY(-2px);opacity:.95}
.btn-outline{background:transparent;color:#fff;border:1px solid var(--line)}
.btn-outline:hover{border-color:var(--cyan);color:var(--cyan)}
.hero{padding:90px 0 70px}
.hero-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:40px;align-items:center}
.badge{
display:inline-block;padding:8px 14px;border-radius:999px;
background:rgba(34,211,238,.08);border:1px solid rgba(34,211,238,.2);
color:var(--cyan);font-size:13px;font-weight:700;margin-bottom:18px
}
h1{
font-size:clamp(38px,6vw,70px);
line-height:1.05;
margin-bottom:18px;
letter-spacing:-1.6px
}
.gradient{
background:linear-gradient(135deg,var(--cyan),var(--blue));
-webkit-background-clip:text;
-webkit-text-fill-color:transparent;
}
.hero p{color:var(--muted);font-size:18px;max-width:620px;margin-bottom:28px}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap}
.hero-card{
background:var(--card);border:1px solid var(--line);
border-radius:24px;padding:30px;min-height:360px;
display:flex;flex-direction:column;justify-content:center;
box-shadow:0 20px 50px rgba(0,0,0,.25)
}
.hero-card .mini{
display:grid;grid-template-columns:repeat(2,1fr);gap:14px;margin-top:20px
}
.mini-box{
background:rgba(255,255,255,.04);
border:1px solid var(--line);
border-radius:18px;padding:18px
}
.mini-box h3{font-size:28px;color:var(--cyan)}
.section{padding:85px 0}
.section-head{text-align:center;margin-bottom:42px}
.kicker{color:var(--cyan);font-size:13px;font-weight:800;letter-spacing:2px;text-transform:uppercase}
.section-head h2{font-size:clamp(30px,4.4vw,48px);margin-top:8px;margin-bottom:10px}
.section-head p{color:var(--muted);max-width:700px;margin:auto}
.grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:22px}
.card{
background:var(--card);
border:1px solid var(--line);
border-radius:24px;
padding:26px;
transition:.25s
}
.card:hover{transform:translateY(-5px);border-color:rgba(34,211,238,.25)}
.icon{
width:56px;height:56px;border-radius:16px;
display:flex;align-items:center;justify-content:center;
font-size:24px;margin-bottom:16px;
background:rgba(34,211,238,.08);border:1px solid rgba(34,211,238,.16)
}
.card h3{margin-bottom:8px;font-size:20px}
.card p{color:var(--muted);font-size:15px}
.about{
display:grid;grid-template-columns:1fr 1fr;gap:34px;align-items:center
}
.about-box{
background:var(--card);border:1px solid var(--line);
border-radius:28px;padding:34px
}
.about-box ul{list-style:none;margin-top:18px;display:grid;gap:12px}
.about-box li{
background:rgba(255,255,255,.04);
border:1px solid var(--line);
border-radius:14px;padding:12px 14px
}
.portfolio-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px}
.project{
background:var(--card);border:1px solid var(--line);
border-radius:24px;overflow:hidden;transition:.25s
}
.project:hover{transform:translateY(-5px);border-color:rgba(34,211,238,.25)}
.project-cover{
height:180px;display:flex;align-items:center;justify-content:center;
font-size:60px
}
.project-body{padding:22px}
.tag{
display:inline-block;font-size:12px;font-weight:700;
color:var(--cyan);margin-bottom:8px
}
.project p{color:var(--muted);font-size:14px}
.contact-wrap{
display:grid;grid-template-columns:1fr 1fr;gap:28px
}
.info-box,.form-box{
background:var(--card);border:1px solid var(--line);
border-radius:24px;padding:28px
}
.info-list{display:grid;gap:14px;margin-top:20px}
.info-item{
padding:14px 16px;border-radius:14px;
border:1px solid var(--line);background:rgba(255,255,255,.04)
}
form .row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.input{
width:100%;padding:14px 16px;border-radius:14px;
border:1px solid var(--line);background:rgba(255,255,255,.04);
color:#fff;outline:none
}
.input:focus{border-color:var(--cyan)}
textarea.input{min-height:130px;resize:vertical}
footer{
border-top:1px solid var(--line);
padding:28px 0;margin-top:20px;color:var(--muted);font-size:14px
}
.user-chip{
display:flex;align-items:center;gap:10px;
padding:10px 14px;border-radius:999px;background:rgba(255,255,255,.04);
border:1px solid var(--line);font-size:14px
}
.hidden{display:none!important}
.modal{
position:fixed;inset:0;background:rgba(0,0,0,.72);
display:none;align-items:center;justify-content:center;
padding:20px;z-index:100
}
.modal.show{display:flex}
.modal-card{
width:min(460px,100%);
background:#0c1626;
border:1px solid var(--line);
border-radius:24px;padding:28px;
box-shadow:0 30px 80px rgba(0,0,0,.45)
}
.modal-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px}
.modal-head h3{font-size:24px}
.close-btn{
width:38px;height:38px;border:none;cursor:pointer;
border-radius:50%;background:rgba(255,255,255,.06);color:#fff
}
.modal small{color:var(--muted)}
.modal-footer{text-align:center;margin-top:14px;color:var(--muted);font-size:14px}
.modal-footer a{color:var(--cyan);cursor:pointer}
.toast-wrap{
position:fixed;right:18px;bottom:18px;z-index:200;
display:flex;flex-direction:column;gap:10px
}
.toast{
min-width:250px;max-width:320px;
padding:14px 16px;border-radius:14px;
background:#0f172a;border:1px solid var(--line);
box-shadow:0 18px 40px rgba(0,0,0,.35)
}
.toast.success{border-color:rgba(34,197,94,.28)}
.toast.error{border-color:rgba(239,68,68,.28)}
.toast.info{border-color:rgba(34,211,238,.28)}
@media (max-width:900px){
.hero-grid,.about,.contact-wrap{grid-template-columns:1fr}
.grid-3,.portfolio-grid{grid-template-columns:1fr 1fr}
}
@media (max-width:700px){
.nav-links{display:none}
.grid-3,.portfolio-grid,form .row{grid-template-columns:1fr}
.hero{padding-top:60px}
.nav-inner{flex-direction:column;align-items:flex-start}
.nav-actions{width:100%}
}
</style>
</head>
<body>

<nav>
<div class="container nav-inner">
<a href="#home" class="logo">Kod<span>Atlas</span></a>

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
<div class="badge">Kurumsal Yazılım • Web • Mobil • E-Ticaret</div>
<h1>Resmi, güçlü ve modern <span class="gradient">yazılım çözümleri</span></h1>
<p>
KodAtlas olarak kurumsal web siteleri, e-ticaret sistemleri, mobil uygulamalar
ve özel yazılım projeleri geliştiriyoruz. Hızlı, güvenli ve prestijli çözümler sunuyoruz.
</p>
<div class="hero-actions">
<a href="#contact" class="btn btn-primary">Ücretsiz Teklif Al</a>
<a href="#portfolio" class="btn btn-outline">Projelerimizi İncele</a>
</div>
</div>

<div class="hero-card">
<h2 style="font-size:30px;margin-bottom:10px">KodAtlas ile dijital görünümünüzü güçlendirin</h2>
<p style="color:var(--muted)">
Şirketiniz için güven veren, resmi duruşa sahip, yüksek performanslı ve modern dijital ürünler geliştiriyoruz.
</p>
<div class="mini">
<div class="mini-box">
<div style="font-size:13px;color:var(--muted)">Teslim edilen proje</div>
<h3>150+</h3>
</div>
<div class="mini-box">
<div style="font-size:13px;color:var(--muted)">Müşteri memnuniyeti</div>
<h3>%98</h3>
</div>
<div class="mini-box">
<div style="font-size:13px;color:var(--muted)">Destek</div>
<h3>7/24</h3>
</div>
<div class="mini-box">
<div style="font-size:13px;color:var(--muted)">Deneyim</div>
<h3>12 Yıl</h3>
</div>
</div>
</div>
</div>
</header>

<section class="section" id="services">
<div class="container">
<div class="section-head">
<div class="kicker">Hizmetlerimiz</div>
<h2>İşinizi büyüten <span class="gradient">profesyonel çözümler</span></h2>
<p>Web sitesi yapmak bizim ana işimizdir. Bunun yanında e-ticaret, özel yazılım ve mobil uygulama çözümleri de sunuyoruz.</p>
</div>

<div class="grid-3">
<div class="card">
<div class="icon">🌐</div>
<h3>Kurumsal Web Sitesi</h3>
<p>Şirketiniz için güven veren, modern, hızlı ve mobil uyumlu kurumsal web siteleri tasarlıyoruz.</p>
</div>
<div class="card">
<div class="icon">🛒</div>
<h3>E-Ticaret Çözümleri</h3>
<p>Satış odaklı, ödeme sistemli, panel destekli e-ticaret siteleri geliştiriyoruz.</p>
</div>
<div class="card">
<div class="icon">📱</div>
<h3>Mobil Uygulama</h3>
<p>Android ve iOS için hızlı, sade ve kullanıcı odaklı mobil uygulamalar geliştiriyoruz.</p>
</div>
<div class="card">
<div class="icon">⚙️</div>
<h3>Özel Yazılım</h3>
<p>İş akışınıza özel yönetim panelleri, CRM sistemleri ve veritabanlı çözümler hazırlıyoruz.</p>
</div>
<div class="card">
<div class="icon">🔐</div>
<h3>Güvenlik ve Performans</h3>
<p>Projelerinizi yüksek performanslı, güvenli ve uzun vadeli bakım yapılabilir şekilde kuruyoruz.</p>
</div>
<div class="card">
<div class="icon">📈</div>
<h3>SEO ve Kurumsal Görünüm</h3>
<p>Google uyumlu, profesyonel ve prestijli görünüm sunan tasarımlar oluşturuyoruz.</p>
</div>
</div>
</div>
</section>

<section class="section" id="about">
<div class="container about">
<div class="about-box">
<div class="kicker">Hakkımızda</div>
<h2 style="font-size:40px;margin:10px 0 14px">KodAtlas neden tercih ediliyor?</h2>
<p style="color:var(--muted)">
Resmi bir marka dili, güçlü tasarım anlayışı ve sağlam yazılım mimarisi ile çalışıyoruz.
Projeleri sadece güzel göstermek için değil, sürdürülebilir ve etkili yapmak için geliştiriyoruz.
</p>
<ul>
<li>✅ Hızlı açılan, hafif ve modern arayüzler</li>
<li>✅ MySQL tabanlı kayıt ve giriş sistemleri</li>
<li>✅ Kurumsal renk uyumu ve prestijli tasarım dili</li>
<li>✅ Yönetim paneli ve özel yazılım entegrasyonları</li>
</ul>
</div>

<div class="about-box">
<div class="kicker">Teknoloji</div>
<h2 style="font-size:40px;margin:10px 0 14px">Yapımız güçlü ve ölçeklenebilir</h2>
<p style="color:var(--muted)">
PHP, MySQL, yönetim panelleri, kurumsal arayüzler ve özel sistemlerle şirketinizin dijital altyapısını kuruyoruz.
</p>
<div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:18px">
<span class="btn btn-outline" style="padding:8px 14px">PHP</span>
<span class="btn btn-outline" style="padding:8px 14px">MySQL</span>
<span class="btn btn-outline" style="padding:8px 14px">Admin Panel</span>
<span class="btn btn-outline" style="padding:8px 14px">Responsive</span>
<span class="btn btn-outline" style="padding:8px 14px">SEO</span>
<span class="btn btn-outline" style="padding:8px 14px">Kurumsal UI</span>
</div>
</div>
</div>
</section>

<section class="section" id="portfolio">
<div class="container">
<div class="section-head">
<div class="kicker">Portfolyo</div>
<h2>Hazırladığımız <span class="gradient">örnek işler</span></h2>
<p>Farklı sektörler için hazırladığımız projelerden bazı örnekler.</p>
</div>

<div class="portfolio-grid">
<div class="project">
<div class="project-cover" style="background:linear-gradient(135deg,#10233b,#0f3b67)">🏢</div>
<div class="project-body">
<div class="tag">Kurumsal Site</div>
<h3>Hukuk Bürosu Web Sitesi</h3>
<p>Güven veren, resmi ve prestijli kurumsal görünüm.</p>
</div>
</div>

<div class="project">
<div class="project-cover" style="background:linear-gradient(135deg,#1d2b53,#0f4c81)">🛍️</div>
<div class="project-body">
<div class="tag">E-Ticaret</div>
<h3>Online Satış Platformu</h3>
<p>Ürün yönetimi, ödeme sistemi ve kullanıcı paneli destekli yapı.</p>
</div>
</div>

<div class="project">
<div class="project-cover" style="background:linear-gradient(135deg,#17223b,#263859)">📱</div>
<div class="project-body">
<div class="tag">Mobil Uygulama</div>
<h3>Rezervasyon Uygulaması</h3>
<p>Basit, hızlı ve kullanıcı dostu mobil deneyim.</p>
</div>
</div>
</div>
</div>
</section>

<section class="section" id="contact">
<div class="container">
<div class="section-head">
<div class="kicker">İletişim</div>
<h2>Projenizi bizimle <span class="gradient">paylaşın</span></h2>
<p>Formu doldurun, size dönüş sağlayalım.</p>
</div>

<div class="contact-wrap">
<div class="info-box">
<h3 style="font-size:26px;margin-bottom:12px">KodAtlas İletişim</h3>
<p style="color:var(--muted)">Kurumsal web sitesi, özel yazılım veya e-ticaret projeniz için bize ulaşabilirsiniz.</p>

<div class="info-list">
<div class="info-item"><strong>E-posta:</strong><br>none</div>
<div class="info-item"><strong>Telefon:</strong><br>+90 </div>
<div class="info-item"><strong>Konum:</strong><br>İstanbul / Türkiye</div>
</div>
</div>

<div class="form-box">
<form id="contactForm">
<div class="row">
<input class="input" type="text" name="name" placeholder="Ad Soyad" required>
<input class="input" type="email" name="email" placeholder="E-posta" required>
</div>
<div class="row" style="margin-top:14px">
<input class="input" type="text" name="phone" placeholder="Telefon">
<input class="input" type="text" name="subject" placeholder="Konu">
</div>
<div style="margin-top:14px">
<textarea class="input" name="message" placeholder="Mesajınız" required></textarea>
</div>
<div style="margin-top:14px">
<button class="btn btn-primary" type="submit" style="width:100%">Mesaj Gönder</button>
</div>
</form>
</div>
</div>
</div>
</section>

<footer>
<div class="container">
© 2026 KodAtlas Yazılım Şirketi. Tüm hakları saklıdır.
</div>
</footer>

<div class="modal" id="loginModal">
<div class="modal-card">
<div class="modal-head">
<h3>Giriş Yap</h3>
<button class="close-btn" onclick="closeModal('loginModal')">✕</button>
</div>
<small>Hesabınıza giriş yapın</small>

<form id="loginForm" style="margin-top:18px">
<div style="margin-top:12px">
<input class="input" type="email" name="email" placeholder="E-posta" required>
</div>
<div style="margin-top:12px">
<input class="input" type="password" name="password" placeholder="Şifre" required>
</div>
<div style="margin-top:16px">
<button class="btn btn-primary" type="submit" style="width:100%">Giriş Yap</button>
</div>
</form>

<div class="modal-footer">
Hesabınız yok mu? <a onclick="switchModal('loginModal','registerModal')">Kayıt ol</a>
</div>
</div>
</div>

<div class="modal" id="registerModal">
<div class="modal-card">
<div class="modal-head">
<h3>Kayıt Ol</h3>
<button class="close-btn" onclick="closeModal('registerModal')">✕</button>
</div>
<small>Yeni hesap oluşturun</small>

<form id="registerForm" style="margin-top:18px">
<div class="row">
<input class="input" type="text" name="first_name" placeholder="Ad" required>
<input class="input" type="text" name="last_name" placeholder="Soyad" required>
</div>
<div style="margin-top:12px">
<input class="input" type="email" name="email" placeholder="E-posta" required>
</div>
<div style="margin-top:12px">
<input class="input" type="text" name="phone" placeholder="Telefon">
</div>
<div style="margin-top:12px">
<input class="input" type="text" name="company" placeholder="Şirket adı">
</div>
<div style="margin-top:12px">
<input class="input" type="password" name="password" placeholder="Şifre (min. 6 karakter)" required>
</div>
<div style="margin-top:16px">
<button class="btn btn-primary" type="submit" style="width:100%">Kayıt Ol</button>
</div>
</form>

<div class="modal-footer">
Zaten hesabınız var mı? <a onclick="switchModal('registerModal','loginModal')">Giriş yap</a>
</div>
</div>
</div>

<div class="toast-wrap" id="toastWrap"></div>

<script>
function openModal(id){
document.getElementById(id).classList.add('show');
}
function closeModal(id){
document.getElementById(id).classList.remove('show');
}
function switchModal(closeId, openId){
closeModal(closeId);
setTimeout(()=>openModal(openId),150);
}

window.addEventListener('click', function(e){
document.querySelectorAll('.modal').forEach(modal=>{
if(e.target === modal) modal.classList.remove('show');
});
});

function showToast(message, type='info'){
const wrap = document.getElementById('toastWrap');
const div = document.createElement('div');
div.className = 'toast ' + type;
div.textContent = message;
wrap.appendChild(div);
setTimeout(()=>div.remove(), 3200);
}

function setLoggedInUser(user){
document.getElementById('loginBtn').classList.add('hidden');
document.getElementById('registerBtn').classList.add('hidden');
document.getElementById('logoutBtn').classList.remove('hidden');

const chip = document.getElementById('userChip');
chip.classList.remove('hidden');
chip.innerHTML = '👤 ' + user.full_name;

if(user.role === 'admin' || user.role === 'manager'){
document.getElementById('adminBtn').classList.remove('hidden');
} else {
document.getElementById('adminBtn').classList.add('hidden');
}
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
const res = await fetch('api/session.php');
const data = await res.json();
if(data.logged_in){
setLoggedInUser(data);
}else{
setLoggedOutUser();
}
}catch(e){
setLoggedOutUser();
}
}

document.getElementById('registerForm').addEventListener('submit', async function(e){
e.preventDefault();

const fd = new FormData(this);
const payload = {
first_name: fd.get('first_name'),
last_name: fd.get('last_name'),
email: fd.get('email'),
phone: fd.get('phone'),
company: fd.get('company'),
password: fd.get('password')
};

try{
const res = await fetch('api/register.php', {
method:'POST',
headers:{'Content-Type':'application/json'},
body:JSON.stringify(payload)
});
const data = await res.json();

if(data.success){
showToast(data.message, 'success');
closeModal('registerModal');
this.reset();
setLoggedInUser(data.data);
}else{
showToast(data.message, 'error');
}
}catch(err){
showToast('Kayıt sırasında bağlantı hatası oluştu', 'error');
}
});

document.getElementById('loginForm').addEventListener('submit', async function(e){
e.preventDefault();

const fd = new FormData(this);
const payload = {
email: fd.get('email'),
password: fd.get('password')
};

try{
const res = await fetch('api/login.php', {
method:'POST',
headers:{'Content-Type':'application/json'},
body:JSON.stringify(payload)
});
const data = await res.json();

if(data.success){
showToast(data.message, 'success');
closeModal('loginModal');
this.reset();
setLoggedInUser(data.data);
}else{
showToast(data.message, 'error');
}
}catch(err){
showToast('Giriş sırasında bağlantı hatası oluştu', 'error');
}
});

async function logoutUser(){
try{
await fetch('api/logout.php');
setLoggedOutUser();
showToast('Çıkış yapıldı', 'info');
}catch(err){
showToast('Çıkış işlemi başarısız', 'error');
}
}

document.getElementById('contactForm').addEventListener('submit', async function(e){
e.preventDefault();

const fd = new FormData(this);
const payload = {
name: fd.get('name'),
email: fd.get('email'),
phone: fd.get('phone'),
subject: fd.get('subject'),
message: fd.get('message')
};

try{
const res = await fetch('api/contact.php', {
method:'POST',
headers:{'Content-Type':'application/json'},
body:JSON.stringify(payload)
});
const data = await res.json();

if(data.success){
showToast(data.message, 'success');
this.reset();
}else{
showToast(data.message, 'error');
}
}catch(err){
showToast('Mesaj gönderilirken hata oluştu', 'error');
}
});

checkSession();
</script>
</body>
</html>