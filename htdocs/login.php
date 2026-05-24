<?php 
include "config.php"; 
include "partials/header.php"; 

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";
if (isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $res = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($res && $res->num_rows > 0) {
        $user = $res->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = $user['username'];
            $_SESSION['role'] = $user['role']; // 1: Admin, 0: Üye
            header("Location: index.php");
            exit;
        } else {
            $error = "Hatalı şifre girdiniz!";
        }
    } else {
        $error = "Kullanıcı bulunamadı!";
    }
}
?>

<div class="da-auth-wrapper">
    <div class="da-auth-card">
        <div class="da-auth-header">
            <h2>Giriş Yap</h2>
            <p>ATÜ Forum dünyasına kaldığın yerden devam et.</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="da-auth-error">
                ⚠️ <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="da-form-group">
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" required placeholder="Kullanıcı adınızı girin">
            </div>

            <div class="da-form-group">
                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>

            <button type="submit" name="login" class="da-auth-btn">Hesabıma Giriş Yap</button>
        </form>

        <div class="da-auth-footer">
            Hesabın yok mu? <a href="register.php">Hemen Kayıt Ol</a>
        </div>
    </div>
</div>

<?php include "partials/footer.php"; ?>