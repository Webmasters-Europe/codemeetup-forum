# codemeetup-forum

## Objective of the project
The goal is to set up the code for a generic online **[Internet Forum](https://en.wikipedia.org/wiki/Internet_forum)** which can be taylored to needs for various purposes.

## The goal underneath
This is a place where developers can learn the ropes of software collaboration and how to go about github projects. Our very experienced and super patient host Niclas is guiding us all the way.

### Approach
We work in 2 groups towards our common goal: One team is responsible for the **backend** functionalities the other is providing the code needed on the **frontend** side.


### Weekly Meetups and Proceeding
We meet once a week to discuss what needs to be done. We start out as a joined group and then usually we split up into the **frontend** and the **backend** teams.

***New members are welcome to join either group!***

## Howtos

### How to setup the project using XAMPP on Windows?

1. Install [XAMPP](https://www.apachefriends.org/de/download.html).
2. Within the xampp/htdocs directory: Checkout the forked project.
3. Setup the project:
    ```
      # composer install
    ```
    ```
      # npm install
    ```
    ```
      # php artisan key:generate
    ```
   Create an .env file based on the keys given in env.example file.


4. Open the XAMPP control panel and start the MySQL and Apache services.
5. In your [PhpMyAdmin frontend](http://localhost/phpmyadmin) create a database named like the database defined in DB_DATABASE in your .env file.
6. Create datatables and mockup data:
    ```
      # php artisan migrate --seed
    ```
7. Create a [mailtrap](https://mailtrap.io/) account.
   Put your mailtrap credentials (MAIL_MAILER, MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD) in the .env file and set MAIL_FROM_ADDRESS to a email address of your choice.
8. Ready, go!

### What to do after each pull from the forked repo?

Install new backend packages:
```
# composer install
```

Install new frontend packages:
```
# npm install
```

Grab database changes:
```
# php artisan migrate
```

Optional: If you also want to create mockup data:
```
# php artisan db:seed
```

Optional: If you want to refresh all DB tables (this deletes all data stored before!):
```
# php artisan migrate:fresh
```

### How to clear the cache?

```
# php artisan cache:clear
```

```
# php artisan route:clear
```

```
# php artisan view:clear
```
