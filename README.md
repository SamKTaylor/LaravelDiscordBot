# Testing for a Laravel baised Discord Bot

CI/CD with github actions. (Disabled for now) 

docker-compose.yml included for development.

## Development Setup

Make sure you user belongs to www-data group, make sure src folder is owned by www-data user and group.

to run composer update on container use the following docker command, you will need to do this at least once.

```
docker exec -it -w /var/www/html discord_dev_web composer update
```

### MYSQL

Project will pull mysql credentials from laravel .ENV file. These are named identicallly to the ENV variables required by official mysql docker containers so you can use the same file for both and thent he details will match.

### Tech used:
Docker - Nginx - PHP-FPM - MYSQL - Laravel 7

Laravel 7:
  * Bootstrap 4
  * jquery
  * datatables
  * https://github.com/yajra/laravel-datatables
  * https://github.com/DirectoryTree/LdapRecord-Laravel
  
  