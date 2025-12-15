<?php
// app/views/login.php (Ganti nama file .html Anda)

// Asumsi fungsi display_message() mengambil dan menampilkan pesan dari sesi
// Lalu menghapusnya
if (function_exists('display_message')) {
    display_message();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login AoT Simple</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../app/views/css/variables.css">
    <link rel="stylesheet" href="../app/views/css/login.css">
</head>
<body>

    <div class="container">
        <img src="../app/views/images/logo.png" alt="Attack on Titan Logo" class="logo">

        <div class="login-box">
            <h2>LOGIN</h2>

            <form method="post" action="index.php">
                <div class="input-group">
                    <label for="username">USERNAME :</label>
                    <input name="username" type="text" id="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                </div>

                <div class="input-group">
                    <label for="password">PASSWORD :</label>
                    <input name="password" type="password" id="password">
                </div>

                <div class="footer">
                    <div class="register-link">
                        <p>BELUM PUNYA AKUN?</p>
                        <a style="color: #eebb5c;" href="index.php?page=register">REGISTER DISINI</a>
                    </div>
                    <button name="action" value="login" class="login-button" type="submit">MASUK</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>