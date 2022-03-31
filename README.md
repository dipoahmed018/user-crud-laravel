# Welcome,

# Backend API setup proccess

## Requirements:
1. A running mysql server.
2. php version="8.0.2" or higher
3. A network connection for mail sending.

## Open the .env file located in backend folder

1. Update these enviorement variables (DB_CONNECTION, DB_HOST, DB_PORT, DB_USERNAME, DB_PASSWORD) as per your server
2. Create a database named "user_management" in your database
3. Run this command "php artisan migrate --seed"
4. Run this command "php artisan serve --host 127.0.0.2:80"
