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
• POST /answers/id/userid

### Environment Variables
• APP_ENV (development/production)  
• DB_HOST  
• DB_NAME  
• DB_USER  
• DB_PASSWORD  

If `APP_ENV='production'`, the  `.env` file is ignored and the variables should be set manually using the corresponding methods prescribed by your cloud provider.

## Project setup
```
composer install
```  

## ER Diagram for the database
![ER Diagram](https://github.com/jijojames18/homework-valuator-backend/blob/master/er/ER-DATABASE.png?raw=true)
