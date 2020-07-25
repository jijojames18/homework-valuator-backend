# homework-valuator-backend
The Backend module of the home work valuator project. Developed using PHP, providing REST endpoints which interact with MySQL to perform CRUD operations

Front End Repository : [homework-valuator-frontend](https://github.com/jijojames18/homework-valuator-frontend)  

### Dependencies:
• PHP  
• Composer  
• MySQL  

### Libraries
• DotEnv (Loading environment variables)

Copy `.env.example` outside to working directory and reanme to `.env` and configure the database credentials as variables. 

### Rest Endpoints
#### questions
• GET /questions/id

#### answers
• GET /answers/id/userid
• POST /answers/id/userid

## Project setup
```
composer install
```
