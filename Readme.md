Application set up:
1. use php 8.2+
2. use sqlite db
3. run composer install
4. in your .env DATABASE_URL="sqlite:///%kernel.project_dir%/var/minimizer_test_task_db.db"
5. run php bin/console doctrine:database:create
6. run php bin/console doctrine:migrations:migrate
7. run php -S localhost:8000 -t public