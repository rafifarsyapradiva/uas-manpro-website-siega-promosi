<?php require_once '../../config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-12 bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="text-6xl mb-6">📞</div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">Hubungi Kami</h1>
                <p class="text-xl text-slate-300">Punya pertanyaan? Kami siap membantu Anda</p>
            </div>
        </div>
    </section>

    <!-- Contact Info & Form -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Contact Information -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-3xl font-bold mb-6">Informasi Kontak</h2>
                        <p class="text-slate-400 mb-8">
                            Jangan ragu untuk menghubungi kami. Tim kami siap menjawab pertanyaan Anda tentang 
                            program studi, pendaftaran, atau hal lainnya.
                        </p>
                    </div>

                    <!-- Contact Cards -->
                    <div class="space-y-4">
                        <!-- Alamat -->
                        <div class="bg-slate-800 rounded-xl p-6 hover:bg-slate-750 transition">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center text-2xl flex-shrink-0">
                                    📍
                                </div>
                                <div>
                                    <h3 class="font-bold mb-2">Alamat</h3>
                                    <p class="text-slate-400">
                                        Program Studi Sistem Informasi<br>
                                        Fakultas Ilmu Komputer<br>
                                        Universitas Katolik Soegijapranata<br>
                                        Jl. Pawiyatan Luhur IV/1, Bendan Duwur<br>
                                        Semarang 50234, Jawa Tengah
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="bg-slate-800 rounded-xl p-6 hover:bg-slate-750 transition">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-cyan-600 rounded-lg flex items-center justify-center text-2xl flex-shrink-0">
                                    📧
                                </div>
                                <div>
                                    <h3 class="font-bold mb-2">Email</h3>
                                    <a href="mailto:si@unika.ac.id" class="text-cyan-400 hover:text-cyan-300">
                                        si@unika.ac.id
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <div class="bg-slate-800 rounded-xl p-6 hover:bg-slate-750 transition">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center text-2xl flex-shrink-0">
                                    💬
                                </div>
                                <div>
                                    <h3 class="font-bold mb-2">WhatsApp PMB</h3>
                                    <a href="https://wa.me/6281903385595" class="text-green-400 hover:text-green-300">
                                        0819-0338-5595
                                    </a>
                                    <p class="text-slate-500 text-sm mt-1">
                                        Chat langsung dengan tim PMB kami
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Telepon -->
                        <div class="bg-slate-800 rounded-xl p-6 hover:bg-slate-750 transition">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-pink-600 rounded-lg flex items-center justify-center text-2xl flex-shrink-0">
                                    ☎️
                                </div>
                                <div>
                                    <h3 class="font-bold mb-2">Telepon</h3>
                                    <a href="tel:+622485050003" class="text-pink-400 hover:text-pink-300">
                                        (024) 8505-003
                                    </a>
                                    <p class="text-slate-500 text-sm mt-1">
                                        Senin - Jumat: 08:00 - 16:00 WIB
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div>
                        <h3 class="font-bold mb-4">Follow Us</h3>
                        <div class="flex gap-4">
                            <a href="https://www.instagram.com/siega_unika/" target="_blank" 
                               class="w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-600 rounded-lg flex items-center justify-center hover:scale-110 transition">
                                📷
                            </a>
                            <a href="https://www.facebook.com/siegaunika" target="_blank"
                               class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center hover:scale-110 transition">
                                📘
                            </a>
                            <a href="https://siega.id" target="_blank"
                               class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center hover:scale-110 transition">
                                🌐
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-slate-800 rounded-2xl p-8">
                    <h2 class="text-2xl font-bold mb-6">Kirim Pesan</h2>
                    <form id="contactForm" class="space-y-6">
                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-semibold mb-2">Nama Lengkap *</label>
                            <input type="text" name="nama" required
                                   class="w-full px-4 py-3 bg-slate-700 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"
                                   placeholder="Masukkan nama lengkap">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold mb-2">Email *</label>
                            <input type="email" name="email" required
                                   class="w-full px-4 py-3 bg-slate-700 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"
                                   placeholder="nama@email.com">
                        </div>

                        <!-- Telepon -->
                        <div>
                            <label class="block text-sm font-semibold mb-2">Nomor Telepon *</label>
                            <input type="tel" name="telepon" required
                                   class="w-full px-4 py-3 bg-slate-700 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"
                                   placeholder="08xx xxxx xxxx">
                        </div>

                        <!-- Subjek -->
                        <div>
                            <label class="block text-sm font-semibold mb-2">Subjek *</label>
                            <select name="subjek" required
                                    class="w-full px-4 py-3 bg-slate-700 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                                <option value="">Pilih Subjek</option>
                                <option value="Informasi Pendaftaran">Informasi Pendaftaran</option>
                                <option value="Informasi Konsentrasi">Informasi Konsentrasi</option>
                                <option value="Biaya Kuliah">Biaya Kuliah</option>
                                <option value="Beasiswa">Beasiswa</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <!-- Pesan -->
                        <div>
                            <label class="block text-sm font-semibold mb-2">Pesan *</label>
                            <textarea name="pesan" required rows="5"
                                      class="w-full px-4 py-3 bg-slate-700 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none resize-none"
                                      placeholder="Tulis pesan Anda di sini..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                class="w-full px-6 py-4 bg-gradient-to-r from-indigo-600 to-cyan-600 rounded-lg font-semibold text-lg hover:shadow-xl hover:scale-105 transition">
                            📤 Kirim Pesan
                        </button>

                        <!-- Info -->
                        <p class="text-sm text-slate-400 text-center">
                            * Wajib diisi. Kami akan merespons dalam 1x24 jam.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-20 bg-slate-800">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Lokasi Kampus</h2>
            <div class="max-w-6xl mx-auto rounded-2xl overflow-hidden shadow-2xl">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d31679.021340181826!2d110.40322200000001!3d-7.023663!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708bab00d3e8e7%3A0xbcd9046f4a49cf15!2sSIEGA%20Unika%20Soegijapranata!5e0!3m2!1sen!2sid!4v1765091034947!5m2!1sen!2sid"
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    class="w-full">
                </iframe>
            </div>
            
            <!-- Directions -->
            <div class="mt-8 text-center">
                <a href="https://goo.gl/maps/your-location-link" target="_blank"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg font-semibold transition">
                    🗺️ Lihat Petunjuk Arah
                </a>
            </div>
        </div>
    </section>

    <!-- Quick Links -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Link Cepat</h2>
            <div class="grid md:grid-cols-4 gap-6 max-w-5xl mx-auto">
                <a href="about.php" class="bg-slate-800 rounded-xl p-6 text-center hover:bg-slate-750 transition">
                    <div class="text-4xl mb-3">ℹ️</div>
                    <h3 class="font-bold">Tentang SIEGA</h3>
                </a>
                <a href="konsentrasi/index.php" class="bg-slate-800 rounded-xl p-6 text-center hover:bg-slate-750 transition">
                    <div class="text-4xl mb-3">🎯</div>
                    <h3 class="font-bold">Konsentrasi</h3>
                </a>
                <a href="biaya-kuliah.php" class="bg-slate-800 rounded-xl p-6 text-center hover:bg-slate-750 transition">
                    <div class="text-4xl mb-3">💰</div>
                    <h3 class="font-bold">Biaya Kuliah</h3>
                </a>
                <a href="https://pmb.unika.ac.id" target="_blank" class="bg-slate-800 rounded-xl p-6 text-center hover:bg-slate-750 transition">
                    <div class="text-4xl mb-3">📝</div>
                    <h3 class="font-bold">Pendaftaran</h3>
                </a>
            </div>
        </div>
    </section>

    <?php include '../../components/footer.php'; ?>
    
    <script src="../../assets/js/main.js"></script>
    <script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Simple form validation
        const formData = new FormData(this);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });
        
        // In real implementation, send to backend
        console.log('Form data:', data);
        
        // Show success message
        alert('Terima kasih! Pesan Anda telah dikirim. Kami akan menghubungi Anda segera.');
        this.reset();
    });
    </script>
</body>
</html>