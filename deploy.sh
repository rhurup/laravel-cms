#!/bin/bash

if git rev-parse --git-dir > /dev/null 2>&1; then
  : # This is a valid git repository (but the current working
    # directory may not be the top level.
    # Check the output of the git rev-parse command if you care)
    echo "This is a valid git repository - pulling from https://github.com/rhurup/laravel-cms.git"
    php artisan down
    git fetch
else
  : # this is not a git repository
    echo "This is NOT a valid git repository - git clone from https://github.com/rhurup/laravel-cms.git ."
    git clone https://github.com/rhurup/laravel-cms.git .
    cp ./.env.example ./.env
fi

while true; do
    read -p "Have you created/configured your .env?" yn
    case $yn in
        [Yy]* )  break;;
        [Nn]* ) echo "Canceling... Run ´sh deploy.sh´ again when ready."; exit;;
        * ) echo "Please answer yes or no.";;
    esac
done

rm -rf vendor/

# Update composer and dependencies
composer dump-autoload
composer install

# Run those files(!)
php artisan migrate

# Clear cached facades & views
php artisan cache:clear
php artisan view:clear
php artisan clear-compiled

# Flush expired password reset tokens
php artisan auth:clear-resets

# Clear all cached events and listeners
php artisan event:clear

# Remove the cached bootstrap files
php artisan optimize:clear

# Remove the configuration cache - https://laravel.com/docs/5.8/deployment#optimizing-configuration-loading
php artisan config:clear

# Publish all assets (but publish telescope & horizon separately as they need to override assets using the --force)
php artisan vendor:publish --all
php artisan telescope:publish
php artisan horizon:publish

# Optimize routes - https://laravel.com/docs/5.8/deployment#optimizing-route-loading
php artisan route:cache

# Restarting horizon
php artisan horizon:terminate

php artisan storage:link

echo "Copy jquery to public/vendor"
cp -R vendor/components/jquery public/vendor/
echo "Copy font-awesome to public/vendor"
cp -R vendor/components/font-awesome public/vendor/
echo "Copy bootstrap to public/vendor"
cp -R vendor/twbs/bootstrap/dist public/vendor/bootstrap

# Enable Laravel again
php artisan up
