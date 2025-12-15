<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ensiklopedia - Attack on Titan</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../app/views/css/variables.css">
    <link rel="stylesheet" href="../app/views/css/ensiklopedia.css">
</head>

<body>
    <!-- NAVBAR LEFT -->
    <a href="index.php?page=quiz" class="menu-btn">
        <img style="width: 60px; height: 60px;" src="../app/views/images/start_quiz_active_logo.png">
    </a>
    <a href="index.php?page=dashboard" class="menu-btn-2">
        <img style="width: 45px; height: 45px;" src="../app/views/images/dashboard_logo.png">
    </a>
    <a href="index.php?page=leaderboard" class="menu-btn-3">
        <img style="width: 45px; height: 45px;" src="../app/views/images/leaderboard_logo.png">
    </a>
    <a href="index.php?page=ensiklopedia" class="menu-btn-4">
        <img style="width: 45px; height: 45px;" src="../app/views/images/enskiklopedia_logo.png">
    </a>

    <div class="ensiklopedia-container">
        <!-- Header -->
        <div class="top-bar">
            <span>ENSIKLOPEDIA</span>
        </div>

        <!-- Encyclopedia Card -->
        <div class="ensiklopedia-card card-with-overlay">
            <!-- Category Buttons -->
            <div class="category-buttons">
                <button class="category-btn" onclick="location.href='ensiklopedia_human.html'">HUMAN</button>
                <button class="category-btn" onclick="location.href='ensiklopedia_titan.html'">TITAN</button>
            </div>
        </div>
    </div>
</body>

</html>
