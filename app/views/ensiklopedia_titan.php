<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ensiklopedia Titan - Attack on Titan</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/variables.css">
    <link rel="stylesheet" href="css/ensiklopedia.css">
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
    <!-- END NAVBAR LEFT -->

    <div class="ensiklopedia-container">
        <!-- Header -->
        <div class="top-bar">
            <span>ENSIKLOPEDIA</span>
        </div>

        <!-- Encyclopedia Card -->
        <div class="ensiklopedia-card card-with-overlay">
            <!-- Content Display Area -->
            <div class="content-display" id="content-display">
                <!-- Character cards will be inserted here by JavaScript -->
            </div>

            <!-- Navigation Buttons -->
            <div class="navigation-buttons">
                <button class="nav-btn previous-btn" id="prev-btn">PREVIOUS</button>
                <button class="nav-btn next-btn" id="next-btn">NEXT</button>
            </div>
        </div>
    </div>

    <script src="../app/views/js/ensiklopedia_titan.js"></script>
</body>

</html>
