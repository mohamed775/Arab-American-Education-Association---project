<div align="center">
  <h1>🚀 E-Larning API with JWT Auth </h1>
</div>

## 📄 Description

Welcome to the E-learning Courses API project built with Laravel! This API serves as a backend for managing E-learning courses, providing endpoints for course management, user enrollment, and authentication. It utilizes Laravel's powerful features along with PHP traits for common functionality and returns JSON responses for easy consumption by client applications.


## Table of Contents
- [Installation](#installation)
- [Usage](#usage)
  - [Endpoints](#endpoints)
  - [Authentication](#authentication)
  - [Error Handling](#error-handling)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)
- [Acknowledgments](#acknowledgments)

  
## 📦 Installation

To get started with the E-learning Courses API, follow these steps:

1. Clone the repository:
   ```bash
   https://github.com/mohamed775/Arab-American-Education-Association---project.git
Navigate into the project directory:
cd elearning-courses-api
 - Install dependencies using Composer:

composer install
 - Copy the .env.example file to create a .env file:
cp .env.example .env
 - Generate an application key:

php artisan key:generate
 - Configure your database connection and JWT secret key in the .env file.
 - Run database migrations to create the necessary tables:

 - php artisan migrate
 - Serve the application:

 - php artisan serve
 - Your E-learning Courses API should now be accessible at http://localhost:8000.


## 🚀 Authentication

- This API uses JWT (JSON Web Token) authentication. To authenticate requests to protected endpoints, include the JWT token in the Authorization header of the request.
  

## ![API Endpoint Icon](https://img.icons8.com/plasticine/100/000000/api-settings.png)

Endpoints
- POST /api/login: Login to obtain a JWT token.
- POST /api/register: Register a new user.
- GET /api/courses: Retrieve a list of all courses.
- GET /api/courses/{id}: Retrieve details of a specific course.
- POST /api/courses: Create a new course.
- PUT /api/courses/{id}: Update details of an existing course.
- DELETE /api/courses/{id}: Delete a course.
- POST /api/enroll/{id}: Enroll in a course.
- Add your custom endpoints here
- 
## ![Hammer Icon](https://img.icons8.com/color/48/000000/hammer.png)

- **Laravel**: A PHP web application framework for building APIs and web applications.
- **PHP**: The scripting language used by Laravel.
- **Composer**: A dependency manager for PHP, used for installing Laravel packages and dependencies.
- **JWT Auth**: JSON Web Token authentication library for Laravel.
- **Git**: A version control system used for managing the project's source code.
- **GitHub**: A web-based platform for hosting and collaborating on Git repositories.


## ✨ Features

- CRUD Operations on Courses: Create, read, update, and delete courses.
- User Authentication with JWT: Secure endpoints with JSON Web Token authentication.
- User Enrollment: Allow users to enroll in courses.
- Add more features here

## 🤝 Contributing

- Contributions are welcome! Feel free to open issues or submit pull requests for any improvements or features you'd like to see added to the project.

## 📝 License
---------------------------------------------------------
- This project is licensed under the MIT License.
---------------------------------------------------------

## 📬 Contact

- Feel free to customize this template according to your project's specific requirements and implementation details. Let me know if you need further assistance or have any questions!

