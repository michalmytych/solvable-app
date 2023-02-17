# Solvable

Backend for an application for interactive learning of programming.
Learn about [contributing](docs/contributing.md).

### Setup

To run this app you need:
* Php ^8.1
* Composer 2
* MySQL/MariaDB
* Node.js

For Windows, I recommend using XAMPP.

### Step by step
1. Clone the repository, then `cd` to root project directory.
2. Much of app configuration variables is held in `.env` file. As you can probably see, there is no file of this name in repository. That is because we don't commit this file into git. Just copy `.env.example` as `.env`.
3. In newly created `.env` file, fill database credentials:
```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=name_of_your_database
DB_USERNAME=username_may_be_root_if_locally
DB_PASSWORD=user_password
```
4. Database of name that you provided for `DB_DATABASE` don't have to exist, because Laravel will create it for you.
5. You need to generate application encryption key for your auth services. Use `php artisan key:generate`.
6. All the changes you have made to `.env` file won't be loaded into application if you will not clear the configuration cache. Do `php artisan config:cache`.
7. Now, to make sure everything is working properly, you can run `php artisan test`.
8. You can run this app with `php artisan serve`.