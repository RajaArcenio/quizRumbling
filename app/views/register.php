<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register AoT</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../app/views/css/variables.css">
    <link rel="stylesheet" href="../app/views/css/register.css">
</head>
<body>

    <div class="container">
        <img src="images/logo.png" alt="Attack on Titan Logo" class="logo">

        <div class="register-box">
            <h2>REGISTER</h2>

            <form method="post">
                <div class="input-group">
                    <label>EMAIL :</label>
                    <input type="email" name="email" autocomplete="off">
                </div>

                <div class="input-group">
                    <label>NEW USERNAME :</label>
                    <input type="text" name="username" autocomplete="off">
                </div>

                <div class="input-group">
                    <label>NEW PASSWORD :</label>
                    <input type="password" name="password">
                </div>

                <div class="input-group">
                    <label>KONFIRMASI PASSWORD :</label>
                    <input type="password" name="confirm_password">
                </div>

                <div class="button-container">
                    <button name="action" value="register" class="register-button" type="submit">DAFTAR</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>