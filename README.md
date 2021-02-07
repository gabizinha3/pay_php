# pay_php - start application

1 - Open the terminal in the project's root folder

2 - Run the command: docker-compose up -d --build

3 - Run the command: docker-compose exec db sh

4 - Run the command: psql -U postgres -c "CREATE DATABASE pay"

5 - Run the command: psql -h db -U postgres

6 - Run the command: \c pay

7 - Run the command: insert into user_types(name, permission_ted, created_at, updated_at) values('User', true, now(), now());

8 - Run the command: insert into user_types(name, permission_ted, created_at, updated_at) values('Shopkeeper', false, now(), now());

9 - Run the command: exit

10 - Run the command: exit

11 - Run the command: docker-compose exec web sh

12 - Run the command: php artisan migrate

13 - Run the command: exit

14 - Open local server http://localhost:8000/
