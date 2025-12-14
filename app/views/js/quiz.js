// Quiz data
const quizData = [
    {
        question: "APA NAMA DISTRIK PALING LUAR DI BAGIAN SELATAN TEMBOK MARIA YANG PERTAMA KALI DIHANCURKAN OLEH COLOSSAL TITAN?",
        options: {
            A: "DISTRIK TROST",
            B: "DISTRIK SHIGANSHINA",
            C: "DISTRIK STOHESS",
            D: "DISTRIK KARANES"
        },
        correct: "B"
    },
    {
        question: "SIAPA NAMA TITAN SHIFTER YANG MEMILIKI KEMAMPUAN UNTUK MENGERAS?",
        options: {
            A: "EREN YEAGER",
            B: "ANNIE LEONHART",
            C: "REINER BRAUN",
            D: "ZEKE YEAGER"
        },
        correct: "B"
    },
    {
        question: "APA NAMA KOMANDAN PASUKAN SURVEY CORPS SEBELUM ERWIN SMITH?",
        options: {
            A: "KEITH SHADIS",
            B: "HANGE ZOE",
            C: "LEVI ACKERMAN",
            D: "MIKE ZACHARIAS"
        },
        correct: "A"
    }
];

// State
let currentQuestion = 0;
let userAnswers = new Array(quizData.length).fill(null);
let timerSeconds = 0;
let timerInterval;

// DOM Elements
const questionElement = document.getElementById('question');
const currentQuestionElement = document.getElementById('current-question');
const timerElement = document.getElementById('timer');
const optionsElements = document.querySelectorAll('.option');
const previousBtn = document.querySelector('.previous-btn');
const nextBtn = document.querySelector('.next-btn');

// Initialize quiz
function initQuiz() {
    loadQuestion();
    startTimer();
    setupEventListeners();
}

// Load current question
function loadQuestion() {
    const question = quizData[currentQuestion];
    questionElement.textContent = question.question;
    currentQuestionElement.textContent = currentQuestion + 1;

    // Update options
    optionsElements.forEach((option, index) => {
        const optionKey = option.getAttribute('data-option');
        const optionText = option.querySelector('.option-text');
        optionText.textContent = question.options[optionKey];

        // Remove previous selection
        option.classList.remove('selected');

        // Show saved answer if exists
        if (userAnswers[currentQuestion] === optionKey) {
            option.classList.add('selected');
        }
    });

    // Update button states
    previousBtn.disabled = currentQuestion === 0;
    if (currentQuestion === quizData.length - 1) {
        nextBtn.textContent = 'SUBMIT';
    } else {
        nextBtn.textContent = 'NEXT';
    }
}

// Setup event listeners
function setupEventListeners() {
    // Option selection
    optionsElements.forEach(option => {
        option.addEventListener('click', () => {
            const selectedOption = option.getAttribute('data-option');
            userAnswers[currentQuestion] = selectedOption;

            // Update UI
            optionsElements.forEach(opt => opt.classList.remove('selected'));
            option.classList.add('selected');
        });
    });

    // Navigation buttons
    previousBtn.addEventListener('click', () => {
        if (currentQuestion > 0) {
            currentQuestion--;
            loadQuestion();
        }
    });

    nextBtn.addEventListener('click', () => {
        if (currentQuestion < quizData.length - 1) {
            currentQuestion++;
            loadQuestion();
        } else {
            submitQuiz();
        }
    });
}

// Timer function
function startTimer() {
    timerInterval = setInterval(() => {
        timerSeconds++;
        const minutes = Math.floor(timerSeconds / 60);
        const seconds = timerSeconds % 60;
        timerElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }, 1000);
}

// Submit quiz
function submitQuiz() {
    clearInterval(timerInterval);

    let correctAnswers = 0;
    quizData.forEach((question, index) => {
        if (userAnswers[index] === question.correct) {
            correctAnswers++;
        }
    });

    const score = (correctAnswers / quizData.length * 100).toFixed(0);
    alert(`Quiz Selesai!\n\nJawaban Benar: ${correctAnswers}/${quizData.length}\nSkor: ${score}%\nWaktu: ${timerElement.textContent}`);

    // Redirect to dashboard or results page
    window.location.href = 'dashboard.html';
}

// Start quiz when page loads
document.addEventListener('DOMContentLoaded', initQuiz);
