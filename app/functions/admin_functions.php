<?php

function create_new_quiz(string $judul_quiz, string $available_from, string $available_until): int|bool {
    global $conn;

    $judul = trim($judul_quiz);
    $stmt = $conn->prepare("INSERT INTO quiz (judul_quiz, available_from, available_until) VALUES (?, ?, ?)");

    $stmt->bind_param("sss", $judul, $available_from, $available_until);

    if ($stmt->execute()) {
        $new_quiz_id = $conn->insert_id;
        $stmt->close();
        return $new_quiz_id;
    } else {
        error_log("Execute failed: " . $stmt->error);
        $stmt->close();
        return false;
    }
}

function create_quiz_question(int $quiz_id, string $question_text): int|bool {
    global $conn;

    $sql = "INSERT INTO question (id_quiz, question_text) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return false;
    }

    $stmt->bind_param("is", $quiz_id, $question_text); // i = integer, s = string
    
    if ($stmt->execute()) {
        $new_question_id = $conn->insert_id;
        $stmt->close();
        return $new_question_id;
    } else {
        error_log("Execute failed: " . $stmt->error);
        $stmt->close();
        return false;
    }
}

function create_question_options(int $question_id, array $options): bool {
    global $conn;

    // Persiapan query INSERT
    $sql = "INSERT INTO `option` (id_question, option_text, is_correct) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        error_log("Prepare failed for options: " . $conn->error);
        return false;
    }

    $success = true;
    
    // Looping untuk setiap opsi jawaban
    foreach ($options as $option) {
        $option_text = $option['option_text'];
        $is_correct = (int)$option['is_correct']; // Pastikan 0 atau 1
        
        // Binding parameter untuk setiap opsi
        $stmt->bind_param("isi", $question_id, $option_text, $is_correct); // i = int, s = string, i = int
        
        // Eksekusi
        if (!$stmt->execute()) {
            error_log("Option execute failed: " . $stmt->error);
            $success = false;
            break; // Hentikan looping jika ada yang gagal
        }
    }

    $stmt->close();
    return $success;
}