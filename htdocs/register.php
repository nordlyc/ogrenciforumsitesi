<?php 
include "config.php"; 
include "partials/header.php"; 

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";
$success = "";

if (isset($_POST['register'])) {
    $username = trim($conn->real_escape_string($_POST['username']));
    $email = trim($conn->real_escape_string($_POST['email'])); // Email eklendi
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if (empty($username) || empty($email) || empty($password)) {
        $error = "Lütfen tüm alanları doldurun!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Geçersiz bir e-posta adresi girdiniz!";
    } elseif ($password !== $password_confirm) {
        $error = "Girdiğiniz şifreler birbiriyle uyuşmuyor!";
    } elseif (strlen($password) < 6) {
        $error = "Şifreniz en az 6 karakter olmalıdır!";
    } else {
        // Kullanıcı adı veya email daha önce alınmış mı kontrol et
        $check = $conn->query("SELECT id FROM users WHERE username='$username' OR email='$email'");
        if ($check && $check->num_rows > 0) {
            $error = "Bu kullanıcı adı veya e-posta zaten kullanımda!";
        } else {
            // Şifreyi güvenli hashle
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            // Veritabanına kayıt (email alanı eklendi)
            $insert = $conn->query("INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', 0)");
            
            if ($insert) {
                $success = "Kayıt başarıyla tamamlandı! Giriş yapabilirsiniz.";
            } else {
                $error = "Veritabanı Hatası: " . $conn->error;
            }
        }
    }
}
?>

<div class="da-auth-wrapper">
    <div class="da-auth-card">
        <div class="da-auth-header">
            <h2>Kayıt Ol</h2>
            <p>ATÜ Forum topluluğuna katıl ve paylaşıma başla.</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="da-auth-error">⚠️ <?= $error ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="da-auth-success" style="background-color: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 10px; font-size: 0.9rem; font-weight: 500; margin-bottom: 25px; text-align: center;">🎉 <?= $success ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="da-form-group">
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" required placeholder="Bir kullanıcı adı belirleyin" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
            </div>

            <div class="da-form-group">
                <label for="email">E-posta Adresi</label>
                <input type="email" id="email" name="email" required placeholder="ornek@domain.com" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            </div>

            <div class="da-form-group">
                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" required placeholder="En az 6 karakter">
            </div>

            <div class="da-form-group">
                <label for="password_confirm">Şifre Tekrar</label>
                <input type="password" id="password_confirm" name="password_confirm" required placeholder="Şifrenizi tekrar girin">
            </div>

            <button type="submit" name="register" class="da-auth-btn">Hesabımı Oluştur</button>
        </form>

        <div class="da-auth-footer">
            Zaten üye misin? <a href="login.php">Giriş Yap</a>
        </div>
    </div>
</div>

<?php include "partials/footer.php"; ?>