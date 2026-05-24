<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATÜ Öğrenci Platformu / Forum</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="favicon.png">
</head>
<body>

    <header class="da-navbar">
        <div class="da-nav-container">
            <div class="da-logo">
                <a href="index.php"  style="display: flex; align-items: center; gap: 10px;">
                    <img src="logo.png" alt="ATÜ Logo" style="height: 65px; width: auto; object-fit: contain;">
                    <span style="color: #ffffff; font-weight: 800; font-size: 1.4rem; letter-spacing: -0.5px;">ATÜ<span style="color: var(--primary-blue);">FORUM</span></span>
                </a>
            </div>
            <nav class="da-menu">
                <a href="index.php">Ana Sayfa</a>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="post_add.php">Konu Aç</a>
                    <span class="user-profile">👤 <?= htmlspecialchars($_SESSION['user']) ?></span>
                    <a href="logout.php" class="nav-btn-logout">Çıkış</a>
                <?php else: ?>
                    <a href="login.php">Giriş Yap</a>
                    <a href="register.php" class="nav-btn-register">Kayıt Ol</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <div class="da-main-wrapper">