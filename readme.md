

## How to run
1) Install application dependencies: `composer install`, `npm install`
2) Copy .env file and configurate it `cp ./.env.example ./.env`
3) Configure DB and apply migration with `php artisan migrate`
4) Build frontend: `npm run prod`
5) Run server: `php artisan serve`
6) Open `http://localhost:8000` in your browser

## Telegram
For telegram bot configuration you should [to forward tunel](https://ngrok.com) your local machine or deploy project to server.
After forwording/deploying you should to set webhook for your telegram bot. Just send request to: `https://api.telegram.org/bot<TELEGRAM_TOKEN_HERE>/setWebhook?url=<PROJECT_URL>`
