# Setup

## Simple environment
```bash
sudo apt install autoconf
sudo apt install libsqlite3-dev

phpbrew install 8.2.8 +default +openssl +mb +debug +phar +mcrypt +pdo +iconv +pgsql +sqlite +intl +opcache +iconv
```

## Database
```bash
bin/console doctrine:database:drop --force
bin/console doctrine:database:create
bin/console doctrine:schema:create
bin/console doctrine:fixtures:load --no-interaction 
```

## Frontend
```bash
yarn install
yarn run dev
bin/console asset-map:compile --clean
```

# Run
```bash
php -t ./public -S 127.0.0.1:3000
```
Note: ```symfony``` cli tool has issues recognizing DATABASE_DRIVER environment variable correctly ( it relies on schema )

# Test
```bash
bin/console --env=test doctrine:database:drop --force
bin/console --env=test doctrine:database:create
bin/console --env=test doctrine:schema:create
bin/console --env=test doctrine:fixtures:load --no-interaction 
bin/phpunit
```
