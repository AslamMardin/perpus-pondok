# Library PPM Al-Ikhlash - Laravel Project

Aplikasi manajemen perpustakaan berbasis Laravel untuk **PPM Al-Ikhlash**.

---

## Deskripsi

Project ini dibangun dengan Laravel Framework untuk mengelola data perpustakaan, termasuk pencatatan buku, peminjaman, dan laporan terkait.

---

## Persyaratan Sistem

- PHP >= 8.x
- Composer
- MySQL
- Node.js & npm/yarn (untuk build asset dengan Vite)

---

## Konfigurasi Lingkungan (.env)

Contoh konfigurasi utama di file `.env`:

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
APP_TIMEZONE=Asia/Jakarta

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library-ppm-al-ikhlash
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120

CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Laravel"

LOG_CHANNEL=stack
LOG_LEVEL=debug
