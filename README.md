## Menjalankan Project
### Clone Project ke Local

```
git clone 
```

### Update Composer
Update composer dengan memasukkkan perintah di bawah ini pada command line folder project

```
composer update https://github.com/ilhamydn17/imuRS.git
```

### Copy file .env.example
```
cp .env.example .env
```

### Generate Application Key
```
php artisan key:generate
```

### Menjalankan Migrasi
```
php artisan migrate
```
### Jalankan aplikasi di host local
```
php artisan serve
```
