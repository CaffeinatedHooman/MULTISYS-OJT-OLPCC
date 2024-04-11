OLPCC-php-Laravel
This project is a PHP Laravel application that implements CRUD operations for todos and subtasks, along with JWT authentication for user login and logout.

Features
CRUD Operations: The application allows users to perform CRUD operations (Create, Read, Update, Delete) on todos and subtasks.

Relationship between Todos & Subtasks: Todos can have multiple subtasks associated with them. The application implements a one-to-many relationship between todos and subtasks.

JWT Authentication: User authentication is implemented using JSON Web Tokens (JWT). Users can log in securely and log out when done.

Getting Started
To get started with this project, follow these steps:

Clone the repository to your local machine:

bash
Copy code
git clone https://github.com/your-username/OLPCC-php-Laravel.git
Navigate to the project directory:

bash
Copy code
cd OLPCC-php-Laravel
Install dependencies using Composer:

bash
Copy code
composer install
Set up your environment file by copying the example file:

bash
Copy code
cp .env.example .env
Generate an application key:

bash
Copy code
php artisan key:generate
Set up your database and configure the database connection in the .env file.

Migrate the database to create tables:

bash
Copy code
php artisan migrate
Serve the application:

bash
Copy code
php artisan serve
You can now access the application in your web browser at http://localhost:8000.

Usage
Authentication:

Use the /auth/login endpoint to log in and obtain a JWT token.
Include the token in the Authorization header for authenticated requests.
Todos:

Perform CRUD operations on todos using the /todos endpoints.
Each todo can have multiple subtasks associated with it.
Subtasks:

Perform CRUD operations on subtasks using the /todos/{todo_id}/subtasks endpoints.
Each subtask belongs to a specific todo.
