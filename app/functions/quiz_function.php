<?php

//fungsi untuk menampilkan quiz yang tersedia, panggil di halaman quiz
//di array index 0 id_quiz, 1 judul_quiz
function get_available_quiz(): ?array {
    global $conn;
    $today = date('Y-m-d H:i:s');
    
    $stmt = $conn->prepare("SELECT id_quiz, judul_quiz FROM quiz WHERE ? BETWEEN available_from AND available_until LIMIT 1");
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $result = $stmt->get_result();
    $quiz = $result->fetch_assoc();
    $stmt->close();

    return $quiz;
}

//fungsi untuk mengecek apakah user sudah mengerjakan quiz, panggil bareng sama quiz_available
function has_user_taken_quiz(int $user_id, int $quiz_id): bool {
    global $conn;
    
    $stmt = $conn->prepare("SELECT id_result FROM result WHERE id_user = ? AND id_quiz = ?");
    $stmt->bind_param("ii", $user_id, $quiz_id);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();
    
    return $num_rows > 0;
}

//fungsi untuk load question dan opsi, panggil di halaman quiz sebelum menampilkan soal sebelum memencet kerjakan soal
//di array index 0 id_soal, 1 teks_soal, 2 opsi (array of array id_opsi, teks_opsi)
function prepare_quiz_questions(int $quiz_id): ?array {
    global $conn;
    
    $stmt = $conn->prepare("SELECT id_soal, teks_soal FROM soal WHERE id_quiz = ? ORDER BY RAND() LIMIT 5");
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    $questions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    
    if (empty($questions)) {
        return null;
    }
    
    $quiz_data = [];
    foreach ($questions as $q) {
        $q_id = $q['id_soal'];

        $stmt_opsi = $conn->prepare("SELECT id_opsi, teks_opsi FROM list_opsi WHERE id_soal = ?");
        $stmt_opsi->bind_param("i", $q_id);
        $stmt_opsi->execute();
        $options = $stmt_opsi->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt_opsi->close();

        shuffle($options); 
        
        $quiz_data[] = [
            'id_soal' => $q_id,
            'teks_soal' => $q['teks_soal'],
            'opsi' => $options
        ];
    }

    $_SESSION['current_quiz_id'] = $quiz_id;
    $_SESSION['quiz_questions'] = $quiz_data;
    $_SESSION['user_answers'] = array_fill(0, count($quiz_data), null);
    return $quiz_data;
}

//fungsi buat nyimpen jawaban sementara di session, panggil di halaman quiz waktu user milih jawaban atau waktu user tekan tombol next/prev
function save_temp_answer(int $question_index, ?int $option_id): void {
    if (isset($_SESSION['user_answers'][$question_index])) {
        $_SESSION['user_answers'][$question_index] = $option_id;
    }
}

//dipanggil di submit quiz, untuk cek jawaban benar atau salah
//ngga usah dipanggil di halaman quiz
function check_answer_correctness(int $option_id): bool {
    global $conn;

    $stmt = $conn->prepare("SELECT isRight FROM list_opsi WHERE id_opsi = ? LIMIT 1");
    $stmt->bind_param("i", $option_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return (isset($result) && $result['isRight'] == 1);
}

//fungsi untuk submit quiz, panggil di halaman quiz terakhir submit quiz waktu user menekan tombol submit
function submit_quiz(int $user_id): bool {
    global $conn;

    if (!isset($_SESSION['current_quiz_id']) || !isset($_SESSION['user_answers']) || !isset($_SESSION['quiz_questions'])) {
        set_message("Sesi kuis tidak valid atau telah berakhir. Harap ulangi kuis.", 'error');
        redirect('dashboard');
        return false;
    }

    $quiz_id = (int)$_SESSION['current_quiz_id'];
    $user_answers = $_SESSION['user_answers'];
    $quiz_questions = $_SESSION['quiz_questions'];

    $total_correct = 0;
    $final_score = 0;

    $conn->begin_transaction(); 

    try {
        $total_questions = count($quiz_questions);
        $total_wrong = $total_questions;

        $stmt_result = $conn->prepare("INSERT INTO result (id_user, id_quiz, total_benar, total_salah, score) VALUES (?, ?, ?, ?, ?)");

        $temp_benar = 0; $temp_salah = 0; $temp_score = 0;
        $stmt_result->bind_param("iiiii", $user_id, $quiz_id, $temp_benar, $temp_salah, $temp_score);
        $stmt_result->execute();
        $result_id = $conn->insert_id;
        $stmt_result->close();

        $stmt_detail = $conn->prepare("INSERT INTO result_detail (id_result, id_soal, id_opsi, isCorrect) VALUES (?, ?, ?, ?)");

        foreach ($quiz_questions as $index => $question) {
            $q_id = $question['id_soal'];
            $chosen_opt_id = $user_answers[$index];

            if ($chosen_opt_id) {
                $is_correct = check_answer_correctness($chosen_opt_id) ? 1 : 0;
            } else {
                $is_correct = 0;
                $chosen_opt_id = 0;
            }

            if ($is_correct === 1) {
                $total_correct++;
                $final_score += 20;
            }

            $stmt_detail->bind_param("iiii", $result_id, $q_id, $chosen_opt_id, $is_correct);
            $stmt_detail->execute();
        }
        $stmt_detail->close();

        $total_wrong = $total_questions - $total_correct;

        $stmt_update_result = $conn->prepare("UPDATE result SET total_benar = ?, total_salah = ?, score = ? WHERE id_result = ?");
        $stmt_update_result->bind_param("iiii", $total_correct, $total_wrong, $final_score, $result_id);
        $stmt_update_result->execute();
        $stmt_update_result->close();

        $stmt_update_user = $conn->prepare("UPDATE users SET total_score = total_score + ? WHERE id = ?");
        $stmt_update_user->bind_param("ii", $final_score, $user_id);
        $stmt_update_user->execute();
        $stmt_update_user->close();
        
        $conn->commit();

        unset($_SESSION['current_quiz_id']);
        unset($_SESSION['quiz_questions']);
        unset($_SESSION['user_answers']);

        redirect('result_page');
        return true;

    } catch (Exception $e) {
        $conn->rollback();
        error_log("Quiz Submission Failed: " . $e->getMessage());
        set_message("Terjadi kesalahan saat menyimpan hasil kuis. Harap coba lagi.", 'error');
        redirect('dashboard');
        return false;
    }
}

//panggil di halaman result_page untuk menampilkan hasil quiz 
//di array index 0 judul quiz, 1 total benar, 2 total salah, 3 score
function get_quiz_result(int $user_id, int $quiz_id): ?array {
    global $conn;

    $stmt = $conn->prepare("
        SELECT 
            q.judul_quiz, 
            r.total_benar, 
            r.total_salah, 
            r.score
        FROM result r
        JOIN quiz q ON r.id_quiz = q.id_quiz
        WHERE r.id_user = ? AND r.id_quiz = ?
        ORDER BY r.id_result DESC
        LIMIT 1
    ");

    $stmt->bind_param("ii", $user_id, $quiz_id);
    $stmt->execute();
    $result_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $result_data;
}