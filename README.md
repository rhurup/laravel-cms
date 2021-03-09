<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

## About Laravel CMS

Laravel CeeMS is a web application framework with web, admin and API:

## Run the deploy command:

1. Open your terminal
2. Go to your desired folder where you want the files placed.

### Install:
``` bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/lararocks/laravel-cms/master/deploy.sh)"
```

### Configure .env:
``` dotenv
APP_NAME=YourWebSiteName

APP_LOCALE=da 

APP_URL=http://local.example.com
APP_DOMAIN=local.example.com

ADMIN_URL=http://localadmin.example.com
ADMIN_DOMAIN=localadmin.example.com

API_URL=http://localapi.example.com
API_DOMAIN=localapi.example.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=example
DB_USERNAME=root
DB_PASSWORD=root

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```


### Security

If you discover any security-related issues, please email [rasmus@huruphansen.dk](mailto:rasmus@huruphansen.dk) do not use the issue tracker!

## Credits

- [Rasmus Hurup Hansen](https://github.com/rhurup)
- [Janich Rasmussen](https://github.com/janich)


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.