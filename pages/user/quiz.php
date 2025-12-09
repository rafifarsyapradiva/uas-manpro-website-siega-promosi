<?php require_once '../../config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Path Quiz - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-12 bg-gradient-to-br from-purple-900 via-slate-900 to-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="text-6xl mb-6">🎯</div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">Career Path Quiz</h1>
                <p class="text-xl text-slate-300">Temukan konsentrasi yang paling cocok dengan minat dan bakatmu!</p>
            </div>
        </div>
    </section>

    <!-- Quiz Container -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <!-- Start Screen -->
                <div id="startScreen" class="bg-slate-800 rounded-2xl p-8 text-center">
                    <div class="text-7xl mb-6">🚀</div>
                    <h2 class="text-3xl font-bold mb-4">Siap Menemukan Jalanmu?</h2>
                    <p class="text-slate-300 mb-8">Quiz ini akan membantumu menemukan konsentrasi yang sesuai dengan minat dan kepribadianmu</p>
                    <div class="grid md:grid-cols-2 gap-4 mb-8 text-left">
                        <div class="bg-slate-900 rounded-lg p-4">
                            <div class="text-3xl mb-2">⏱️</div>
                            <p class="font-semibold">Durasi: 5 menit</p>
                        </div>
                        <div class="bg-slate-900 rounded-lg p-4">
                            <div class="text-3xl mb-2">❓</div>
                            <p class="font-semibold">10 Pertanyaan</p>
                        </div>
                    </div>
                    <button onclick="startQuiz()" class="px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg font-semibold text-lg hover:shadow-xl transition">
                        Mulai Quiz
                    </button>
                </div>

                <!-- Quiz Screen -->
                <div id="quizScreen" class="hidden">
                    <div class="bg-slate-800 rounded-2xl p-8">
                        <!-- Progress -->
                        <div class="mb-8">
                            <div class="flex justify-between text-sm text-slate-400 mb-2">
                                <span>Pertanyaan <span id="currentQuestion">1</span> dari 10</span>
                                <span id="progressPercent">10%</span>
                            </div>
                            <div class="w-full bg-slate-700 rounded-full h-2">
                                <div id="progressBar" class="bg-gradient-to-r from-purple-600 to-pink-600 h-2 rounded-full transition-all" style="width: 10%"></div>
                            </div>
                        </div>

                        <!-- Question -->
                        <div id="questionContainer">
                            <h3 class="text-2xl font-bold mb-6" id="questionText"></h3>
                            <div id="optionsContainer" class="space-y-4"></div>
                        </div>

                        <!-- Navigation -->
                        <div class="flex justify-between mt-8">
                            <button onclick="prevQuestion()" id="prevBtn" class="px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-lg font-semibold transition" disabled>
                                ← Sebelumnya
                            </button>
                            <button onclick="nextQuestion()" id="nextBtn" class="px-6 py-3 bg-purple-600 hover:bg-purple-700 rounded-lg font-semibold transition" disabled>
                                Selanjutnya →
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Result Screen -->
                <div id="resultScreen" class="hidden">
                    <div class="bg-slate-800 rounded-2xl p-8 text-center">
                        <div class="text-7xl mb-6">🎉</div>
                        <h2 class="text-3xl font-bold mb-4">Hasil Quiz</h2>
                        <p class="text-slate-300 mb-8">Konsentrasi yang cocok untukmu adalah:</p>
                        
                        <div id="resultCard" class="bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl p-8 mb-8">
                            <div class="text-6xl mb-4" id="resultIcon"></div>
                            <h3 class="text-4xl font-bold mb-2" id="resultTitle"></h3>
                            <p class="text-xl opacity-90 mb-4" id="resultSubtitle"></p>
                            <p class="leading-relaxed" id="resultDescription"></p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4 mb-8">
                            <div class="bg-slate-900 rounded-lg p-4 text-left">
                                <h4 class="font-bold mb-3">🎯 Kenapa Cocok?</h4>
                                <ul class="text-sm space-y-2 text-slate-300" id="whyList"></ul>
                            </div>
                            <div class="bg-slate-900 rounded-lg p-4 text-left">
                                <h4 class="font-bold mb-3">💼 Career Path</h4>
                                <ul class="text-sm space-y-2 text-slate-300" id="careerList"></ul>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a id="detailLink" href="#" class="px-8 py-4 bg-purple-600 hover:bg-purple-700 rounded-lg font-semibold transition">
                                Pelajari Lebih Lanjut
                            </a>
                            <button onclick="location.reload()" class="px-8 py-4 bg-slate-700 hover:bg-slate-600 rounded-lg font-semibold transition">
                                Coba Lagi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include '../../components/footer.php'; ?>
    <script src="../../assets/js/main.js"></script>
    <script>
    const questions = [
        {
            question: "Apa yang paling kamu sukai?",
            options: [
                { text: "Menganalisis proses bisnis dan data", points: { SI: 3 } },
                { text: "Strategi marketing dan bisnis online", points: { EC: 3 } },
                { text: "Membuat game dan konten multimedia", points: { GT: 3 } },
                { text: "Keuangan dan sistem akuntansi", points: { AK: 3 } }
            ]
        },
        {
            question: "Aktivitas apa yang membuatmu excited?",
            options: [
                { text: "Merancang sistem dan database", points: { SI: 2, AK: 1 } },
                { text: "Membuat konten dan campaign marketing", points: { EC: 3 } },
                { text: "Design grafis dan animasi 3D", points: { GT: 3 } },
                { text: "Analisis laporan keuangan", points: { AK: 3 } }
            ]
        },
        {
            question: "Skill apa yang ingin kamu kuasai?",
            options: [
                { text: "ERP dan Business Intelligence", points: { SI: 3 } },
                { text: "Digital Marketing & SEO", points: { EC: 3 } },
                { text: "Unity, Unreal Engine, VR/AR", points: { GT: 3 } },
                { text: "Accounting Software & IT Audit", points: { AK: 3 } }
            ]
        },
        {
            question: "Karir apa yang kamu impikan?",
            options: [
                { text: "Business/System Analyst", points: { SI: 3 } },
                { text: "Digital Marketing Specialist", points: { EC: 3 } },
                { text: "Game Developer", points: { GT: 3 } },
                { text: "IT Auditor / Financial Analyst", points: { AK: 3 } }
            ]
        },
        {
            question: "Project apa yang ingin kamu kerjakan?",
            options: [
                { text: "Enterprise System untuk perusahaan", points: { SI: 3 } },
                { text: "E-Commerce Platform & Marketplace", points: { EC: 3 } },
                { text: "Mobile Game atau VR Experience", points: { GT: 3 } },
                { text: "Sistem Akuntansi Terintegrasi", points: { AK: 3 } }
            ]
        },
        {
            question: "Software apa yang menarik untukmu?",
            options: [
                { text: "SAP, Oracle, Tableau", points: { SI: 3 } },
                { text: "Shopify, Google Analytics", points: { EC: 3 } },
                { text: "Unity, Blender, Photoshop", points: { GT: 3 } },
                { text: "Accurate, MYOB, QuickBooks", points: { AK: 3 } }
            ]
        },
        {
            question: "Environment kerja yang kamu suka?",
            options: [
                { text: "Perusahaan multinasional", points: { SI: 2, AK: 2 } },
                { text: "Startup atau agency kreatif", points: { EC: 3 } },
                { text: "Game studio atau freelance", points: { GT: 3 } },
                { text: "Big Four atau bank", points: { AK: 3 } }
            ]
        },
        {
            question: "Yang penting untukmu dalam karir?",
            options: [
                { text: "Work-life balance & stability", points: { SI: 2, AK: 2 } },
                { text: "Kreativitas & innovation", points: { EC: 2, GT: 2 } },
                { text: "High income potential", points: { AK: 3 } },
                { text: "Passion & satisfaction", points: { GT: 3 } }
            ]
        },
        {
            question: "Gaya belajar yang cocok untukmu?",
            options: [
                { text: "Analitis & problem solving", points: { SI: 3, AK: 2 } },
                { text: "Kreatif & experimental", points: { EC: 2, GT: 2 } },
                { text: "Visual & hands-on", points: { GT: 3 } },
                { text: "Structured & methodical", points: { AK: 3 } }
            ]
        },
        {
            question: "Starting salary yang kamu expect?",
            options: [
                { text: "8-15 juta (standar)", points: { SI: 2, EC: 2 } },
                { text: "Flexible, tergantung project", points: { GT: 2 } },
                { text: "12-25 juta (premium)", points: { AK: 3 } },
                { text: "Fokus ke passion dulu", points: { GT: 2, EC: 1 } }
            ]
        }
    ];

    const results = {
        SI: {
            icon: "🖥️",
            title: "Sistem Informasi",
            subtitle: "Business Information Systems",
            description: "Kamu cocok jadi Business/System Analyst yang menghubungkan teknologi dengan kebutuhan bisnis!",
            why: ["Analytical thinking strong", "Suka problem solving", "Interest di enterprise systems"],
            careers: ["Business Analyst", "System Analyst", "IT Consultant"],
            link: "konsentrasi/sistem-informasi.php"
        },
        EC: {
            icon: "🛒",
            title: "E-Commerce",
            subtitle: "Electronic Commerce",
            description: "Kamu perfect untuk digital business dan marketing! Creativity meets technology.",
            why: ["Creative mindset", "Passion di digital marketing", "Entrepreneurial spirit"],
            careers: ["Digital Marketing Specialist", "E-Commerce Manager", "Social Media Strategist"],
            link: "konsentrasi/e-commerce.php"
        },
        GT: {
            icon: "🎮",
            title: "Game Technology",
            subtitle: "Game Development & Technology",
            description: "Level up! Kamu punya passion di game development dan creative technology!",
            why: ["Creative & artistic", "Love gaming & multimedia", "Visual learner"],
            careers: ["Game Developer", "3D Artist", "VR/AR Developer"],
            link: "konsentrasi/game-technology.php"
        },
        AK: {
            icon: "💼",
            title: "Akuntansi-SI",
            subtitle: "Double Degree Program",
            description: "Double power! Kamu cocok untuk karir premium dengan dual expertise!",
            why: ["Analytical & detail-oriented", "Interest di finance & IT", "High achiever mentality"],
            careers: ["IT Auditor", "Financial Analyst", "ERP Consultant"],
            link: "konsentrasi/akuntansi-si.php"
        }
    };

    let currentQ = 0;
    let scores = { SI: 0, EC: 0, GT: 0, AK: 0 };
    let answers = [];

    function startQuiz() {
        document.getElementById('startScreen').classList.add('hidden');
        document.getElementById('quizScreen').classList.remove('hidden');
        showQuestion();
    }

    function showQuestion() {
        const q = questions[currentQ];
        document.getElementById('questionText').textContent = q.question;
        document.getElementById('currentQuestion').textContent = currentQ + 1;
        document.getElementById('progressPercent').textContent = ((currentQ + 1) * 10) + '%';
        document.getElementById('progressBar').style.width = ((currentQ + 1) * 10) + '%';
        
        const container = document.getElementById('optionsContainer');
        container.innerHTML = '';
        
        q.options.forEach((opt, i) => {
            const btn = document.createElement('button');
            btn.className = 'w-full text-left p-4 bg-slate-900 hover:bg-purple-900/30 rounded-lg transition border-2 border-transparent';
            btn.innerHTML = `<span class="font-semibold">${String.fromCharCode(65 + i)}.</span> ${opt.text}`;
            
            if (answers[currentQ] === i) {
                btn.classList.add('border-purple-600', 'bg-purple-900/30');
            }
            
            btn.onclick = () => selectOption(i);
            container.appendChild(btn);
        });
        
        document.getElementById('prevBtn').disabled = currentQ === 0;
        document.getElementById('nextBtn').disabled = answers[currentQ] === undefined;
    }

    function selectOption(index) {
        answers[currentQ] = index;
        document.getElementById('nextBtn').disabled = false;
        showQuestion();
    }

    function prevQuestion() {
        if (currentQ > 0) {
            currentQ--;
            showQuestion();
        }
    }

    function nextQuestion() {
        const q = questions[currentQ];
        const selected = answers[currentQ];
        const points = q.options[selected].points;
        
        for (let key in points) {
            scores[key] += points[key];
        }
        
        currentQ++;
        
        if (currentQ < questions.length) {
            showQuestion();
        } else {
            showResult();
        }
    }

    function showResult() {
        const winner = Object.keys(scores).reduce((a, b) => scores[a] > scores[b] ? a : b);
        const result = results[winner];
        
        document.getElementById('quizScreen').classList.add('hidden');
        document.getElementById('resultScreen').classList.remove('hidden');
        
        document.getElementById('resultIcon').textContent = result.icon;
        document.getElementById('resultTitle').textContent = result.title;
        document.getElementById('resultSubtitle').textContent = result.subtitle;
        document.getElementById('resultDescription').textContent = result.description;
        document.getElementById('detailLink').href = result.link;
        
        document.getElementById('whyList').innerHTML = result.why.map(w => `<li>• ${w}</li>`).join('');
        document.getElementById('careerList').innerHTML = result.careers.map(c => `<li>• ${c}</li>`).join('');
    }
    </script>
</body>
</html>