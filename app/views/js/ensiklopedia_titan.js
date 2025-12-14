// Titan data - pairs of titans
const titanData = [
    {
        left: {
            name: "Colossal Titan",
            image: "colossal_titan.jpg",
            description: "Titan dengan tinggi 60 meter yang pertama kali menghancurkan Tembok Maria. Memiliki kemampuan untuk melepaskan uap panas dalam jumlah besar dari tubuhnya dan dapat menyebabkan ledakan besar-besaran saat transformasi. Kekuatan destruktifnya tidak tertandingi."
        },
        right: {
            name: "Armored Titan",
            image: "armored_titan.jpg",
            description: "Titan setinggi 15 meter yang memiliki pelat armor keras menutupi sebagian besar tubuhnya. Armor ini memberikan pertahanan luar biasa dan kekuatan untuk mendobrak tembok. Dikenal karena kecepatan dan kekuatan tumbukkannya yang dahsyat."
        }
    },
    {
        left: {
            name: "Attack Titan",
            image: "attack_titan.jpg",
            description: "Salah satu Nine Titans yang dikenal karena semangat juangnya untuk kebebasan. Memiliki kemampuan unik untuk melihat kenangan masa depan dari penerus selanjutnya. Tingginya 15 meter dan terkenal dengan kemampuan tempurnya yang agresif dan tidak kenal takut."
        },
        right: {
            name: "Female Titan",
            image: "female_titan.jpg",
            description: "Titan dengan kemampuan spesial untuk memanggil Pure Titan melalui teriakannya. Memiliki mobilitas tinggi dan kemampuan untuk mengeras sebagian tubuhnya seperti kristal. Tingginya 14 meter dengan kemampuan tempur jarak dekat yang sangat baik."
        }
    },
    {
        left: {
            name: "Beast Titan",
            image: "beast_titan.jpg",
            description: "Titan yang memiliki penampilan menyerupai monyet raksasa. Memiliki kemampuan luar biasa dalam melempar objek dengan kecepatan dan akurasi tinggi. Dapat mengontrol Pure Titan melalui teriakan dan memiliki kecerdasan tinggi dalam pertempuran."
        },
        right: {
            name: "Jaw Titan",
            image: "jaw_titan.jpg",
            description: "Titan terkecil dari Nine Titans namun memiliki kecepatan dan kelincahan tertinggi. Rahang dan cakarnya sangat keras dan tajam, mampu menghancurkan hampir semua material. Tingginya 5 meter namun sangat mematikan dalam pertempuran jarak dekat."
        }
    }
];

// Pagination state
let currentPage = 0;

// DOM Elements
const contentDisplay = document.getElementById('content-display');
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');

// Initialize
function init() {
    displayContent();

    // Navigation button listeners
    prevBtn.addEventListener('click', () => {
        if (currentPage > 0) {
            currentPage--;
            displayContent();
        }
    });

    nextBtn.addEventListener('click', () => {
        if (currentPage < titanData.length - 1) {
            currentPage++;
            displayContent();
        }
    });
}

// Display content
function displayContent() {
    const data = titanData[currentPage];

    contentDisplay.innerHTML = `
        <div class="character-card">
            <img src="${data.left.image}" alt="${data.left.name}" class="character-image">
            <h2 class="character-name">${data.left.name}</h2>
            <p class="character-description">${data.left.description}</p>
        </div>
        <div class="character-card">
            <img src="${data.right.image}" alt="${data.right.name}" class="character-image">
            <h2 class="character-name">${data.right.name}</h2>
            <p class="character-description">${data.right.description}</p>
        </div>
    `;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', init);
