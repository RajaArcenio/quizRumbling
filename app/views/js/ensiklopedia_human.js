// Human character data - pairs of characters
const humanData = [
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
        if (currentPage < humanData.length - 1) {
            currentPage++;
            displayContent();
        }
    });
}

// Display content
function displayContent() {
    const data = humanData[currentPage];

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
