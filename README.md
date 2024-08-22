# Aircraft Management System (AMS)

## Installing

1. Copy `.env.example` to `.env` and set database and URL credentials
2. Run next commands:
    ```bash
    composer install
    php artisan key:generate
    php artisan migrate --seed
    ```
3. Install JS dependencies by running next command:
    ```
   npm install
   ```
4. Build frontend:
    ```
   npm run build
   ```
5. Setup your webserver or run the website via `php artisan server` (not recommended as something may be broken)

## Next steps

After running install commands you can visit website by configured URL.
You can use default admin credentials `admin@example.com:password` to get access to the website's dashboard.

You can add more users via dashboard

You can run tests by running `php artisan test`
