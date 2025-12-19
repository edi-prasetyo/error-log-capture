# Error Log Capture

> Paket Laravel yang ringan untuk menangkap dan menyimpan log kesalahan di database secara otomatis.

Package ini membantu developer **melihat error langsung dari database** tanpa harus membuka file log bawaan Laravel, dan ini sangat di perlukan saat aplikasi sudah di live production. Developer bisa membuat UI di dashboard untuk melihat Error Apa saja yang terjadi selama aplikasi sudah live dan bisa langsung eksekusi fixing problem tanpa harus mencari dimana letak errornya, karena package ini sudah menyimpan pesan error, lokasi file, akses url yang error dll. 

---

## Fitur Utama

* ✅ Auto-capture exception (Laravel 10, 11, 12)
* ✅ Menyimpan error ke database
* ✅ Count Error jika terjadi pada Error yang Sama
* ✅ Zero-config (langsung jalan setelah install)
* ✅ Ringan & production-ready
* ✅ Custom Error 500 dengan informasi id dan code

---

## Instalasi

```bash
composer require edi-prasetyo/error-log-capture
```

Jalankan migration:

```bash
php artisan migrate
```

> Setelah itu package **langsung aktif otomatis**.

---

## Konfigurasi

Publish config jika ingin menyesuaikan behavior:

```bash
php artisan vendor:publish --tag=error-log-capture-config
```

File config:

```php
config/error-log-capture.php
```

### Contoh konfigurasi

```php
return [
    'enabled' => true,

    'ignore' => [
        \Illuminate\Validation\ValidationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
    ],

    'trace_limit' => 10,
];
```

---

## Auto Capture (Default)

Tanpa perlu konfigurasi tambahan:

```text
Exception terjadi → otomatis disimpan ke database
```

---

## Manual Capture (Opsional)

Jika ingin mencatat error secara manual:

```php
use EdiPrasetyo\ErrorLogCapture\Facades\ErrorLog;

try {
    // kode berpotensi error
} catch (\Throwable $e) {
    ErrorLog::capture($e);
}
```

---

## Cara Mengirim data dari Controller

### Semua Error

```php

use EdiPrasetyo\ErrorLogCapture\Models\ErrorLogModel;

$errors = ErrorLogModel::all();
return $errors

```
---

## Menampilkan Custom Informasi Error 500

Untuk menampilkan halaman **custom error 500** beserta informasi Error ID,

```html
php artisan vendor:publish --tag=error-log-capture-views
```

---

## License

MIT License © Edi Prasetyo

---
