## Installation 

### Back-end
```bash
composer install
cp .env.example .env
php artisan key:generate
```
Create DB & configurate .env

```bash
php artisan migrate
php artisan jwt:secret
```

### Front-end
```bash
yarn
npm run prod
```