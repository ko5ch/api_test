## Install

preparing:
```
 Install Docker Desktop
  add to your hosts file:
    127.0.0.1 demo.local #Linux
    10.0.75.2 demo.local #Windows
```
copy from repository:
```
git clone https://github.com/ko5ch/api-test.git
```
run docker in project folder:
```
docker-compose up
```

enter to container:
```
docker exec -ti api_app sh
or
docker exec -ti todoko5ch_app /bin/bash
or 
docker exec -ti api_app bash 
```
copy .env file:
```
cp .env.example .env #Linux

copy .env.example .env #Windows
```

install deps in container:
```
composer install
```
create manually new database "laravel" via sql manager(like HeidiSql, etc.)
(host:10.0.75.2, port:5432, username: postgres)

migration and seeders command:
```
php artisan boss
```


generate application key:
```
php artisan key:generate
```

## DONE!
