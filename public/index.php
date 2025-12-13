<?php
session_start();

require_once __DIR__ . '/../app/config/database.php'; 


require_once __DIR__ . '/../app/functions/helper.php'; 
require_once __DIR__ . '/../app/functions/auth.php'; 
require_once __DIR__ . '/../app/functions/dasboard_function.php';
require_once __DIR__ . '/../app/functions/quiz_function.php';

$page = $_GET['page'] ?? 'dashboard';
$action = $_POST['action'] ?? null;

if ($action) {
    switch ($action) {
        case 'login':
            login($_POST['username'] ?? '', $_POST['password'] ?? '');
            break;
        case 'register':
            register($_POST['username'] ?? '', $_POST['password'] ?? '');
            break;
        case 'start_quiz':
            $quiz_id = (int)($_POST['quiz_id'] ?? 0);
            if ($quiz_id > 0) {
                prepare_quiz_questions($quiz_id);
                redirect('quiz'); 
            }
            break;
        case 'submit_quiz':
            submit_quiz(get_current_user_id());
            break;
    }
}


if (!is_logged_in() && $page !== 'login' && $page !== 'register') {
    $page = 'login';
}

if (is_logged_in() && ($page === 'login' || $page === 'register')) {
    $page = 'dashboard';
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