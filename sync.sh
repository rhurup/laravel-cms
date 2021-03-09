#!/bin/bash
# Ask the user for their remote path

if [ "$1" != "" ]; then
    echo ""
else
    echo "Path must not be empty"; exit;
fi

echo Following folders will be copied, folders will not be overwritten only merged/updated to $1

echo app/Console/Kernel.php

echo app/Exceptions/Api
echo app/Exceptions/Laravel
echo app/Exceptions/Handler.php
echo app/Exceptions/ApiException.php

echo app/Http/Controllers
echo app/Http/Middleware
echo app/Http/Responses

echo app/Jobs

echo app/Mail

echo app/Models

echo app/Policies

echo app/Providers

echo app/Services

echo app/Traits

echo app/Utilities

echo config

echo database

echo public/images
echo public/dist
echo public/css/admin.css
echo public/css/frontend.css

echo public/js/admin.js
echo public/js/frontend.js

echo resources/lang/da
echo resources/lang/en
echo resources/views/admin
echo resources/views/emails
echo resources/views/frontend
echo resources/views/layouts
echo resources/views/errors

echo routes/admin.php
echo routes/api.php
echo routes/web.php

while true; do
    read -p "Are you sure you want to copy all files" yn  &&
    case $yn in
        [Yy]* )  break;;
        [Nn]* ) echo "Canceling... "; exit;;
        * ) echo "Please answer yes or no.";;
    esac
done

cp -r -v app/Console/Kernel.php $1/app/Console/Kernel.php
cp -r -v app/Exceptions/Api/ $1/app/Exceptions/Api
cp -r -v app/Exceptions/Laravel/ $1/app/Exceptions/Laravel
cp -r -v app/Exceptions/Handler.php $1/app/Exceptions/Handler.php

cp -r -v app/Http/Controllers/ $1/app/Http/Controllers
cp -r -v app/Http/Middleware/ $1/app/Http/Middleware
cp -r -v app/Http/Responses/ $1/app/Http/Responses

cp -r -v app/Jobs/ $1/app/Jobs

cp -r -v app/Mail/ $1/app/Mail

cp -r -v app/Models/ $1/app/Models

cp -r -v app/Policies/ $1/app/Policies

cp -r -v app/Providers/ $1/app/Providers

cp -r -v app/Services/ $1/app/Services

cp -r -v app/Traits/ $1/app/Traits

cp -r -v app/Utilities/ $1/app/Utilities

cp -r -v config/ $1/config

cp -r -v database/ $1/database

cp -r -v public/images/ $1/public/images
cp -r -v public/dist/ $1/public/dist

cp -r -v public/css/admin.css $1/public/css/admin.css
cp -r -v public/css/frontend.css $1/public/css/frontend.css

cp -r -v public/js/admin.js $1/public/js/admin.js
cp -r -v public/js/frontend.js $1/public/js/frontend.js

cp -r -v resources/lang/da/ $1/resources/lang/da
cp -r -v resources/lang/en/ $1/resources/lang/en
cp -r -v resources/views/admin/ $1/resources/views/admin
cp -r -v resources/views/emails/ $1/resources/views/emails
cp -r -v resources/views/frontend/ $1/resources/views/frontend

cp -r -v resources/views/layouts/ $1/resources/views/layouts

cp -r -v resources/views/errors/ $1/resources/views/errors

cp -r -v routes/admin.php $1/routes/admin.php
cp -r -v routes/api.php $1/routes/api.php
cp -r -v routes/web.php $1/routes/web.php


echo "DOOOOOOOOOOOOOONNNNNNNNNNEEEEEE :)"
echo "WARNING :::: PLEASE CHECK COMPOSER FOR CHANGES - IT IS NOT COPIED !!!! "