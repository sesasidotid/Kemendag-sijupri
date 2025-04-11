# Requirements
1. php v-8.2 (min)
2. php-fpm (menyesuaikan versi php)
3. postgreSql
4. java 8
5. supervisor

sijupri be service configuration.

//

sijupri be app configuration

## 1. **report**
run 
```php 
php artisan eyegil:jasper-link
```
then follwo up with an input **postgresql-42.7.4.jar**

install supervisor :
```sh
sudo apt-get install supervisor
or
sudo yum install supervisor
```

create file 'sudo vi /etc/supervisor/conf.d/sijupri-worker.conf'
```conf
[program:sijupri-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /sesasi/app/sijupri-be/artisan queue:work  --sleep=3 --tries=3 
autostart=true
autorestart=true
numprocs=5
user=www-data
redirect_stderr=true
stdout_logfile=/sesasi/app/sijupri-be/storage/logs/worker.log
```

run command 
```sh
sudo systemctl start supervisor
sudo systemctl enable supervisor
sudo supervisorctl reread
sudo supervisorctl update
```

## 2. **JOB**
open cron
```sh
crontab -e
```
add this on the file
```sh
* * * * * php /sesasi/app/sijupri-be/artisan schedule:run >> /dev/null 2>&1
```

## 3. **Build**
build the app before using it by running this command
```sh
php artisan config:cache
php artisan route:cache
```
