<?php

$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id === 0) {
    redirect('login'); 
    exit;
}

$user_info = get_user_dashboard_info($user_id);

$stats = get_user_quick_stats($user_id);

$username = htmlspecialchars($user_info['username'] ?? 'Guest');
$rank = htmlspecialchars($user_info['rank'] ?? 'N/A');
$kuis_selesai = htmlspecialchars($stats['kuis_selesai'] ?? 0);
$jawaban_benar = htmlspecialchars($stats['jawaban_benar'] ?? 0);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Attack on Titan</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../app/views/css/variables.css">
    <link rel="stylesheet" href="../app/views/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
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
    <div class="container">

        <div class="top-bar">
            <span>HELLO, <?php echo $username; ?> !</span>
            <span class="separator">||</span>
            <span>RANK : <?php echo $rank; ?></span>
            <span class="separator">||</span>
            <a href="index.php?action=logout" style="color: inherit; text-decoration: none;">LOGOUT <i class="fas fa-sign-out-alt"></i></a>
        </div>
        <div class="main-card card-with-overlay">

            <div class="quote-section">
                <h1 class="main-quote">"SHINZOU WO SASAGEYO"</h1>
                <h2 class="sub-quote">(DEDIKASIKAN HATIMU UNTUK UJIAN HARI INI)</h2>
            </div>

            <div class="stats-row">
                <div class="stat-box">
                    <h3>KUIS SELESAI:</h3>
                    <p class="stat-value"><?php echo $kuis_selesai; ?></p>
                </div>

                <div class="stat-box">
                    <h3>JAWABAN BENAR:</h3>
                    <p class="stat-value"><?php echo $jawaban_benar; ?></p>
                </div>

                <div class="stat-box">
                    <h3>RANKING:</h3>
                    <p class="stat-value"><?php echo $rank; ?></p>
                </div>
            </div>
        </div>
        
        </div>

</body>

</html>