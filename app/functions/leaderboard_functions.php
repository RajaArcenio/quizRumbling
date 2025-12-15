<?php

function get_leaderboard_data(): ?array {
    global $conn;

    $stmt = $conn->prepare("
        SELECT username, total_score 
        FROM users WHERE isAdmin = 0
        ORDER BY total_score DESC, username ASC
    ");

    $stmt->execute();
    $leaderboard = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $leaderboard ?: null;
}