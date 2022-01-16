## Setup

1. Create ``.env.local`` file and overwrite the values specified in ``.env``
2. Execute following commands:
```
composer install
yarn install
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate
bin/console omniva:create-cron
yarn encore dev|prod
```
3. Initialise cron: ``* * * * * /path/to/project/app/console cron:run 1>> /dev/null 2>&1``
4. Initialise symfony server: ``symfony serve -d``
5. Check listening port and go to your browser ``localhost:{your port}/omniva/post-machines/show``