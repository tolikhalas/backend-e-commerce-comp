# Raketka

Testing app

## Prerequires
1.`php`. Visit [php site](https://www.php.net/downloads) to download it.
2.`Composer`. It is used as package manager. Visit [composer site](https://getcomposer.org/download/) to download it.

## App Installation and run
1. Copy app with `git`: `git clone https://github.com/tolikhalas/backend-e-commerce-comp`.
2. Setup `.env` variables from `.env.example`. Especially existing database's configs (database's name, user & password).
3. Go to `web-http` directory.
4. Run `php artisan migrate` to apply migrations to database.
5. Run `php artisan serve` to start an app.
