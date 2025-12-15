<?php

if (!isset($_SESSION['quiz_questions']) || empty($_SESSION['quiz_questions'])) {
    redirect('dashboard'); 
    exit();
}

$quiz_data = $_SESSION['quiz_questions'];
$user_answers = $_SESSION['user_answers'];
$total_questions = count($quiz_data);

$current_index = (int)($_GET['q'] ?? 0);
if ($current_index < 0 || $current_index >= $total_questions) {
    $current_index = 0;
}

$current_question = $quiz_data[$current_index];
$options = $current_question['opsi']; 
$current_answer_id = $user_answers[$current_index]; 

function get_option_label($index) {
    return chr(65 + $index);
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Pertanyaan <?php echo $current_index + 1; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../app/views/css/variables.css">
    <link rel="stylesheet" href="../app/views/css/quiz.css"> 
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
    <div class="quiz-container">
        <div class="timer-bar">
            <span class="timer-label">TIMER :</span>
            <span class="timer-value" id="timer">00:00</span>
        </div>

        <div class="question-number">
            <span id="current-question"><?php echo $current_index + 1; ?> / <?php echo $total_questions; ?></span>
        </div>

        <div class="quiz-card card-with-overlay">
            
            <form id="quizForm" action="index.php" method="POST">
                <input type="hidden" name="action" id="formAction" value="save_temp_answer">
                <input type="hidden" name="question_index" value="<?php echo $current_index; ?>">
                <input type="hidden" name="option_id" id="selectedOptionId" value="<?php echo htmlspecialchars($current_answer_id ?? ''); ?>">

                <div class="question-section">
                    <p class="question-text" id="question">
                        <?php echo htmlspecialchars($current_question['teks_soal']); ?>
                    </p>
                </div>

                <div class="options-section">
                    <?php foreach ($options as $index => $option): ?>
                        <?php 
                        $label = get_option_label($index);
                        $is_selected = $current_answer_id == $option['id_opsi'];
                        ?>
                        <div class="option <?php echo $is_selected ? 'selected' : ''; ?>" 
                            data-option-id="<?php echo $option['id_opsi']; ?>">
                            <span class="option-label"><?php echo $label; ?>.</span>
                            <span class="option-text"><?php echo htmlspecialchars($option['teks_opsi']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="navigation-buttons">
                    <button type="button" class="nav-btn previous-btn" 
                            data-nav-target="<?php echo max(0, $current_index - 1); ?>"
                            <?php echo $current_index == 0 ? 'disabled' : ''; ?>>PREVIOUS</button>
                    
                    <button type="button" class="nav-btn next-btn"
                            data-nav-target="<?php echo $current_index + 1; ?>">
                        <?php echo $current_index == $total_questions - 1 ? 'SUBMIT' : 'NEXT'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const form = document.getElementById('quizForm');
        const optionsElements = document.querySelectorAll('.option');
        const selectedOptionInput = document.getElementById('selectedOptionId');
        const formActionInput = document.getElementById('formAction');
        const timerElement = document.getElementById('timer');
        const previousBtn = document.querySelector('.previous-btn');
        const nextBtn = document.querySelector('.next-btn');

        let timerSeconds = 0;
        let timerInterval;
        const TOTAL_QUESTIONS = <?php echo $total_questions; ?>;

        optionsElements.forEach(option => {
            option.addEventListener('click', () => {
                const selectedOptionId = option.getAttribute('data-option-id');
                
                optionsElements.forEach(opt => opt.classList.remove('selected'));
                option.classList.add('selected');
                
                selectedOptionInput.value = selectedOptionId;
            });
        });

        function navigate(targetIndex) {
            formActionInput.value = 'save_temp_answer';
            
            form.action = `index.php?page=quiz&q=${targetIndex}`;
            form.submit();
        }

        previousBtn.addEventListener('click', () => {
            const target = parseInt(previousBtn.getAttribute('data-nav-target'));
            if (target >= 0) {
                navigate(target);
            }
        });

        nextBtn.addEventListener('click', () => {
            const target = parseInt(nextBtn.getAttribute('data-nav-target'));
            const isSubmit = nextBtn.textContent.trim() === 'SUBMIT';

            
            if (isSubmit) {
                formActionInput.value = 'submit_quiz';
                form.action = 'index.php';
                form.submit();
                
            } else if (target < TOTAL_QUESTIONS) {
                navigate(target);
            }
        });
        
        function startTimer() {
            timerInterval = setInterval(() => {
                timerSeconds++;
                const minutes = Math.floor(timerSeconds / 60);
                const seconds = timerSeconds % 60;
                timerElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            }, 1000);
        }

        document.addEventListener('DOMContentLoaded', startTimer);
    </script>
</body>
</html>