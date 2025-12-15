// // Sample leaderboard data
// const leaderboardData = [
//     // { username: "EREN_YEAGER", score: 9500, rank: 1 },
//     // { username: "MIKASA_ACKERMAN", score: 9200, rank: 2 },
//     // { username: "LEVI_ACKERMAN", score: 8900, rank: 3 },
//     // { username: "ARMIN_ARLERT", score: 8700, rank: 4 },
//     // { username: "ERWIN_SMITH", score: 8500, rank: 5 },
//     // { username: "HANGE_ZOE", score: 8300, rank: 6 },
//     // { username: "JEAN_KIRSTEIN", score: 8100, rank: 7 },
//     // { username: "CONNIE_SPRINGER", score: 7900, rank: 8 },
//     // { username: "SASHA_BRAUS", score: 7700, rank: 9 },
//     // { username: "HISTORIA_REISS", score: 7500, rank: 10 },
//     // { username: "REINER_BRAUN", score: 7300, rank: 11 },
//     // { username: "ANNIE_LEONHART", score: 7100, rank: 12 },
//     // { username: "BERTHOLDT_HOOVER", score: 6900, rank: 13 },
//     // { username: "YMIR_FRITZ", score: 6700, rank: 14 },
//     // { username: "ZEKE_YEAGER", score: 6500, rank: 15 },
//     // { username: "PIECK_FINGER", score: 6300, rank: 16 },
//     // { username: "PORCO_GALLIARD", score: 6100, rank: 17 },
//     // { username: "FALCO_GRICE", score: 5900, rank: 18 },
//     // { username: "GABI_BRAUN", score: 5700, rank: 19 },
//     // { username: "KENNY_ACKERMAN", score: 5500, rank: 20 },
//     // { username: "FLOCH_FORSTER", score: 5300, rank: 21 },
//     // { username: "MARCO_BOTT", score: 5100, rank: 22 },
//     // { username: "MOBLIT_BERNER", score: 4900, rank: 23 },
//     // { username: "PETRA_RAL", score: 4700, rank: 24 },
//     // { username: "OLUO_BOZADO", score: 4500, rank: 25 }
// ];

// // Pagination state
// const itemsPerPage = 10;
// let currentPage = 1;
// const totalPages = Math.ceil(leaderboardData.length / itemsPerPage);

// // DOM Elements
// const leaderboardBody = document.getElementById('leaderboard-body');
// const prevBtn = document.getElementById('prev-btn');
// const nextBtn = document.getElementById('next-btn');

// // Render leaderboard for current page
// function renderLeaderboard() {
//     // Clear existing rows
//     leaderboardBody.innerHTML = '';

//     // Calculate start and end indices
//     const startIndex = (currentPage - 1) * itemsPerPage;
//     const endIndex = Math.min(startIndex + itemsPerPage, leaderboardData.length);

//     // Get data for current page
//     const pageData = leaderboardData.slice(startIndex, endIndex);

//     // Create table rows
//     pageData.forEach(player => {
//         const row = document.createElement('tr');
//         row.innerHTML = `
//             <td>${player.username}</td>
//             <td>${player.score.toLocaleString()}</td>
//             <td>${player.rank}</td>
//         `;
//         leaderboardBody.appendChild(row);
//     });

//     // Update button states
//     updateButtonStates();
// }

// // Update button states based on current page
// function updateButtonStates() {
//     prevBtn.disabled = currentPage === 1;
//     nextBtn.disabled = currentPage === totalPages;
// }

// // Event listeners
// prevBtn.addEventListener('click', () => {
//     if (currentPage > 1) {
//         currentPage--;
//         renderLeaderboard();
//     }
// });

// nextBtn.addEventListener('click', () => {
//     if (currentPage < totalPages) {
//         currentPage++;
//         renderLeaderboard();
//     }
// });

// // Initialize leaderboard on page load
// document.addEventListener('DOMContentLoaded', () => {
//     renderLeaderboard();
// });
