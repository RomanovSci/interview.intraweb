## How to run
1) Install application dependencies: `composer install`, `npm install`
2) Copy .env file and configurate it `cp ./.env.example ./.env`
3) Configure DB and apply migration with `php artisan migrate`
4) Generate application key `php artisan key:generate`
5) Build frontend: `npm run prod`
6) Run server: `php artisan serve`
7) Open `http://localhost:8000` in your browser

## Telegram
For telegram bot configuration you should publish this project. You can [forward tunel](https://ngrok.com) for your local machine or deploy application on public server. After forwording/deploying, you should to set webhook for telegram bot.
Paste your telegram bot token to `.env` file (TELEGRAM_TOKEN property) and run the command: `php artisan bot:setup`
