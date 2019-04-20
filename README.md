# the-clean-living-community

Start server<br>
php -S localhost:8000 -t public/ <br>
or<br>
php artisan serve --port=8000<br>

Init Auth:
composer update
php artisan migrate:fresh --seed
php artisan key:generate
