<?php 
include "config.php";
include "partials/header.php"; 

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo "<div class='da-container' style='margin-top:40px;'><div class='da-thread-card'>Geçersiz konu.</div></div>";
    include "partials/footer.php";
    exit;
}

// Yorum Kaydetme
if (isset($_POST['comment']) && isset($_SESSION['user_id'])) {
    $content = $conn->real_escape_string($_POST['content']);
    $u_id = $_SESSION['user_id']; 

    if (!empty(trim($content))) {
        $conn->query("INSERT INTO comments (post_id, user_id, content) VALUES ($id, $u_id, '$content')");
        header("Location: post_view.php?id=$id");
        exit;
    }
}

// Konu Detayı Çek
$post_res = $conn->query("SELECT p.*, u.username FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = $id");
$post = $post_res->fetch_assoc();

if (!$post) {
    echo "<div class='da-container' style='margin-top:40px;'><div class='da-thread-card'>Konu bulunamadı.</div></div>";
    include "partials/footer.php";
    exit;
}
?>

<div class="da-container main-layout">
    
    <main class="content-area">
        <div class="da-thread-card" style="border-left:none; padding:30px;">
            <h1 style="font-size:1.8rem; margin-bottom:15px; color:var(--nav-bg); font-weight:800;">
                <?= htmlspecialchars($post['title']) ?>
            </h1>
            <p style="font-size:1.05rem; line-height:1.6; color:#334155; margin-bottom:20px;">
                <?= nl2br(htmlspecialchars($post['content'])) ?>
            </p>
            <div class="thread-meta" style="border-top:1px solid var(--border-color); padding-top:15px; color:var(--text-muted);">
                <span>👤 Yazar: <strong><?= htmlspecialchars($post['username']) ?></strong></span>
            </div>
        </div>

        <div class="da-thread-card" style="border-left:none;">
            <h4 class="widget-title" style="border-bottom:none; margin-bottom:15px;">Yorum Yap</h4>
            <?php if (isset($_SESSION['user_id'])): ?>
                <form method="POST">
                    <textarea name="content" required placeholder="Fikirlerinizi buraya yazın..." style="width:100%; padding:15px; border:1px solid var(--border-color); border-radius:8px; font-family:inherit; min-height:100px; margin-bottom:15px; resize:vertical;"></textarea>
                    <button name="comment" class="btn-new-topic" style="border:none; cursor:pointer;">Yorumu Gönder</button>
                </form>
            <?php else: ?>
                <p style="font-size:0.95rem; color:var(--text-muted);">Yorum yazabilmek için lütfen <a href="login.php" style="color:var(--primary-blue); font-weight:600; text-decoration:none;">giriş yapın</a>.</p>
            <?php endif; ?>
        </div>

        <h3 class="section-title" style="margin:30px 0 15px 0;">Yorumlar</h3>
        <div class="comments-list">
            <?php
            $comments = $conn->query("SELECT c.*, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE c.post_id = $id ORDER BY c.created_at DESC");
            
            if ($comments->num_rows > 0):
                while($row = $comments->fetch_assoc()): ?>
                    <div class="da-thread-card" style="border-left: 4px solid var(--border-color); padding:20px;">
                        <div class="thread-badge-row" style="justify-content:space-between;">
                            <strong>👤 <?= htmlspecialchars($row['username']) ?></strong>
                            <span class="thread-time">🕒 <?= $row['created_at'] ?></span>
                        </div>
                        <p style="font-size:0.98rem; color:var(--text-main); margin:10px 0; line-height:1.5;">
                            <?= nl2br(htmlspecialchars($row['content'])) ?>
                        </p>
                        
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                            <div style="text-align:right; margin-top:10px;">
                                <a href="delete_comment.php?id=<?= $row['id'] ?>&post=<?= $id ?>" onclick="return confirm('Bu yorumu silmek istediğinize emin misiniz?')" style="color:#f87171; text-decoration:none; font-size:0.8rem; font-weight:600;">[Yorumu Sil]</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; 
            else: ?>
                <div class="da-thread-card" style="border-left:none; text-align:center; color:var(--text-muted);">
                    Henüz yorum yapılmamış. İlk yorumu sen bırak!
                </div>
            <?php endif; ?>
        </div>
    </main>

    <aside class="sidebar-area">
        <div class="sidebar-widget">
            <h4 class="widget-title">Forum İstatistikleri</h4>
            <div class="stats-container">
                <?php
                $user_count = $conn->query("SELECT id FROM users")->num_rows;
                $post_count = $conn->query("SELECT id FROM posts")->num_rows;
                ?>
                <div class="stat-box">
                    <span class="stat-num"><?= $user_count ?></span>
                    <span class="stat-label">Üye</span>
                </div>
                <div class="stat-box">
                    <span class="stat-num"><?= $post_count ?></span>
                    <span class="stat-label">Konu</span>
                </div>
            </div>
        </div>
        <div class="sidebar-widget">
            <h4 class="widget-title">Hızlı Menü</h4>
            <div class="activity-list">
                <div class="activity-row"><a href="index.php" style="color:var(--primary-blue); font-weight:600; text-decoration:none;">← Ana Sayfaya Dön</a></div>
            </div>
        </div>
    </aside>
</div>

<?php include "partials/footer.php"; ?>