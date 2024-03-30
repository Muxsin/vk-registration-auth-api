# VK Registration And Auth API 2024

## Requirement

- PHP 8.2
- MySql DBMS
- Composer

## Installation

1. Run `docker-compose up --build -d --remove-orphans`
1. Run `composer install` inside container
1. Run `php ./marusia migrate` inside container

## Running

1. Run `docker-compose up --build -d --remove-orphans`
2. Visit http://localhost:8080
3. Enjoy!

## Authorization

For authorization provide the token in `Authorization` header. Format: `<jwt_token>`

## Endpoints

- `POST /api/authorize`
    - **Access**: guest
    - **Body**:
        - `email`: string
        - `password`: string
    - **Description**: Endpoint for authorizing a user.
- `POST /api/register`
    - **Access**: guest
    - **Body**:
        - `email`: string
        - `password`: string
    - **Description**: Endpoint for registering a new user.
- `GET /api/feed`
    - **Access**: authorized
    - **Description**: The endpoint checks for token validation.

## Extra

- You can run `php ./marusia empty <tablename>` inside container to truncate table.