<?php

function register($username, $password) {
    global $conn;

    $username = htmlspecialchars(trim($username));
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt_check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $stmt_check->store_result();
    
    if ($stmt_check->num_rows > 0) {
        set_message("Username sudah digunakan. Gunakan username lain.");
        $stmt_check->close();
        return false;
    }

    $stmt_insert = $conn->prepare("INSERT INTO users(username, password) VALUES (?, ?)");
    $stmt_insert->bind_param("ss", $username, $hashed_password);

    if ($stmt_insert->execute()) {
        set_message("Pendaftaran berhasil! Silakan Login.", 'success');
        $stmt_insert->close();
        return true;
    } else {
        set_message("Pendaftaran gagal. Coba lagi nanti.");
        $stmt_insert->close();
        return false;
    }
}

function login($username, $password) {
    global $conn;

    $username = htmlspecialchars(trim($username));

    $stmt = $conn->prepare("SELECT username, password, isAdmin FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if($user) {
        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['isAdmin'] = $user['isAdmin'];

            if ($user['isAdmin']) {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: index.php");
            }
            return true;
        } else {
            set_message("Password salah.");
            return false;
        }
    } else {
        set_message("Username atau password salah.");
        return false;
    }
}

function logout_user() {
    $_SESSION = array();
    session_destroy();

    redirect('login'); 
    return true;
}
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return is_logged_in() && $_SESSION['is_admin'] == 1;
}
?>