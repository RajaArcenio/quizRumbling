// Encyclopedia data - separated by category with pairs of characters
const encyclopediaData = {
    human: [
        {
            left: {
                name: "Eren Yeager",
                image: "eren_yeager.jpg",
                description: "Berasal dari Distrik Shiganshina. Setelah menyaksikan ibunya dimakan Titan di depan matanya sendiri saat tembok Maria runtuh, ia bersumpah untuk membasmi seluruh Titan dari muka bumi. Ia memegang kunci misteri ruang bawah tanah ayahnya yang konon menyimpan kebenaran tentang dunia."
            },
            right: {
                name: "Armin Arlert",
                image: "armin_arlert.jpg",
                description: "Sahabat masa kecil Eren dan Mikasa. Meskipun secara fisik ia tidak sekuat prajurit lain, kecerdasannya yang tajam dan kemampuan analisisnya yang tajam sering membuat pasukan dalam situasi kritis. Ia memiliki impian besar untuk melihat dunia luar dan lautan yang luas."
            }
        },
        {
            left: {
                name: "Mikasa Ackerman",
                image: "mikasa_ackerman.jpg",
                description: "Anak angkat Eren yang sangat protektif terhadapnya. Sebagai anggota klan Ackerman, ia memiliki kemampuan tempur luar biasa yang melampaui manusia normal. Ia dikenal sebagai salah satu prajurit terkuat di Survey Corps dan selalu memakai syal merah pemberian Eren."
            },
            right: {
                name: "Levi Ackerman",
                image: "levi_ackerman.jpg",
                description: "Kapten Special Operations Squad dari Survey Corps dan dianggap sebagai tentara terkuat umat manusia. Meskipun bertubuh kecil, kemampuan tempurnya tidak tertandingi. Ia memiliki obsesi terhadap kebersihan dan standar yang sangat tinggi untuk anak buahnya."
            }
        },
        {
            left: {
                name: "Erwin Smith",
                image: "erwin_smith.jpg",
                description: "Komandan ke-13 dari Survey Corps. Seorang pemimpin karismatik dengan kemampuan strategis yang brilian. Ia rela mengorbankan apapun, termasuk nyawanya sendiri, demi mengungkap kebenaran tentang Titan dan dunia di luar tembok."
            },
            right: {
                name: "Hange Zoe",
                image: "hange_zoe.jpg",
                description: "Section Commander Survey Corps yang bertanggung jawab atas penelitian Titan. Sangat antusias dan eksentrik dalam meneliti Titan, bahkan memberikan nama untuk Titan percobaan mereka. Kecerdasan dan keingintahuannya sangat membantu dalam memahami musuh."
            }
        }
    ],
    titan: [
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
    ]
};

// Pagination state
let currentCategory = null;
let currentPage = 0;

// DOM Elements
const contentDisplay = document.getElementById('content-display');
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');
const categoryButtons = document.querySelectorAll('.category-btn');
const navigationButtons = document.getElementById('navigation-buttons');
const categoryButtonsContainer = document.getElementById('category-buttons');

// Initialize
function init() {
    // Add event listeners to category buttons
    categoryButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const category = btn.dataset.category;
            selectCategory(category);

            // Update active state
            categoryButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });

    // Navigation button listeners
    prevBtn.addEventListener('click', () => {
        if (currentPage > 0) {
            currentPage--;
            displayContent();
        }
    });

    nextBtn.addEventListener('click', () => {
        if (currentCategory && currentPage < encyclopediaData[currentCategory].length - 1) {
            currentPage++;
            displayContent();
        }
    });
}

// Select category
function selectCategory(category) {
    currentCategory = category;
    currentPage = 0;

    // Hide category buttons, show navigation and content
    categoryButtonsContainer.style.display = 'none';
    navigationButtons.style.display = 'flex';

    displayContent();
}

// Display content
function displayContent() {
    if (!currentCategory) return;

    const data = encyclopediaData[currentCategory][currentPage];

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
