# eight_sys
 
This project created to practice programing by me.

You can easy get started with Laravel-Project and PHP by cloning this repository.

## Requirement
 
* Doker 
version 20.10.10：動作確認済み
 
## Installation

You need to install Docker and to set a path.
 
## Usage
 
#### \#git clone

    git clone https://github.com/hako85hako/eight_sys.git

#### \#cloneしたdirに移動

    cd eight_sys

#### \#Dockerコンテナ作成

    docker-compose up -d --build 

#### ※注意

以下ポートを使用する

eight_sys_mysql		port:3306<br>
eight_sys_nginx		port:80

#### \#eight_sys_php_fpmに接続してcomposerをinstall

    docker exec -it eight_sys_php_fpm bash
    cd eight_sys
    composer install
    exit

#### \#.envファイル作成

    vi source/eight_sys/.env

#### \#作成した.envファイルに以下を添付
    
    APP_NAME=EIGHT_SYS
    APP_ENV=local
    APP_KEY=base64:b6qIKwnvhBmts9k7oNw/ejB7KKLRZrCUy1gR0/WCmUU=
    APP_DEBUG=true
    APP_URL=http://localhost
    
    LOG_CHANNEL=stack
    LOG_DEPRECATIONS_CHANNEL=null
    LOG_LEVEL=debug

    ####検証設定################
    DB_CONNECTION=mysql
    #hostはDockerのmysqlサービス名にする必要がある
    DB_HOST=eight_sys_mysql
    DB_PORT=3306
    DB_DATABASE=eight_sys_local_db
    DB_USERNAME=root
    DB_PASSWORD=password
    ##########################

    ####本番設定用##########
    #DB_CONNECTION=mysql
    #DB_HOST=localhost
    #DB_PORT=3306
    #DB_DATABASE=eight_sys
    #DB_USERNAME=root
    #DB_PASSWORD=
    #######################

    BROADCAST_DRIVER=log
    CACHE_DRIVER=file
    FILESYSTEM_DRIVER=local
    QUEUE_CONNECTION=sync
    SESSION_DRIVER=file
    SESSION_LIFETIME=120

    MEMCACHED_HOST=127.0.0.1

    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379

    MAIL_MAILER=smtp
    MAIL_HOST=mailhog
    MAIL_PORT=1025
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS=null
    MAIL_FROM_NAME="${APP_NAME}"

    AWS_ACCESS_KEY_ID=
    AWS_SECRET_ACCESS_KEY=
    AWS_DEFAULT_REGION=us-east-1
    AWS_BUCKET=
    AWS_USE_PATH_STYLE_ENDPOINT=false

    PUSHER_APP_ID=
    PUSHER_APP_KEY=
    PUSHER_APP_SECRET=
    PUSHER_APP_CLUSTER=mt1

    MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
    MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

#### \#vi終了
    :wq

#### \#再びeight_sys_php_fpmに接続してtable作成

    docker exec -it eight_sys_php_fpm bash
    cd eight_sys
    php artisan migrate
    php artisan db:seed
    exit

#### \#ブラウザにてapp起動

    URL		:	localhost:80
    Email		:	test@test
    password	:	test1234

 
## Note
 
## Author 
* sakai
* eightist
* sakaiyuto47@gmail.com
 
## License
"eight_sys" is not Confidential.

If you need to confidential, pleasse request for me.

