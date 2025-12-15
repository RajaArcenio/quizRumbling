<?php

function register(string $email, string $username, string $password): bool {
    global $conn;

    // Sanitize dan Trim
    $username = htmlspecialchars(trim($username));
    $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Default nilai untuk user baru
    $default_score = 0;
    $is_admin = 0; // 0 = User Biasa

    // 1. Cek duplikasi username (dan email)
    $stmt_check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt_check->bind_param("ss", $username, $email);
    $stmt_check->execute();
    $stmt_check->store_result();
    
    if ($stmt_check->num_rows > 0) {
        set_message("Username atau Email sudah digunakan.");
        $stmt_check->close();
        return false;
    }
    $stmt_check->close();

    // 2. Insert User Baru
    // Anda mungkin perlu menambahkan kolom 'total_score' dan 'isAdmin' di tabel users
    $sql_insert = "INSERT INTO users (username, password, email, total_score, isAdmin) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    
    // Binding: s(username), s(password), s(email), i(score), i(isAdmin)
    $stmt_insert->bind_param("sssis", $username, $hashed_password, $email, $default_score, $is_admin);

    if ($stmt_insert->execute()) {
        set_message("Pendaftaran berhasil! Silakan Login.", 'success');
        $stmt_insert->close();
        return true;
    } else {
        error_log("Register failed: " . $stmt_insert->error);
        set_message("Pendaftaran gagal. Coba lagi nanti.");
        $stmt_insert->close();
        return false;
    }
}

function login(string $username, string $password): bool {
    global $conn;
    
    // Sanitize
    $username = htmlspecialchars(trim($username));

    // Ambil ID, username, password hash, dan isAdmin
    $stmt = $conn->prepare("SELECT id, username, password, isAdmin FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if($user) {
        if (password_verify($password, $user['password'])) {
            // LOGIN BERHASIL
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['isAdmin'] = $user['isAdmin'];

            // Fungsi hanya mengembalikan TRUE, routing dilakukan di index.php
            return true; 
        } else {
            set_message("Password salah.");
            return false;
        }
    } else {
        set_message("Username tidak ditemukan.");
        return false;
    }
}

function is_admin() {
    return is_logged_in() && ($_SESSION['isAdmin'] ?? 0) == 1; 
}

function logout_user() {
    $_SESSION = array();
    session_destroy();

    redirect('login'); 
    exit(); 
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}