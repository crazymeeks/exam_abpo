### API DOCUMENTATION [Click here](https://documenter.getpostman.com/view/1054414/2sAXjGdumR)

### HOW RUN?
#### CREATE DOCKER NETWORK(JUST COPY AND PASTE THE CODE BELOW WITHOUT ANY MODIFICATION)
```bash
docker network create \
  --driver=bridge \
  --subnet=172.28.0.0/16 \
  --ip-range=172.28.5.0/24 \
  --gateway=172.28.5.254 \
  devnetwork
```

### THEN, RUN THESE COMMANDS LINE BY LINE
```bash
docker compose build
docker compose up -d
```
### THEN PLS SSH TO DOCKER CONTAINER AND RUN COMPOSER INSTALL
```bash
// ssh to docker container
docker exec -it acquire-bpo-172.28.0.96 bash

// install dependencies
composer install

// migrate
php artisan migrate
```

### CREATE NEW USER
Authentication uses google oauth2. Please user in the DatabaseSeeder.php then run seed. Email must be a valid gmail.
```bash
php artisan db:seed
```

### LAST, copy the entire content of src/code/.env.example file to ./src/code/.env

### RUNNING TESTS
#### Make you are inside the container "acquire-bpo-172.28.0.96".
```bash
php artisan test
```

### Add this to your hosts file(assuming you are using linux ubuntu) located in /etc/hosts

```bash
172.28.0.96 acquire-bpo.local.com
```

### LAST, update values of G_ID and G_SECRET located at the very bottom of ./src/code/.env