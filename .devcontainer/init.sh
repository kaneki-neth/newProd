git config --global --add safe.directory /workspaces/julimons.erp

# update webserver port
while read line; do

   echo ${line//<APP_URL>/"https://"$CODESPACE_NAME"-80.app.github.dev"}

done < /home/app/.devcontainer/.env.dev > /home/app/.env

cd /home/app

composer install

php artisan config:clear
php artisan key:generate
php artisan storage:link

php artisan migrate --force --seed

npm install