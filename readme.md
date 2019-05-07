## some Elegant thing
## based on laravel-api package


## Installation

```bash
composer update
```

```
APP_NAME=Elegant
APP_ENV=local
APP_DEBUG=true
APP_KEY=

API_STANDARDS_TREE=vnd
API_SUBTYPE=api
API_PREFIX=api
API_VERSION=v1
API_DEBUG=true

DB_HOST=localhost
DB_DATABASE=elegant
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

MAIL_DRIVER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PASSPORT=later

```

```bash
php artisan migrate --seed
php artisan passport:install --force
update .env PASSPORT with (Laravel API Password Grant Client)
php artisan optimize
php artisan route:cache
php artisan api:cache
```

```bash
cd vue/admin
yarn
```

edit .env like below :
```bash
TITLE=Elegant
BASE_URL=http://elegant.lol/
PUBLIC_FOLDER=vuestic
INDEX_PATH=backend
```

```bash
yarn serve
```

```bash
yarn build
```
here goes to ./public/vuestic (which comes from .env on ./vue/admin) for now you should copy ./public/vuestic/vuestic ro ./public/vuestic