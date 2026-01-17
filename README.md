# 🖨️ Printer Kasir App (Electron + Laravel + Python)

Aplikasi **Printer Kasir Terintegrasi** berbasis **Electron Desktop** yang memungkinkan **user mengupload file dari HP atau device lain** melalui URL publik (Ngrok), lalu **mencetak langsung ke printer kasir** yang terhubung ke komputer server.

Proyek ini dirancang untuk mendukung **digitalisasi layanan fotocopy / percetakan UMKM**, termasuk konsep **scan QR → upload → print otomatis**.

---

## 🚀 Fitur Utama

* 📱 Upload file dari HP / device lain
* 🌐 URL publik otomatis menggunakan **Ngrok**
* 📦 Generate **QR Code** untuk akses cepat
* 🖥️ Aplikasi Desktop berbasis **Electron**
* ⚙️ Backend **Laravel API**
* 🐍 Service cetak menggunakan **Python**
* 🖨️ Print otomatis ke printer kasir
* 📊 Sistem **Print Job Queue**
* 🔐 Aman tanpa expose port lokal

---

## 🧩 Arsitektur Sistem

```
User (HP / Browser)
        ↓
   Ngrok Public URL
        ↓
     Laravel API
        ↓
   Database (PrintJob)
        ↓
   Python Print Service
        ↓
     Printer Kasir
```

---

## 🛠️ Teknologi yang Digunakan

| Layer        | Teknologi |
| ------------ | --------- |
| Desktop App  | Electron  |
| Backend API  | Laravel   |
| Print Engine | Python 3  |
| Database     | MySQL     |
| Tunneling    | Ngrok     |
| QR Code      | qrcode.js |
| HTTP Client  | Axios     |

---

## 📂 Struktur Project

```
PrinterKasirApp/
│
├── app/
│   ├── main.js          # Electron Main Process
│   ├── preload.js       # IPC Bridge
│   └── index.html       # Dashboard UI
│
├── ngrok/
│   └── ngrok.exe
│
├── dashboard.js         # QR & URL handler
├── package.json
└── README.md
```

Laravel & Python service berjalan **terpisah** di folder masing-masing.

---

## ⚙️ Cara Menjalankan (Development)

### 1️⃣ Install Dependency

```bash
npm install
```

Pastikan:

* Node.js ≥ 18
* PHP ≥ 8.2
* Python ≥ 3.10
* Composer
* Ngrok

---

### 2️⃣ Jalankan Aplikasi

```bash
npm start
```

Aplikasi akan otomatis:

* Menjalankan Laragon
* Menjalankan Laravel server
* Menjalankan Python print service
* Menjalankan Ngrok
* Menampilkan URL & QR Code

---

## 📦 Build Menjadi `.exe`

```bash
npm run build
```

File hasil build akan berada di folder:

```
dist/
```

⚠️ **Catatan penting**:

* Pastikan `ngrok.exe` disertakan di konfigurasi build
* Gunakan path absolut (`process.resourcesPath`) saat production

---

## 🖨️ Alur Cetak

1. User scan QR Code
2. Upload file
3. Laravel menyimpan file & data ke database
4. Python membaca job dari DB / API
5. Printer mencetak file sesuai konfigurasi

---

## ❗ Catatan Penting

* Gunakan `multipart/form-data` untuk upload file
* Pastikan `fillable` model Laravel sudah benar
* Gunakan **absolute file path** untuk Python
* Pastikan printer sudah diset sebagai **default printer**
* Jangan gunakan `localhost` untuk akses publik

---

## 🧪 Debugging

Cek log berikut jika terjadi masalah:

* Terminal Electron
* Log Laravel
* Output Python
* Ngrok `/api/tunnels`

---

## 📌 Use Case

* Percetakan & Fotocopy
* Print kasir
* Warnet / Rental PC
* UMKM Digital Printing
* Kampus / Sekolah

---

## 📄 Lisensi

MIT License

---

## ✨ Author

**Potokopi Kita**
Digital Printing & Smart Print System
🇮🇩 Indonesia

---
