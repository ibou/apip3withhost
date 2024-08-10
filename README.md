# Setup

## Run Environment
```bash
docker-compose --env-file /app/.env -f /app/docker/docker-compose.yml -p cs2 up -d
```

## Generate key-pair
```bash
docker exec -it php-fpm sh -c 'bin/console lexik:jwt:generate-keypair --skip-if-exists'
```

## Database
```bash
docker exec -it php-fpm sh -c 'bin/console doctrine:database:drop --force \
  && bin/console doctrine:database:create \
  && bin/console doctrine:schema:create \
  && bin/console doctrine:fixtures:load --no-interaction' 
```

## Frontend
```bash
docker run -it --rm -v $(pwd):/app tarach/yarn-v1.22.19 sh -c "yarn install \
  && yarn run dev"
docker exec -it php-fpm sh -c 'bin/console importmap:update'
docker exec -it php-fpm sh -c 'bin/console asset-map:compile'
```

# Run Auth Worker
```bash
docker exec -it php-fpm sh -c 'bin/console messenger:consume steamAuth -vv'
```

# Test
```bash
docker exec -it php-fpm sh -c 'bin/console --env=test doctrine:database:drop --force \
  && bin/console --env=test doctrine:database:create \
  && bin/console --env=test doctrine:schema:create \
  && bin/console --env=test doctrine:fixtures:load --no-interaction \ 
  && bin/phpunit'
```

# Docker development with SSL Certificate
Run ```generate.sh``` script from ssl-test/ directory. Note ( Edit line CN="192.168.56.10" to match your host )

## Upload and enable SSL Cert on your docker host
```bash
cd ssl-test/
sftp user@192.168.56.10:ssl-test
put *

ssh user@192.168.56.10
sudo cp ca.pem /root/.docker/
sudo cp server.key /root/.docker/key.pem
sudo cp server.pem /root/.docker/cert.pem
```
Edit OpenRC service configuration for docker and add ```DOCKER_OPTS="--host 0.0.0.0:2375 --tlsverify"```
```bash
sudo nano /etc/conf.d/docker
```

# Debug
```bash
docker exec -it php-fpm sh -c "XDEBUG_CONFIG=\"idekey=PHPSTORM\" bin/console"
```
