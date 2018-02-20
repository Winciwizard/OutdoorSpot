# OutdoorSpot

##Installation

1. Clone the project
2. Got to the folder application using **cd**
3. Run **composer install** on your cmd or terminal
4. Copy **.env.example** file to **.env** on root folder. for windows **copy .env.example .env** and for linux **cp .env.example .env**
5. Open your **.env** file and change the database name (**DB_DATABASE**) to wathever you have, username (**DB_USERNAME**) and password (**DB_PASSWORD**) field correspond to your configuration
6. Run **php artisan key:generate**
7. Run **php artisan migrate**
8. Run **php artisan serve**
9. Got to [http://127.0.0.1:8000](http://127.0.0.1:8000)





