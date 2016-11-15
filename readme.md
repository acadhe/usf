# UCP

## Build

1. Run `composer install`.
2. Create `.env` file (see `.env.example`).
3. Run `php artisan migrate`.
4. (Optional) Run `php artisan migrate:reset` to drop all migrations.
5. Run `php artisan db:seed` to add data into database

## Heroku Link (+ Staging Promotion)

[https://dashboard.heroku.com/pipelines/0ea66760-fc4c-4fc8-b03f-c2d90a72d1e4](https://dashboard.heroku.com/pipelines/0ea66760-fc4c-4fc8-b03f-c2d90a72d1e4)

## Staging Environment

[http://morning-plains-80709.herokuapp.com/](http://morning-plains-80709.herokuapp.com/)

### Show Logs

`heroku logs -t -n 100 --app morning-plains-80709`

### Staging DB Console

`heroku pg:psql --app morning-plains-80709`

## Production Environment [http://urbansocialforum.herokuapp.com/](http://urbansocialforum.herokuapp.com/)

### Show Logs

`heroku logs -t -n 100 --app urbansocialforum`

#### Production DB Console

`heroku pg:psql --app urbansocialforum`