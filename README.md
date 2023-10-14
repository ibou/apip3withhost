# Setup

## Run Environment
```bash
docker-compose -p cs2 --env-file .env up -d
```

## Generate key-pair
```bash
bin/console lexik:jwt:generate-keypair --skip-if-exists
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

# Run Auth Worker
```bash
docker exec -it php-fpm sh -c 'bin/console messenger:consume steamAuth -vv'
```

# Test
```bash
bin/console --env=test doctrine:database:drop --force
bin/console --env=test doctrine:database:create
bin/console --env=test doctrine:schema:create
bin/console --env=test doctrine:fixtures:load --no-interaction 
bin/phpunit
```
