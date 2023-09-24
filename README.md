# Setup

## Run Environment
```bash
docker-compose -p csgo --env-file .env up -d
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
