# Admin Panel Laravue

Admin Panel Laravue adalah starter kit admin panel yang dibangun dengan Laravel 12, Vue 3, Shadcn UI Vue, dan Tailwind CSS.

## Fitur

- Autentikasi pengguna (login, registrasi, reset password)
- Dashboard admin dengan statistik
- Tabel data dengan paginasi
- Komponen UI yang indah dan responsif dengan Shadcn UI
- Mode gelap/terang
- Tata letak yang dapat dikonfigurasi

## Persyaratan

- PHP 8.2+
- Composer
- Node.js 16+
- NPM atau Yarn

## Instalasi

1. Clone repositori ini:

```bash
git clone https://github.com/username/Admin-Panel-Laravue.git
cd Admin-Panel-Laravue
```

2. Instal dependensi PHP:

```bash
composer install
```

3. Salin file .env.example ke .env dan konfigurasikan database:

```bash
cp .env.example .env
```

4. Generate kunci aplikasi:

```bash
php artisan key:generate
```

5. Jalankan migrasi database:

```bash
php artisan migrate
```

6. Instal dependensi JavaScript:

```bash
npm install
```

7. Kompilasi aset:

```bash
npm run dev
```

8. Jalankan server pengembangan:

```bash
php artisan serve
```

## Penggunaan

Setelah instalasi, Anda dapat mengakses aplikasi di http://localhost:8000.

- Login dengan kredensial default:
  - Email: admin@example.com
  - Password: password

## Struktur Komponen

Proyek ini menggunakan komponen Shadcn UI yang telah dimodifikasi untuk Vue 3:

- `/resources/js/Components/ui/` - Komponen UI dasar
- `/resources/js/Pages/` - Halaman aplikasi
- `/resources/js/Layouts/` - Tata letak aplikasi

## Kustomisasi

### Tema

Anda dapat menyesuaikan tema dengan mengedit file `/resources/css/app.css` dan `/tailwind.config.js`.

### Tata Letak

Tata letak dapat dikonfigurasi di `/resources/js/Layouts/`.

## Lisensi

[MIT](LICENSE)
