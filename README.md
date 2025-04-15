# Freelancer Project Management API

## Overview

This API is designed for developers, particularly freelancers, to manage their projects effectively. It includes features for:

-   Tracking projects and clients
-   Managing experiences and certifications
-   Handling project-related evaluations
-   Task management associated with clients and projects
-   Monitoring bank balances and transactions
-   Sending bank balances
-   Checking status of ongoing projects

This comprehensive tool aims to streamline project management and enhance productivity for developers and create cv for freelancers.

## Getting Started

### Prerequisites

Before you begin, ensure you have the following installed:

-   PHP 8.1 or higher
-   Composer
-   Any database (I recommend MariaDB/MySQL)
-   Node.js (for frontend assets)

### Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/yhyasyrian/project-management-API-for-developers
    cd project-management-API-for-developers
    ```

2. Install PHP dependencies:

    ```bash
    composer install
    ```

3. Create and configure .env file:

    ```bash
    cp .env.example .env
    ```

4. Generate application key:

    ```bash
    php artisan key:generate
    ```

5. Configure database settings in .env:

    ```bash
    DB_CONNECTION=mariadb
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_db_name
    DB_USERNAME=your_db_user
    DB_PASSWORD=your_db_password
    ```

6. Run migrations and seeders:

    ```bash
    php artisan migrate --seed
    ```

7. Install Node.js dependencies (optional for frontend):
    ```bash
    npm install
    ```
8. Fill in the following information at the end of the .env file:
    ```bash
    # Auth
    JWT_SECRET=your_jwt_secret
    JWT_ALGO=your_jwt_algo
    AUTH_GUARD=api
    AUTH_PASSWORD_BROKER=users
    #Admin
    ADMIN_NAME="your_admin_name"
    ADMIN_EMAIL="your_admin_email"
    ADMIN_PASSWORD="your_admin_password"
    ```
9. Start the development server:
    ```bash
    php artisan serve
    ```

### Accessing API Documentation

Once the server is running, you can access the API documentation at:
`HOST/documentation/`
