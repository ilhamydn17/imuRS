## Menjalankan Project
### Clone Project ke Local

```
git clone https://github.com/ilhamydn17/imuRS.git
```

### Update Composer
Update composer dengan memasukkkan perintah di bawah ini pada command line folder project

```
composer update 
```
atau
```
composer install
```

### Copy file .env.example
```
cp .env.example .env
```

### Generate Application Key
```
php artisan key:generate
```

### Menjalankan Migrasi dan Seeder
```
php artisan migrate --seed
```
### Jalankan aplikasi di host local
```
php artisan serve
```
