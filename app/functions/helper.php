<?php

function redirect(string $page) {
    // Asumsi semua redirect  ke index.php
    header("Location: index.php?page=" . $page);
    exit(); 
}

function set_message(string $message, string $type = 'error'): void {
    $_SESSION['message'] = [
        'message' => $message,
        'type' => $type
    ];
}

function get_message(): ?array {
    if (isset($_SESSION['messages'])) {
        $message_data = $_SESSION['messages'];
        
        unset($_SESSION['messages']);
        
        return $message_data;
    }
    return null;
}

// FILE: app/functions/helper.php

function get_current_user_id(): int {
    return (int)($_SESSION['user_id'] ?? 0);
}