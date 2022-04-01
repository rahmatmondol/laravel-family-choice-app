## Project Setup

### Clone Project Repo
- Using SSH:
```
git clone git@github.com:<your-user-name>/<repo-name>.git

```
- Using HTTPS:
```
git clone https://github.com/<your-user-name>/<repo-name>.git
```

then change directory to get inside the project folder

### Install project dependencies
```
composer install
```

### Create .env file
```
cp .env.example .env
```

### Setup database connection

- DB_DATABASE=alohaeg1_sql
- DB_USERNAME=alohaeg1_aloha
- DB_PASSWORD=

By default, the username is ```root``` and you can leave the password field ```empty```.

### Generate project key
```
php artisan key:generate
```

### Migrate tables and seed data
```
php artisan migrate:fresh --seed
``` 

### Install passport keys
```
php artisan passport:install
``` 

Now run ```php artisan serve``` & go to ```localhost:8000```
