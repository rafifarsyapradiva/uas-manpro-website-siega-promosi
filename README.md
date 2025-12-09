# 🚀 SIEGA Modern Promotion Website

**"Harvest Your Future Through Technology"**

Website promosi modern untuk program studi SIEGA (Sistem Informasi, E-Commerce, Game Technology, Akuntansi-SI) yang dibangun dengan teknologi web modern dan desain yang menarik.

---

## 📋 Informasi Project

- **Nama Project:** SIEGA Modern Promotion Website
- **Target Audience:** Gen Z, Calon Mahasiswa Baru
- **Tech Stack:** PHP Native, Tailwind CSS (CDN), XAMPP
- **Database:** JSON Files (No SQL Database)
- **Repository:** [https://github.com/rafifarsyapradiva/uas-manpro-website-siega-promosi](https://github.com/rafifarsyapradiva/uas-manpro-website-siega-promosi)

---
---

##  Cara membuka Project

- **Localhost:** http://localhost/siega-modern/index.php

---
## 🎨 Design System

### Konsep Desain
**Dark Mode First, Glassmorphism, Vibrant Accents**

### Skema Warna
```css
:root {
  /* Primary Backgrounds */
  --bg-dark: #0f172a;        /* slate-900 */
  --bg-card: #1e293b;        /* slate-800 */
  
  /* Brand Colors */
  --primary: #6366f1;        /* indigo-500 */
  --secondary: #3b82f6;      /* blue-500 */
  --accent-cyan: #06b6d4;    /* cyan-500 */
  
  /* Highlights */
  --neon-pink: #ec4899;      /* pink-500 */
  --neon-lime: #84cc16;      /* lime-500 */
  
  /* Text */
  --text-main: #f1f5f9;      /* slate-100 */
  --text-muted: #94a3b8;     /* slate-400 */
}
```

---

## ✨ Fitur Utama

1. **Student Journey Timeline** - Visualisasi perjalanan semester 1-8
2. **Career Path Visualizer** - Flowchart interaktif untuk setiap konsentrasi
3. **Live Dashboard** - Counter real-time statistik lulusan dan project
4. **Alumni Success Stories** - Card achievement dengan foto & kutipan
5. **Virtual Campus Tour** - Navigasi 360 view (Opsional)
6. **SIEGA Quiz** - "Konsentrasi Mana yang Cocok Untukmu?"
7. **Project Showcase** - Grid gallery karya mahasiswa

---

## 🚨 Halaman Wajib (Critical Requirements)

### 1. 📝 Skripsi (`skripsi.php` & `skripsi.json`)
**User Features:**
- Search judul skripsi
- Filter berdasarkan konsentrasi
- Modal detail abstract

**Admin Features:**
- Tambah judul skripsi baru
- Edit data skripsi
- Hapus data skripsi

### 2. 📚 Journal (`journal.php` & `journal.json`)
**User Features:**
- List publikasi jurnal
- Link eksternal (DOI)
- Filter berdasarkan tahun

**Admin Features:**
- Input publikasi baru
- Edit data publikasi
- Hapus publikasi

### 3. 💰 Biaya Kuliah (`biaya_kuliah.php` & `biaya_kuliah.json`)
**User Features:**
- Tabel transparan (SPP, DPP, SKS)
- Informasi beasiswa

**Admin Features:**
- Update nominal biaya
- Edit breakdown biaya
- Tambah/hapus item biaya

---

## 📂 Struktur Folder Project

```
siega-modern/
│
├── index.php                    # Landing page (Main Entry)
├── config.php                   # Base URL & Helper Functions
│
├── assets/
│   ├── css/
│   │   └── style.css           # Custom CSS (Glassmorphism)
│   ├── js/
│   │   ├── main.js             # Navbar & General logic
│   │   ├── counter.js          # Live Dashboard logic
│   │   └── quiz.js             # Logic Quiz Jurusan
│   └── images/                  # Logo, hero, icons, gallery
│
├── data/                        # JSON DATABASE
│   ├── konsentrasi.json        # Data 4 jurusan [WAJIB]
│   ├── skripsi.json            # Min 8 data [WAJIB]
│   ├── journal.json            # Min 6 data [WAJIB]
│   ├── biaya_kuliah.json       # Detail biaya [WAJIB]
│   ├── admin.json              # Credentials
│   ├── alumni.json             # Success stories
│   ├── prestasi.json           # Awards
│   ├── dosen.json              # Lecturer profiles
│   ├── fasilitas.json          # Facilities
│   ├── kegiatan.json           # Activities
│   ├── artikel.json            # Articles
│   └── berita.json             # News
│
├── pages/
│   ├── user/                   # User-facing pages
│   │   ├── home.php
│   │   ├── about.php
│   │   ├── konsentrasi/
│   │   │   ├── index.php
│   │   │   ├── sistem-informasi.php
│   │   │   ├── e-commerce.php
│   │   │   ├── game-technology.php
│   │   │   └── akuntansi-si.php
│   │   ├── skripsi.php         # [WAJIB]
│   │   ├── journal.php         # [WAJIB]
│   │   ├── biaya-kuliah.php    # [WAJIB]
│   │   ├── alumni.php
│   │   ├── prestasi.php
│   │   ├── fasilitas.php
│   │   ├── dosen.php
│   │   ├── kegiatan.php
│   │   ├── quiz.php
│   │   └── kontak.php
│   │
│   └── admin/                  # Admin panel
│       ├── login.php
│       ├── dashboard.php
│       └── kelola/
│           ├── konsentrasi.php
│           ├── skripsi.php     # [WAJIB CRUD]
│           ├── journal.php     # [WAJIB CRUD]
│           ├── biaya-kuliah.php # [WAJIB CRUD]
│           ├── alumni.php
│           ├── kegiatan.php
│           ├── artikel.php
│           └── berita.php
│
├── components/                  # Reusable UI Components
│   ├── navbar.php
│   ├── footer.php
│   ├── hero.php
│   ├── stats-counter.php
│   ├── career-path.php
│   ├── sidebar-admin.php
│   └── modals.php
│
└── README.md
```

---

## 🛠️ Instalasi & Setup

### Prerequisites
- XAMPP (PHP 7.4+ & Apache)
- Git
- Text Editor (VS Code recommended)
- Browser modern (Chrome/Firefox)

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone https://github.com/rafifarsyapradiva/uas-manpro-website-siega-promosi.git
cd uas-manpro-website-siega-promosi
```

2. **Setup XAMPP**
- Pindahkan folder project ke `C:/xampp/htdocs/siega-modern/`
- Start Apache di XAMPP Control Panel

3. **Konfigurasi Permissions**
- Pastikan folder `data/` memiliki write permission
```bash
chmod -R 755 data/
```

4. **Akses Website**
- User: `http://localhost/siega-modern/`
- Admin: `http://localhost/siega-modern/pages/admin/login.php`

### Default Admin Credentials
```
Username: admin
Password: admin123
```
*(Kredensial dapat diubah di `data/admin.json`)*

---

## 👥 Tim Pengembang

### Branch Structure
- `main` - Production (Merge Final)
- `rafif-dev` - Frontend Development
- `maxi-dev` - Backend Development
- `kevin-dev` - Data & QA

### Anggota Tim

#### 👨‍💻 Rafif Arsya Pradiva (Frontend Lead)
**Branch:** `rafif-dev`

**Tanggung Jawab:**
- Implementasi landing page dengan animasi
- Desain UI/UX responsive
- Interactive career path visualizer
- Styling halaman user (Skripsi, Journal, Biaya Kuliah)
- Integrasi JSON data ke tampilan

**Deliverables:**
- `index.php`, `config.php`
- Semua file di `pages/user/`
- Semua file di `components/`
- CSS & JavaScript files

---

#### 👨‍💻 Maximilianus Tri Ananda Putra (Backend Lead)
**Branch:** `maxi-dev`

**Tanggung Jawab:**
- Sistem login & autentikasi
- Dashboard admin
- CRUD operations untuk semua modul
- Security & validation
- Session management

**Deliverables:**
- `pages/admin/login.php`
- `pages/admin/dashboard.php`
- Semua file di `pages/admin/kelola/`
- Backend logic & validation

---

#### 👨‍💻 Kevin Giovanno (Data & QA Lead)
**Branch:** `kevin-dev`

**Tanggung Jawab:**
- Struktur & validasi JSON
- Data research & collection
- Content writing
- Integration testing
- Dokumentasi & video production

**Deliverables:**
- Semua file di `data/`
- Testing reports
- README.md
- Video presentasi (15 menit)

---

## 🔄 Git Workflow

### Daily Sync Process

**Pagi (09:00 WIB)**
```bash
git checkout <your-branch>
git pull origin <other-branches>  # Jika perlu update
```

**Siang (12:00 WIB)**
```bash
git add .
git commit -m "feat: describe your progress"
git push origin <your-branch>
```

**Sore (17:00 WIB)**
```bash
git add .
git commit -m "feat: complete today's work"
git push origin <your-branch>
```

**Malam (20:00 WIB)**
- Review pull requests
- Testing & merge
- Planning untuk hari berikutnya

### Commit Message Convention
```
feat: menambah fitur baru
fix: memperbaiki bug
style: perubahan styling CSS
refactor: refactor kode
docs: update dokumentasi
test: testing
chore: maintenance
```

### Integration Points

**Kevin → Rafif (Data ke Frontend)**
```bash
# Kevin push data
git push origin kevin-dev

# Rafif pull data
git checkout rafif-dev
git pull origin kevin-dev
git merge kevin-dev
```

**Maxi → Rafif (Backend ke Frontend)**
```bash
# Maxi push backend
git push origin maxi-dev

# Rafif pull backend
git checkout rafif-dev
git pull origin maxi-dev
git merge maxi-dev
```

---

## 📹 Video Presentasi (15 Menit)

### Part 1: Frontend Experience (0:00 - 5:00) - Rafif
- Opening & Landing Page Tour
- Konsentrasi Pages
- Demo 3 Halaman Wajib (Skripsi, Journal, Biaya)
- Responsive Design Demo

### Part 2: Backend & Admin System (5:00 - 10:00) - Maxi
- Admin Login
- Dashboard Overview
- CRUD Demo (Konsentrasi, Skripsi, Journal, Biaya)
- Security Features

### Part 3: Integration & Data (10:00 - 15:00) - Kevin
- JSON Structure Overview
- Integration Testing (Admin ↔ User)
- Git Workflow Demo
- Documentation & Closing

---

## 🧪 Testing

### Manual Testing Checklist

**Frontend Testing:**
- [ ] Responsive design (Desktop, Tablet, Mobile)
- [ ] Cross-browser compatibility (Chrome, Firefox, Edge)
- [ ] Navigation flow
- [ ] Animations & transitions
- [ ] Form validation (frontend)

**Backend Testing:**
- [ ] Login authentication
- [ ] Session management
- [ ] CRUD operations (Create, Read, Update, Delete)
- [ ] Data persistence ke JSON
- [ ] Error handling
- [ ] Security (input sanitization)

**Integration Testing:**
- [ ] Admin update → User page reflection
- [ ] Real-time data synchronization
- [ ] JSON file integrity
- [ ] Permission & authorization

---

## 🚀 Deployment

### Production Checklist
- [ ] Update `config.php` dengan production URL
- [ ] Change admin credentials
- [ ] Disable error display (`error_reporting(0)`)
- [ ] Set file permissions (755 untuk folders, 644 untuk files)
- [ ] Backup data JSON
- [ ] Test semua fitur di production environment

---

## 📝 Data Structure

### Minimal Data Requirements

**skripsi.json** (Min 8 entries)
```json
{
  "id": 1,
  "judul": "Sistem Informasi Manajemen...",
  "penulis": "Nama Mahasiswa",
  "konsentrasi": "Sistem Informasi",
  "tahun": 2024,
  "abstrak": "Deskripsi singkat...",
  "pembimbing": "Nama Dosen"
}
```

**journal.json** (Min 6 entries)
```json
{
  "id": 1,
  "judul": "Judul Publikasi",
  "penulis": ["Nama 1", "Nama 2"],
  "jurnal": "Nama Jurnal",
  "tahun": 2024,
  "doi": "10.xxxx/xxxxx",
  "link": "https://..."
}
```

**biaya_kuliah.json**
```json
{
  "pendaftaran": {
    "biaya": 500000,
    "keterangan": "..."
  },
  "spp_semester": {
    "reguler": 4500000,
    "karyawan": 5000000
  },
  "biaya_sks": 150000,
  "beasiswa": [...]
}
```

---

## 📚 Resources

### External Libraries (CDN)
- Tailwind CSS: https://cdn.tailwindcss.com
- Font Awesome (Optional): https://cdnjs.cloudflare.com/ajax/libs/font-awesome/

### Documentation
- PHP: https://www.php.net/docs.php
- Tailwind CSS: https://tailwindcss.com/docs
- JSON: https://www.json.org/

---

## 🐛 Known Issues & Troubleshooting

### Issue: JSON file tidak ter-update
**Solution:**
```bash
# Check file permissions
chmod 755 data/
chmod 644 data/*.json
```

### Issue: Session tidak berfungsi
**Solution:**
```php
// Pastikan session_start() ada di config.php
session_start();
```

### Issue: Tailwind CSS tidak load
**Solution:**
```html
<!-- Pastikan CDN link ada di header -->
<script src="https://cdn.tailwindcss.com"></script>
```

---

## 📞 Support & Contact

Untuk pertanyaan atau bantuan:
- **Email:** contact@siega.id
- **GitHub Issues:** [Create Issue](https://github.com/rafifarsyapradiva/uas-manpro-website-siega-promosi/issues)

---

## 📄 License

Project ini dibuat untuk keperluan akademik - UAS Manajemen Project

---

## 🙏 Acknowledgments

- Dosen Pengampu: [Nama Dosen]
- SIEGA Program Studi
- Semua kontributor dan tim pengembang

---

**© 2024 SIEGA Modern Promotion Website. All rights reserved.**

*"Harvest Your Future Through Technology"*
