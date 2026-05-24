# 🚀 ATÜ Öğrenci Forum Platformu

Adana Alparslan Türkeş Bilim ve Teknoloji Üniversitesi öğrencileri için özel olarak geliştirilmiş, modern, hızlı ve dinamik bir topluluk ve paylaşım platformu. Bu proje, popüler forum mimarilerinden (Donanım Arşivi, XenForo) esinlenerek tamamen **sıfırdan (native)** PHP, MySQL ve modern CSS mimarisiyle inşa edilmiştir.

---

## ✨ Öne Çıkan Özellikler

### 🎨 1. Modern & Responsive Tasarım
* **Koyu ve Derin Temalı Navbar:** Tam genişlikte, gözü yormayan modern lacivert/gece mavisi (`#0f172a`) premium üst menü tasarımı.
* **Akıllı Kart Mimarisi (Grid & Flexbox):** Forum akışındaki her bir konu, soft gölgelere ve üzerine gelindiğinde (hover) aktif olan dinamik mavi çizgi animasyonuna sahip bağımsız adacıklar halinde listelenir.
* **Gelişmiş CSS Tipografisi:** Google Fonts üzerinden entegre edilen `Inter` yazı tipi ailesiyle keskin ve okunaklı metin hatları.
* **Tam Mobil Uyumluluk:** Büyük ekranlarda profesyonel 2 sütunlu (İçerik + Yan Panel) düzen kullanılırken, mobil cihazlarda yan panel gizlenerek akış tek sütuna kusursuzca optimize olur.
* **Yapışkan Alt Bilgi (Sticky Footer):** Sayfadaki konu veya veri miktarı ne kadar az olursa olsun, alt bilgi (footer) ekranın ortasında kalmaz; akıllı CSS hesaplamasıyla her zaman zemine çakılı durur.

### 🔐 2. Güvenli Üyelik & Oturum Yönetimi (`Auth` Sistemi)
* **BCRYPT ile Şifre Güvenliği:** Kullanıcı şifreleri veritabanına düz yazı veya zayıf MD5 yerine, PHP'nin güncel güvenlik standartı olan `PASSWORD_BCRYPT` (salting ve hashing) algoritması ile şifrelenerek kaydedilir.
* **Benzersiz E-posta ve Kullanıcı Adı Kontrolü:** Kayıt esnasında `Duplicate Entry` hatalarının önüne geçmek için eş zamanlı veritabanı sorgulaması yapılır; aynı kullanıcı adı veya e-posta ile ikinci bir kayda izin verilmez.
* **Sayfa Koruma Kalkanı (Middleware):** Giriş yapmamış (ziyaretçi) kullanıcılar url üzerinden doğrudan yeni konu açma (`post_add.php`) gibi yetkili sayfalara erişmeye çalıştığında sistem tarafından otomatik olarak engellenir ve giriş ekranına yönlendirilir.

### 📋 3. Dinamik Forum Fonksiyonları (Konu & Yorum Yönetimi)
* **Kategori Tabanlı Konu Açma:** Kullanıcılar yeni konu açarken dinamik açılır menü (modern select) üzerinden ilgili kategoriyi (Örn: Mühendislik, Genel, Duyurular) seçebilirler.
* **Son Hareketlilik Paneli (Sidebar):** Ana sayfanın sağ sütununda yer alan canlı widget sayesinde forumda yapılan en son 5 yorum ve bu yorumu yapan kullanıcılar anlık olarak listelenir.
* **Canlı Sayaçlar:** Forumdaki toplam üye ve toplam açılan konu sayısı SQL agregasyon sorgularıyla eş zamanlı hesaplanarak yan panelde gösterilir.
* **Rol Tabanlı Modifikasyon (Admin / Üye):** Gelişmiş session yapısı sayesinde admin yetkisine sahip kullanıcılar (`role = 1`), konu altlarındaki uygunsuz yorumları tek tıkla silebilirler (`[Yorumu Sil]`).

---

## 🛠️ Teknik Yığın (Tech Stack)

* **Backend:** PHP (Native / Saf Kodlama)
* **Database:** MySQL (PDO / mysqli)
* **Frontend:** HTML5, CSS3 (Modern Flexbox & CSS Grid, SVG Entegrasyonları)
* **Font & İkonlar:** Google Fonts (Inter), Unicode UI Elements
* **Sunucu Ortamı:** XAMPP (Apache Server)

---

## 📁 Proje Klasör Yapısı

```text
C:\xampp\htdocs\
│
├── index.php             # Ana sayfa, güncel konuların listelendiği portal
├── post_view.php         # Konu detayları, yorum okuma ve yorum yazma alanı
├── post_add.php          # Giriş yapmış üyeler için yeni başlık açma formu
├── login.php             # Gelişmiş odaklanma efektli kullanıcı giriş ekranı
├── register.php          # Güvenli şifreleme altyapısına sahip kayıt ekranı
├── logout.php            # Oturumu güvenli şekilde sonlandırma dosyası
├── config.php            # Veritabanı bağlantı ayarları ve Session başlatıcı
├── style.css             # Tüm projenin ortak premium CSS mimarisi
├── db.sql                # Tablo yapılarını barındıran veritabanı şeması
├── favicon.png           # Tarayıcı sekmesi için tam kare amblem simgesi
├── logo.png              # Navbar için kurumsal yatay logo
│
└── partials/             # Tekrarlanan sayfa bileşenleri
    ├── header.php        # Tam genişlikte navbar ve meta etiketleri
    └── footer.php        # Esnek, zemine sabitlenen alt bilgi alanı
