<?php 
include "config.php"; 
include "partials/header.php"; 

// Giriş yapmamış kullanıcıyı koruma amacıyla login sayfasına atma
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = "";
$success = "";

if (isset($_POST['add_post'])) {
    $title = trim($conn->real_escape_string($_POST['title']));
    $content = trim($conn->real_escape_string($_POST['content']));
    $category_id = intval($_POST['category_id']);
    $user_id = $_SESSION['user_id'];

    if (empty($title) || empty($content) || $category_id <= 0) {
        $error = "Lütfen başlık, içerik ve kategori alanlarını boş bırakmayın!";
    } else {
        $insert = $conn->query("INSERT INTO posts (title, content, category_id, user_id) VALUES ('$title', '$content', $category_id, $user_id)");
        
        if ($insert) {
            $success = "Konunuz başarıyla açıldı! Ana sayfaya yönlendiriliyorsunuz...";
            echo "<meta http-equiv='refresh' content='2;url=index.php'>";
        } else {
            $error = "Konu eklenirken bir hata oluştu, lütfen tekrar deneyin.";
        }
    }
}
?>

<div class="da-container main-layout">
    <main class="content-area">
        <div class="da-thread-card" style="border-left: none; padding: 35px;">
            <div class="da-auth-header" style="text-align: left; margin-bottom: 25px;">
                <h2 style="font-size: 1.6rem; font-weight: 800; color: var(--nav-bg);">Yeni Konu Oluştur</h2>
                <p style="color: var(--text-muted); font-size: 0.95rem;">Toplulukla paylaşmak istediğin fikri veya soruyu buraya yazabilirsin.</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="da-auth-error">
                    ⚠️ <?= $error ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="da-auth-success" style="background-color: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 10px; font-size: 0.9rem; font-weight: 500; margin-bottom: 25px; text-align: center;">
                    🎉 <?= $success ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="da-form-group">
                    <label for="title">Konu Başlığı</label>
                    <input type="text" id="title" name="title" required placeholder="Dikkat çekici ve net bir başlık yazın..." value="<?= isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '' ?>">
                </div>

                <div class="da-form-group">
                    <label for="category_id">Kategori</label>
                    <select id="category_id" name="category_id" required class="da-modern-select">
                        <option value="" disabled selected>Bir kategori seçin...</option>
                        <?php
                        $categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");
                        while($cat = $categories->fetch_assoc()) {
                            echo "<option value='".$cat['id']."'>".htmlspecialchars($cat['name'])."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="da-form-group">
                    <label for="content">Konu İçeriği</label>
                    <textarea id="content" name="content" required placeholder="Detayları, sorularınızı veya düşüncelerinizi buraya özgürce yazın..." style="width:100%; padding:15px; border:1px solid var(--border-color); border-radius:10px; font-family:inherit; font-size:0.95rem; min-height:220px; outline:none; transition:all 0.2s ease; resize:vertical; background-color:#f8fafc;"></textarea>
                </div>

                <div style="display:flex; gap:15px; justify-content:flex-end; margin-top:10px;">
                    <a href="index.php" class="btn-new-topic" style="background-color:#94a3b8; box-shadow:none; text-decoration:none;">İptal Et</a>
                    <button type="submit" name="add_post" class="btn-new-topic" style="border:none; cursor:pointer;">Konuyu Yayınla</button>
                </div>
            </form>
        </div>
    </main>

    <aside class="sidebar-area">
        <div class="sidebar-widget">
            <h4 class="widget-title">Forum Kuralları</h4>
            <div class="activity-list" style="font-size:0.85rem; color:var(--text-muted); line-height:1.6;">
                <div class="activity-row" style="border-bottom:none; padding:5px 0;">📍 Başlığın tamamen büyük harflerle yazılmamasına dikkat edin.</div>
                <div class="activity-row" style="border-bottom:none; padding:5px 0;">📍 Doğru kategoriyi seçtiğinizden emin olun.</div>
                <div class="activity-row" style="border-bottom:none; padding:5px 0;">📍 Saygılı ve topluluk kurallarına uygun bir dil kullanın.</div>
            </div>
        </div>
    </aside>
</div>

<?php include "partials/footer.php"; ?>