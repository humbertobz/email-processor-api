# Email Processor API

This project consists of a RESTful API developed in Laravel to process, store and manipulate email content. It extracts the body of emails in plain text and stores the relevant data in a MySQL database. The API has functionalities to list, create, edit and delete processed email records.

## Features

- List all processed emails
- Create a new processed email
- Update the data of an existing email
- Delete (soft delete) a processed email
- Process the content of emails (extract the email body in plain text)

## Prerequisites

Before running the project locally, you will need to have the following tools installed on your machine:

- [PHP 8.x](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/download/)
- [MySQL](https://dev.mysql.com/downloads/installer/)
- [Node.js](https://nodejs.org/en/) and [npm](https://www.npmjs.com/)
- [Laravel 11.x](https://laravel.com/docs/11.x)

## Steps to run the project locally

### 1. Clone the repository

Open the terminal and run the command:

```bash
git clone https://github.com/humbertobz/email-processor-api.git
```

Then, enter the project directory:

```bash
cd email-processor-api
```

### 2. Install the project dependencies

In the project directory, run the command to install PHP dependencies using Composer:

```bash
composer install
```

### 3. Configure the database

Create a MySQL database and configure the credentials in the .env file. Rename the .env.example file to .env:

```bash
cp .env.example .env
```

Edit the .env file and set the following variables to reflect your local environment:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Generate the application key

Run the following command to generate the Laravel key:

```bash
php artisan key:generate
```

### 5. Migrate the database

Run migrations to create the tables in the database:

```bash
php artisan migrate
```

### 6. Run the local server

Now, to run the development server, run the following command:

```bash
php artisan serve
```

The project will be available at http://localhost:8000.

### 7. (Optional) Configure a schedule to process emails periodically

If you want to schedule emails to be processed periodically, configure cron on your system to run the command below:

```bash
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

This ensures that the scheduled command will be executed automatically as configured in Kernel.php.

### API Endpoints

Here are the main API endpoints:

| HTTP Method | Endpoint | Description |
| ----------- | -------- | --------- |
| `GET` | `/api/emails` | Returns all processed emails |
| `POST` | `/api/emails` | Creates a new processed email |
| `GET` | `/api/emails/{id}` | Returns a processed email by ID |
| `PUT` | `/api/emails/{id}` | Updates the data of an existing email |
| `DELETE` | `/api/emails/{id}` | Deletes (soft delete) a processed email |

### Example POST Request to create a new email

```bash
curl -X POST http://localhost:8000/api/emails \
-H "Content-Type: application/json" \
-d '{
    "affiliate_id": 123,
    "envelope": "envelope_data",
    "from": "sender@example.com",
    "subject": "Test Subject",
    "email": "raw_email_payload",
    "to": "recipient@example.com",
    "timestamp": 1628076800
}'
```
