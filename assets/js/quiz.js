/**
 * SIEGA Career Path Interactive Quiz
 * Helps students find the right concentration based on their interests
 */

// Quiz Data
const quizData = {
    questions: [
        {
            id: 1,
            question: "Apa yang paling kamu sukai dari teknologi?",
            options: [
                { text: "Menganalisis data dan membuat keputusan bisnis", points: { SI: 3, EC: 1, GT: 0, AK: 2 } },
                { text: "Menjual produk dan berinteraksi dengan customer", points: { SI: 0, EC: 3, GT: 1, AK: 0 } },
                { text: "Membuat game dan konten multimedia", points: { SI: 0, EC: 0, GT: 3, AK: 0 } },
                { text: "Mengelola keuangan dan angka-angka", points: { SI: 1, EC: 0, GT: 0, AK: 3 } }
            ]
        },
        {
            id: 2,
            question: "Tipe project apa yang paling menarik bagimu?",
            options: [
                { text: "Sistem ERP untuk perusahaan besar", points: { SI: 3, EC: 0, GT: 0, AK: 2 } },
                { text: "Platform marketplace online", points: { SI: 1, EC: 3, GT: 0, AK: 1 } },
                { text: "Game mobile atau VR experience", points: { SI: 0, EC: 0, GT: 3, AK: 0 } },
                { text: "Software akuntansi dan audit", points: { SI: 1, EC: 0, GT: 0, AK: 3 } }
            ]
        },
        {
            id: 3,
            question: "Skill apa yang ingin kamu kuasai?",
            options: [
                { text: "Business intelligence & data analytics", points: { SI: 3, EC: 1, GT: 0, AK: 1 } },
                { text: "Digital marketing & SEO", points: { SI: 0, EC: 3, GT: 1, AK: 0 } },
                { text: "3D modeling & game design", points: { SI: 0, EC: 0, GT: 3, AK: 0 } },
                { text: "Financial analysis & auditing", points: { SI: 0, EC: 0, GT: 0, AK: 3 } }
            ]
        },
        {
            id: 4,
            question: "Karir impian kamu adalah?",
            options: [
                { text: "System Analyst / IT Consultant", points: { SI: 3, EC: 0, GT: 0, AK: 1 } },
                { text: "E-Commerce Manager / Digital Marketer", points: { SI: 0, EC: 3, GT: 0, AK: 0 } },
                { text: "Game Developer / 3D Artist", points: { SI: 0, EC: 0, GT: 3, AK: 0 } },
                { text: "IT Auditor / Financial Analyst", points: { SI: 1, EC: 0, GT: 0, AK: 3 } }
            ]
        },
        {
            id: 5,
            question: "Environment kerja yang kamu suka?",
            options: [
                { text: "Kantor korporat dengan sistem terstruktur", points: { SI: 3, EC: 1, GT: 0, AK: 3 } },
                { text: "Startup dinamis dengan culture fleksibel", points: { SI: 1, EC: 3, GT: 2, AK: 0 } },
                { text: "Studio kreatif dengan tim kolaboratif", points: { SI: 0, EC: 1, GT: 3, AK: 0 } },
                { text: "Firm konsultan dengan project variety", points: { SI: 2, EC: 1, GT: 0, AK: 3 } }
            ]
        },
        {
            id: 6,
            question: "Software/tools apa yang paling menarik?",
            options: [
                { text: "SAP, Oracle, Power BI", points: { SI: 3, EC: 0, GT: 0, AK: 2 } },
                { text: "Google Analytics, Facebook Ads, Shopify", points: { SI: 0, EC: 3, GT: 0, AK: 0 } },
                { text: "Unity, Unreal Engine, Blender", points: { SI: 0, EC: 0, GT: 3, AK: 0 } },
                { text: "MYOB, Accurate, Zahir Accounting", points: { SI: 1, EC: 0, GT: 0, AK: 3 } }
            ]
        },
        {
            id: 7,
            question: "Apa yang paling penting dalam pekerjaan?",
            options: [
                { text: "Memecahkan masalah bisnis yang kompleks", points: { SI: 3, EC: 1, GT: 0, AK: 2 } },
                { text: "Meningkatkan sales dan revenue", points: { SI: 0, EC: 3, GT: 0, AK: 1 } },
                { text: "Menciptakan experience yang memorable", points: { SI: 0, EC: 1, GT: 3, AK: 0 } },
                { text: "Accuracy dan compliance dengan standar", points: { SI: 1, EC: 0, GT: 0, AK: 3 } }
            ]
        },
        {
            id: 8,
            question: "Mata kuliah favorit di SMA?",
            options: [
                { text: "Matematika & Logika", points: { SI: 3, EC: 0, GT: 1, AK: 3 } },
                { text: "Ekonomi & Kewirausahaan", points: { SI: 1, EC: 3, GT: 0, AK: 2 } },
                { text: "Seni & Desain", points: { SI: 0, EC: 1, GT: 3, AK: 0 } },
                { text: "Akuntansi & Statistik", points: { SI: 1, EC: 0, GT: 0, AK: 3 } }
            ]
        }
    ],
    results: {
        SI: {
            title: "Sistem Informasi",
            icon: "💻",
            description: "Kamu cocok untuk menganalisis kebutuhan bisnis dan merancang solusi IT yang efektif. Karir cemerlang menanti sebagai Business Analyst, System Analyst, atau IT Consultant!",
            careers: ["Business Analyst", "System Analyst", "IT Consultant", "Data Analyst", "ERP Specialist"],
            salaryRange: "Rp 8-30 juta/bulan",
            link: "/pages/user/konsentrasi/sistem-informasi.php",
            color: "from-indigo-500 to-indigo-700"
        },
        EC: {
            title: "E-Commerce",
            icon: "🛒",
            description: "Kamu memiliki jiwa entrepreneur dan passion di bisnis digital! Perfect untuk berkarir sebagai Digital Marketer, E-Commerce Manager, atau membangun startup sendiri.",
            careers: ["Digital Marketing Specialist", "E-Commerce Manager", "Social Media Strategist", "Online Entrepreneur"],
            salaryRange: "Rp 7-50 juta/bulan",
            link: "/pages/user/konsentrasi/e-commerce.php",
            color: "from-cyan-500 to-cyan-700"
        },
        GT: {
            title: "Game Technology",
            icon: "🎮",
            description: "Kreativitas dan technical skills kamu sangat cocok untuk industri game! Masa depan cerah sebagai Game Developer, 3D Artist, atau VR/AR Specialist menantimu.",
            careers: ["Game Developer", "3D Artist/Animator", "VR/AR Developer", "Game Designer"],
            salaryRange: "Rp 7-20 juta/bulan",
            link: "/pages/user/konsentrasi/game-technology.php",
            color: "from-pink-500 to-pink-700"
        },
        AK: {
            title: "Akuntansi-Sistem Informasi",
            icon: "💼",
            description: "Double expertise in accounting and IT makes you highly valuable! Perfect career path sebagai IT Auditor, Financial Analyst, atau ERP Consultant dengan gaji premium.",
            careers: ["IT Auditor", "Financial Analyst", "ERP Consultant (Finance)", "Fintech Specialist"],
            salaryRange: "Rp 12-35 juta/bulan",
            link: "/pages/user/konsentrasi/akuntansi-si.php",
            color: "from-orange-500 to-orange-700"
        }
    }
};

// Quiz State
let currentQuestion = 0;
let scores = { SI: 0, EC: 0, GT: 0, AK: 0 };
let answeredQuestions = new Set();

// Initialize Quiz
function initQuiz() {
    currentQuestion = 0;
    scores = { SI: 0, EC: 0, GT: 0, AK: 0 };
    answeredQuestions = new Set();
    
    renderQuestion();
    updateProgress();
}

// Render Current Question
function renderQuestion() {
    const question = quizData.questions[currentQuestion];
    const container = document.getElementById('quiz-question-container');
    
    if (!container) return;
    
    const html = `
        <div class="quiz-question-card animate-fade-in">
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-cyan-400 font-semibold">Pertanyaan ${currentQuestion + 1} dari ${quizData.questions.length}</span>
                    <span class="text-slate-400 text-sm">${Math.round(((currentQuestion + 1) / quizData.questions.length) * 100)}% Complete</span>
                </div>
                <h3 class="text-2xl font-bold text-white mb-6">${question.question}</h3>
            </div>
            
            <div class="space-y-4">
                ${question.options.map((option, index) => `
                    <button 
                        onclick="selectAnswer(${index})" 
                        class="option-btn w-full text-left p-4 bg-slate-800 hover:bg-slate-700 border-2 border-slate-700 hover:border-cyan-500 rounded-xl transition-all group"
                    >
                        <div class="flex items-center">
                            <span class="flex-shrink-0 w-8 h-8 bg-slate-700 group-hover:bg-cyan-500 rounded-full flex items-center justify-center text-white font-semibold mr-4 transition-all">
                                ${String.fromCharCode(65 + index)}
                            </span>
                            <span class="text-slate-300 group-hover:text-white transition-colors">${option.text}</span>
                        </div>
                    </button>
                `).join('')}
            </div>
        </div>
    `;
    
    container.innerHTML = html;
}

// Select Answer
function selectAnswer(optionIndex) {
    const question = quizData.questions[currentQuestion];
    const selectedOption = question.options[optionIndex];
    
    // Add points
    for (let key in selectedOption.points) {
        scores[key] += selectedOption.points[key];
    }
    
    // Mark as answered
    answeredQuestions.add(currentQuestion);
    
    // Visual feedback
    const buttons = document.querySelectorAll('.option-btn');
    buttons[optionIndex].classList.add('border-green-500', 'bg-green-500/20');
    
    // Disable all buttons
    buttons.forEach(btn => btn.disabled = true);
    
    // Move to next question after delay
    setTimeout(() => {
        if (currentQuestion < quizData.questions.length - 1) {
            currentQuestion++;
            renderQuestion();
            updateProgress();
        } else {
            showResults();
        }
    }, 500);
}

// Update Progress Bar
function updateProgress() {
    const progressBar = document.getElementById('quiz-progress-bar');
    if (!progressBar) return;
    
    const progress = ((currentQuestion + 1) / quizData.questions.length) * 100;
    progressBar.style.width = `${progress}%`;
}

// Calculate and Show Results
function showResults() {
    // Find concentration with highest score
    let maxScore = 0;
    let winner = 'SI';
    
    for (let key in scores) {
        if (scores[key] > maxScore) {
            maxScore = scores[key];
            winner = key;
        }
    }
    
    const result = quizData.results[winner];
    const container = document.getElementById('quiz-question-container');
    
    if (!container) return;
    
    // Sort scores for ranking
    const sortedScores = Object.entries(scores).sort((a, b) => b[1] - a[1]);
    
    const html = `
        <div class="quiz-result-card animate-fade-in">
            <!-- Celebration Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br ${result.color} rounded-full mb-4 animate-bounce">
                    <span class="text-5xl">${result.icon}</span>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Hasilmu adalah:</h2>
                <h3 class="text-4xl font-extrabold bg-gradient-to-r ${result.color} bg-clip-text text-transparent mb-4">
                    ${result.title}
                </h3>
                <p class="text-slate-300 text-lg max-w-2xl mx-auto leading-relaxed">
                    ${result.description}
                </p>
            </div>
            
            <!-- Career Paths -->
            <div class="bg-slate-800/50 rounded-xl p-6 mb-6">
                <h4 class="text-white font-bold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Peluang Karir:
                </h4>
                <div class="flex flex-wrap gap-2 mb-4">
                    ${result.careers.map(career => `
                        <span class="px-3 py-1 bg-slate-700 text-slate-300 rounded-full text-sm">${career}</span>
                    `).join('')}
                </div>
                <p class="text-slate-400 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <strong>Salary Range:</strong>&nbsp;${result.salaryRange}
                </p>
            </div>
            
            <!-- Score Breakdown -->
            <div class="bg-slate-800/50 rounded-xl p-6 mb-6">
                <h4 class="text-white font-bold mb-4">Detail Skor Kamu:</h4>
                <div class="space-y-3">
                    ${sortedScores.map(([key, score], index) => {
                        const info = quizData.results[key];
                        const percentage = (score / maxScore) * 100;
                        return `
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-slate-300 flex items-center">
                                        <span class="mr-2">${info.icon}</span>
                                        ${info.title}
                                        ${index === 0 ? '<span class="ml-2 px-2 py-0.5 bg-green-500 text-white text-xs rounded-full">Top Match!</span>' : ''}
                                    </span>
                                    <span class="text-cyan-400 font-semibold">${score} pts</span>
                                </div>
                                <div class="w-full bg-slate-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r ${info.color} h-2 rounded-full transition-all duration-1000" style="width: ${percentage}%"></div>
                                </div>
                            </div>
                        `;
                    }).join('')}
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="${result.link}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r ${result.color} text-white font-bold rounded-xl hover:shadow-lg transition-all">
                    Pelajari ${result.title}
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <button onclick="initQuiz()" class="inline-flex items-center justify-center px-8 py-4 bg-slate-700 hover:bg-slate-600 text-white font-bold rounded-xl transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Ulangi Quiz
                </button>
                <a href="https://pmb.unika.ac.id" target="_blank" class="inline-flex items-center justify-center px-8 py-4 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl transition-all">
                    Daftar Sekarang!
                </a>
            </div>
            
            <!-- Share Section -->
            <div class="mt-8 text-center">
                <p class="text-slate-400 mb-3">Bagikan hasil quiz kamu:</p>
                <div class="flex justify-center gap-3">
                    <button onclick="shareToWhatsApp()" class="p-3 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                    </button>
                    <button onclick="shareToTwitter()" class="p-3 bg-blue-400 hover:bg-blue-500 text-white rounded-lg transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.innerHTML = html;
}

// Share Functions
function shareToWhatsApp() {
    const text = encodeURIComponent("Aku baru aja ikutan quiz SIEGA dan hasilnya cocok banget! Coba kamu juga yuk: https://siega.id/quiz");
    window.open(`https://wa.me/?text=${text}`, '_blank');
}

function shareToTwitter() {
    const text = encodeURIComponent("Baru aja coba quiz SIEGA untuk cari konsentrasi yang cocok! #SIEGA #HarvestYourFuture");
    const url = encodeURIComponent("https://siega.id/quiz");
    window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank');
}

// Auto-initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('quiz-question-container')) {
        initQuiz();
    }
});