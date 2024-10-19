Daily Awareness Tracker

A simple Laravel application is required for a user to simply track some essential daily stats.

Steps to run the application
1. Setup .env and the database credentials
2. Run the migration using command
    
    php artisan migrate
    
3. Run the seeders using
    
    php artisan db:seed
    
4. Finally, run the application

    php artisan serve
    
Credentials for Test User
email: test@example.com

password: password


Features
1. Login and Registration
2. Enter Daily awareness data with quality score
3. Analytics of the quality score
4. Update and delete the data
5. Notification in the nav in case you forget to enter todays' data

