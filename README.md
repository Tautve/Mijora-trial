## Setup (for dev)

1. Create ``.env.local`` file and overwrite the values specified in ``.env``
2. Execute following commands:
```
composer install
yarn install
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate
bin/console omniva:create-cron
yarn encore dev
```
3. Initialise cron: ``* * * * * /path/to/project/app/console cron:run 1>> /dev/null 2>&1``
4. Run: ```bin/console cron:run --schedule_now DatabaseSynchronisation``` for scheduling the task now
5. Initialise symfony server: ``symfony serve -d``
6. Check listening port and go to your browser ``localhost:{your port}/omniva/post-machines/show``

###For tests

1. Create ``.env.test.local`` file and fill in missing parameters
2. ```bin/console doctrine:database:create --env=test```
3. ```bin/console doctrine:migrations:migrate --env=test```
4. run tests: ```./vendor/bin/phpunit```