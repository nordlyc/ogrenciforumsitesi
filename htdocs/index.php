<?php 
include "config.php"; 
include "partials/header.php"; 
?>

<div class="da-container main-layout">
    
    <main class="content-area">
        <div class="forum-section-header">
            <h2 class="section-title">Güncel Konular</h2>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="post_add.php" class="btn-new-topic">+ Yeni Konu Aç</a>
            <?php endif; ?>
        </div>

        <div class="threads-list">
            <?php
            $res = $conn->query("SELECT p.*, u.username, c.name as cat_name FROM posts p 
                                 LEFT JOIN users u ON p.user_id = u.id 
                                 LEFT JOIN categories c ON p.category_id = c.id 
                                 ORDER BY p.created_at DESC");

            if($res && $res->num_rows > 0):
                while($row = $res->fetch_assoc()): ?>
                    <div class="da-thread-card">
                        <div class="thread-badge-row">
                            <span class="forum-badge"><?= htmlspecialchars($row['cat_name'] ?? 'Genel') ?></span>
                            <span class="thread-time">🕒 <?= date("H:i", strtotime($row['created_at'])) ?></span>
                        </div>
                        <h3 class="thread-title">
                            <a href="post_view.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></a>
                        </h3>
                        <p class="thread-snippet"><?= substr(htmlspecialchars($row['content']), 0, 130) ?>...</p>
                        <div class="thread-meta">
                            <span class="thread-author">👤 <?= htmlspecialchars($row['username'] ?? 'Misafir') ?></span>
                        </div>
                    </div>
                <?php endwhile; 
            else: ?>
                <div class="da-thread-card empty-state">
                    <p>Henüz forumda açılmış bir konu bulunmuyor.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <aside class="sidebar-area">
        
        <?php if(isset($_SESSION['user'])): ?>
        <div class="sidebar-widget profile-card">
            <div class="profile-avatar">👤</div>
            <div class="profile-info">
                <span class="welcome-label">Hoş geldin,</span>
                <span class="profile-username"><?= htmlspecialchars($_SESSION['user']) ?></span>
            </div>
        </div>
        <?php endif; ?>

        <div class="sidebar-widget">
            <h4 class="widget-title">Forum İstatistikleri</h4>
            <div class="stats-container">
                <?php
                $user_count = $conn->query("SELECT id FROM users")->num_rows;
                $post_count = $conn->query("SELECT id FROM posts")->num_rows;
                ?>
                <div class="stat-box">
                    <span class="stat-num"><?= $user_count ?></span>
                    <span class="stat-label">Toplam Üye</span>
                </div>
                <div class="stat-box">
                    <span class="stat-num"><?= $post_count ?></span>
                    <span class="stat-label">Toplam Konu</span>
                </div>
            </div>
        </div>

        <div class="sidebar-widget">
            <h4 class="widget-title">Son Hareketlilik</h4>
            <div class="activity-list">
                <?php
                $recent_comments = $conn->query("SELECT c.post_id, u.username, p.title FROM comments c 
                                                JOIN users u ON c.user_id = u.id 
                                                JOIN posts p ON c.post_id = p.id 
                                                ORDER BY c.created_at DESC LIMIT 5");
                if($recent_comments && $recent_comments->num_rows > 0):
                    while($rc = $recent_comments->fetch_assoc()): ?>
                        <div class="activity-row">
                            <span class="activity-user"><?= htmlspecialchars($rc['username']) ?>:</span>
                            <a href="post_view.php?id=<?= $rc['post_id'] ?>" class="activity-link">
                                <?= htmlspecialchars($rc['title']) ?>
                            </a>
                        </div>
                    <?php endwhile;
                else: ?>
                    <p class="no-activity">Henüz yeni hareket yok.</p>
                <?php endif; ?>
            </div>
        </div>
    </aside>
</div>

<?php include "partials/footer.php"; ?>