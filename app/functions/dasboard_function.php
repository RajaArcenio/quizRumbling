<?php

//fungsi untuk mengambil jumlah kuis yang sudah dikerjakan dan total jawaban benar
function get_user_quick_stats(int $user_id): array {
    global $conn;

    $stmt = $conn->prepare("
        SELECT 
            COUNT(r.id_result) AS total_quizzes,
            SUM(r.total_benar) AS total_correct_answers
        FROM result r
        WHERE r.id_user = ?
    ");

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stats = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $total_quizzes = (int)($stats['total_quizzes'] ?? 0);
    $total_correct_answers = (int)($stats['total_correct_answers'] ?? 0);

    return [
        'kuis_selesai' => $total_quizzes,
        'jawaban_benar' => $total_correct_answers,
    ];
}

//fungsi untuk menghitung ranking user berdasarkan total skor
function calculate_user_rank(int $user_id): int {
    global $conn;

    $stmt_score = $conn->prepare("SELECT total_score FROM users WHERE id = ?");
    $stmt_score->bind_param("i", $user_id);
    $stmt_score->execute();
    $current_score = $stmt_score->get_result()->fetch_assoc()['total_score'] ?? 0;
    $stmt_score->close();

    $stmt_rank = $conn->prepare("
        SELECT COUNT(id) AS higher_score_count 
        FROM users 
        WHERE total_score > ?
    ");

    $stmt_rank->bind_param("i", $current_score);
    $stmt_rank->execute();
    $higher_score_count = $stmt_rank->get_result()->fetch_assoc()['higher_score_count'] ?? 0;
    $stmt_rank->close();

    $rank = $higher_score_count + 1;
    
    return $rank;
}

//fungsi untuk mengambil info dashboard user: nama dan rank DITAMPILKAN DI ATAS
function get_user_dashboard_info(int $user_id): ?array {
    global $conn;

    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_info = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$user_info) {
        return null;
    }

    $rank = calculate_user_rank($user_id);

    return [
        'username' => $user_info['username'],
        'rank' => $rank
    ];
}