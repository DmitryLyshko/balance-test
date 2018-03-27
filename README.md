Config

config/main-local.php

'dsn' => 'mysql:host=mysql;dbname=yii2',
'username' => 'root',
'password' => 'secret'

Start up

> init_app.sh

> docker-compose build

> docker-compose up

Calculate

> php yii calculate 2018-01-01 2018-04-31
