# pay_php - start application

1 - Open the terminal in the project's root folder
2 - Run the command: docker-compose up -d --build
3 - Run the command: docker-compose exec db sh
4 - Run the command: psql -U postgres -c "CREATE DATABASE pay"
5 - Run the command: exit
6 - Run the command: docker-compose exec web sh
7 - Run the command: php artisan migrate
8 - Run the command: exit
9 - Open local server http://localhost:8000/