<?php

$leaderboard_data = get_leaderboard_data();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard - Attack on Titan</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../app/views/css/variables.css"> 
    <link rel="stylesheet" href="../app/views/css/leaderboard.css">
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
    <div class="leaderboard-container">
        <div class="top-bar">
            <span>LEADERBOARD</span>
        </div>

        <div class="leaderboard-card card-with-overlay">
            <table class="leaderboard-table">
                <thead>
                    <tr>
                        <th>RANKING</th> <th>USERNAME</th>
                        <th>TOTAL SKOR</th>
                    </tr>
                </thead>
                <tbody id="leaderboard-body">
                    <tr><td colspan="3">Memuat data...</td></tr>
                </tbody>
            </table>

            <div class="pagination-buttons">
                <button class="nav-btn previous-btn" id="prev-btn">PREVIOUS</button>
                <button class="nav-btn next-btn" id="next-btn">NEXT</button>
            </div>
        </div>
    </div>

    <script>
        // 1. INJEKSI DATA PHP KE JAVASCRIPT
        <?php
        // Mengubah array PHP menjadi string JSON, dan memasukkannya sebagai variabel JS global
        // Jika data null, gunakan array kosong agar JS tidak error
        $data_json = json_encode($leaderboard_data ?: []);
        echo "const leaderboardRawData = " . $data_json . ";";
        ?>

        // 2. KOREKSI STRUKTUR DATA (MENGGABUNGKAN RANK DAN SCORE)
        // Kita hitung rank dan sesuaikan nama field (total_score -> score)
        const leaderboardData = leaderboardRawData.map((user, index) => {
            return {
                username: user.username,
                score: parseInt(user.total_score, 10), // Pastikan score adalah angka
                rank: index + 1 // Rank dihitung berdasarkan urutan dari DB (yang sudah di ORDER BY)
            };
        });

        // 3. PAGINATION STATE (Dihitung ulang berdasarkan data yang diinjeksi)
        const itemsPerPage = 10;
        let currentPage = 1;
        const totalPages = Math.ceil(leaderboardData.length / itemsPerPage);

        // 4. DOM Elements
        const leaderboardBody = document.getElementById('leaderboard-body');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');

        // 5. Render leaderboard for current page
        function renderLeaderboard() {
            leaderboardBody.innerHTML = ''; // Clear existing rows

            // Handle No Data
            if (leaderboardData.length === 0) {
                leaderboardBody.innerHTML = '<tr><td colspan="3">Tidak ada data Leaderboard.</td></tr>';
                updateButtonStates();
                return;
            }

            // Calculate start and end indices
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, leaderboardData.length);

            // Get data for current page
            const pageData = leaderboardData.slice(startIndex, endIndex);

            // Create table rows
            pageData.forEach(player => {
                const row = document.createElement('tr');
                
                // Tambahkan kelas khusus untuk Top 3
                if (player.rank <= 3) {
                    row.classList.add('top-three');
                }

                row.innerHTML = `
                    <td>${player.rank}</td>
                    <td>${player.username}</td>
                    <td>${player.score.toLocaleString()}</td>
                `;
                leaderboardBody.appendChild(row);
            });

            // Update button states
            updateButtonStates();
        }

        // 6. Update button states based on current page
        function updateButtonStates() {
            // Hanya aktifkan tombol jika totalPages > 1
            const shouldDisable = totalPages <= 1;
            
            prevBtn.disabled = shouldDisable || currentPage === 1;
            nextBtn.disabled = shouldDisable || currentPage === totalPages;
        }

        // 7. Event listeners
        prevBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderLeaderboard();
            }
        });

        nextBtn.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                renderLeaderboard();
            }
        });

        // 8. Initialize leaderboard on page load
        document.addEventListener('DOMContentLoaded', () => {
            renderLeaderboard();
        });
    </script>
</body>

</html>