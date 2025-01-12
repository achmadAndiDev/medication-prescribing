# Laravel Application Setup Guide

Follow these steps to set up and run your Laravel application:

## 1. Clone the Repository
Make sure to clone the repository from your Git provider:
```bash
git clone <repository-url>
cd <repository-directory>
```

## 2. Set Up Environment Configuration
1. Copy the `.env.example` file to create a new `.env` file:
   ```bash
   cp .env.example .env
   ```
2. Manually create an empty database, for example, named `medication-prescribing`.

3. Open the `.env` file and adjust the database connection settings:
   ```bash
   DB_DATABASE=medication-prescribing
   DB_USERNAME=your-database-username
   DB_PASSWORD=your-database-password
   ```

4. Configure the API settings in the `.env` file:
   ```bash
   API_AUTH_EMAIL=your-api-auth-email
   API_AUTH_PASSWORD=your-api-auth-password
   API_BASE_URL=http://domain.com/api/v1
   ```

## 3. Install Dependencies
Install the required dependencies using Composer:
```bash
composer install
```

## 4. Run Database Migrations
Run the migrations to create the necessary database tables:
```bash
php artisan migrate
```

## 5. Seed the Database
Populate the database with initial data:
- Add default user(s):
  ```bash
  php artisan db:seed --class=UserSeeder
  ```
- Add fake master data:
  ```bash
  php artisan db:seed --class=FakerMasterDataSeeder
  ```

## 6. Start the Application
Run the application locally:
```bash
php artisan serve
```

## 7. Access the Application
Open your browser and visit:
```
http://127.0.0.1:8000
```

Your application is now ready to use! 🎉

