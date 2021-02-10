# pay_php

# - start application

1 - Open the terminal in the project's root folder

2 - Run the command: docker-compose up -d --build

3 - Run the command: docker-compose exec db sh

4 - Run the command: psql -U postgres -c "CREATE DATABASE pay"

5 - Run the command: exit

6 - Run the command: docker-compose exec web sh

7 - Run the command: php artisan migrate

8 - Run the command: exit

9 - Run the command: docker-compose exec db sh

10 - Run the command: psql -h db -U postgres

11 - Run the command: \c pay

12 - Run the command: insert into user_types(name, permission_ted, created_at, updated_at) values('User', true, now(), now());

13 - Run the command: insert into user_types(name, permission_ted, created_at, updated_at) values('Shopkeeper', false, now(), now());

14 - Run the command: exit

15 - Run the command: exit

16 - Open local server http://localhost:8000/

# - endpoints

- POST em /users

-> Exemplo de Body da Requisição

{

    "name": "Gabriela Carolina Ferranti",
    
    "document": "Gabriela Carolina Ferranti",
    
    "email": "gabrielaferranti@hotmail.com",
    
    "password": "12345",
    
    "user_type_id": 1
    
}



- GET em /users



- POST em /transfers

-> Exemplo de Body da Requisição

{

    "payer_id": 21,
    
    "payee_id": 22,
    
    "amount": 1.00
    
}
