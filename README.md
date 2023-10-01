# Installation
Clone the project

```bash
git clone --single-branch --branch dev.0.0.1 https://github.com/akib-web/mediusware-coding-test.git
```

You can install the package via composer:

```bash
composer install
```

copy Env file
```bash
cp .env.example .env or copy .env.example .env
```

Generate APP Key:

```bash
php artisan key:generate

```
Set database name & run migrations:

```bash
php artisan migrate

```

- Register a user & test the banking app.
- A user can see the trasaction list, deposit amount by user id & withdraw from the account. the total balance has been calulated.


