
# 📦 Web Stok Barang

## 🔧 Persyaratan Sistem

* PHP >= 8.2
* Composer
* MySQL (disarankan versi 8+)
* Node.js & NPM
* Laravel 11

## 🚀 Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/username/nama-repo.git
cd nama-repo

# 2. Install dependensi Laravel
composer install

# 3. Salin file konfigurasi environment
cp .env.example .env

# 4. Atur konfigurasi database di file .env
````

Contoh konfigurasi `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stok_barang
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# 5. Generate application key
php artisan key:generate

# 6. Jalankan migrasi dan seeding (admin & staff default)
php artisan migrate --seed

# 7. Install & build frontend assets
npm install && npm run build

# 8. Jalankan server lokal
php artisan serve
```

Aplikasi dapat diakses melalui `http://localhost:8000`

## 🔐 Login Awal

### Admin

* **Username:** `admin`
* **Password:** `admin00000`

### Staff

* **Username:** `staff`
* **Password:** `staff00000`


