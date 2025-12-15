<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Attack on Titan</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/variables.css">
    <link rel="stylesheet" href="css/quiz.css">
</head>

<body>
    <!-- NAVBAR LEFT -->
    <a href="quiz.html" class="menu-btn">
        <img style="width: 60px; height: 60px;" src="images/start_quiz_active_logo.png">
    </a>
    <a href="dashboard.html" class="menu-btn-2">
        <img style="width: 45px; height: 45px;" src="images/dashboard_logo.png">
    </a>
    <a href="leaderboard.html" class="menu-btn-3">
        <img style="width: 45px; height: 45px;" src="images/leaderboard_logo.png">
    </a>
    <a href="ensiklopedia.html" class="menu-btn-4">
        <img style="width: 45px; height: 45px;" src="images/enskiklopedia_logo.png">
    </a>
    <!-- END NAVBAR LEFT -->

    <div class="quiz-container">
        <!-- Timer Bar -->
        <div class="timer-bar">
            <span class="timer-label">TIMER :</span>
            <span class="timer-value" id="timer">00:00</span>
        </div>

        <!-- Question Number Indicator -->
        <div class="question-number">
            <span id="current-question">1</span>
        </div>

        <!-- Quiz Card -->
        <div class="quiz-card card-with-overlay">
            <!-- Question Text -->
            <div class="question-section">
                <p class="question-text" id="question">
                    APA NAMA DISTRIK PALING LUAR DI BAGIAN SELATAN TEMBOK MARIA YANG PERTAMA KALI DIHANCURKAN OLEH COLOSSAL TITAN?
                </p>
            </div>

            <!-- Answer Options -->
            <div class="options-section">
                <div class="option" data-option="A">
                    <span class="option-label">A.</span>
                    <span class="option-text">DISTRIK TROST</span>
                </div>
                <div class="option" data-option="B">
                    <span class="option-label">B.</span>
                    <span class="option-text">DISTRIK SHIGANSHINA</span>
                </div>
                <div class="option" data-option="C">
                    <span class="option-label">C.</span>
                    <span class="option-text">DISTRIK STOHESS</span>
                </div>
                <div class="option" data-option="D">
                    <span class="option-label">D.</span>
                    <span class="option-text">DISTRIK KARANES</span>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="navigation-buttons">
                <button class="nav-btn previous-btn">PREVIOUS</button>
                <button class="nav-btn next-btn">NEXT</button>
            </div>
        </div>
    </div>

    <script src="js/quiz.js"></script>
</body>

</html>