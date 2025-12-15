<?php
session_start();

require_once __DIR__ . '/../app/config/database.php'; 

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

require_once __DIR__ . '/../app/functions/helper.php'; 
require_once __DIR__ . '/../app/functions/auth.php'; 
require_once __DIR__ . '/../app/functions/dasboard_function.php';
require_once __DIR__ . '/../app/functions/quiz_function.php';
require_once __DIR__ . '/../app/functions/admin_functions.php';
require_once __DIR__ . '/../app/functions/leaderboard_functions.php';

$page = $_GET['page'] ?? 'dashboard';
$action = $_POST['action'] ?? $_GET['action'] ?? null;

if ($action === 'logout') {
    logout_user();
}

if ($action) {
    switch ($action) {
        case 'login':
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (login($username, $password)) {
                if ($_SESSION['isAdmin'] ?? 0 == 1) {
                    redirect('admin_dashboard'); 
                } else {
                    redirect('dashboard');
                }
                exit();
            } else {
                redirect('login'); 
                exit();
            }
        case 'register':
            $email = $_POST['email'] ?? '';
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($email) || empty($username) || empty($password) || empty($confirm_password)) {
                set_message("Semua field wajib diisi.");
                redirect('register');
                exit();
            }
            if ($password !== $confirm_password) {
                set_message("Konfirmasi password tidak cocok.");
                redirect('register');
                exit();
            }

            if (register($email, $username, $password)) {
                redirect('login');
                exit();
            } else {
                redirect('register');
                exit();
            }
        case 'start_quiz':
            $quiz_id = (int)($_POST['quiz_id'] ?? 0);
            if ($quiz_id > 0) {
                prepare_quiz_questions($quiz_id);
                redirect('quiz'); 
            }
            break;
        case 'submit_quiz':
            $user_id = get_current_user_id();
            if ($user_id > 0) {
                submit_quiz($user_id);
            } else {
                redirect('login'); 
            }
            break;
        case 'save_temp_answer':
            $question_index = (int)($_POST['question_index'] ?? -1);
            $option_id = $_POST['option_id'] ? (int)$_POST['option_id'] : null; 
            
            if ($question_index !== -1) {
                save_temp_answer($question_index, $option_id); 
            }
            
            $page = 'quiz';
            
            break;
        case 'leaderboard':
            $view_path = 'leaderboard.php';
            break;
    }
}


if (!is_logged_in() && $page !== 'login' && $page !== 'register') {
    $page = 'login';
}

if (is_logged_in() && ($page === 'login' || $page === 'register')) {
    $page = 'dashboard';
}

if ($page === 'quiz' && is_logged_in()) {
    $user_id = get_current_user_id();
    
    if (!isset($_SESSION['quiz_questions']) || empty($_SESSION['quiz_questions'])) {
        $available_quiz = get_available_quiz();
        
        if ($available_quiz) {
            $quiz_id = $available_quiz['id_quiz'];
            
            if (has_user_taken_quiz($user_id, $quiz_id)) {
                set_message("Anda sudah menyelesaikan kuis yang tersedia.", 'warning');
                $page = 'dashboard';
            } else {
                prepare_quiz_questions($quiz_id);
            }
        } else {
            set_message("Saat ini tidak ada kuis yang tersedia.", 'warning');
            $page = 'dashboard';
        }
    }
}

$view_path = __DIR__ . "/../app/views/{$page}.php";

if (file_exists($view_path)) {
    if (is_logged_in()) {
        require_once __DIR__ . '/../app/partials/navbar.php';
    }

    require_once $view_path;
} else {
    http_response_code(404);
    echo "<h1>404 Halaman Tidak Ditemukan!</h1>";
}