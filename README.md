# FeelDance

## Description

This is a Content Management System (CMS) for dance classes. It allows users to view the available classes and their respective instructors. The admin has full CRUD (Create, Read, Update, Delete) functionality and can allocate instructors to classes. The project is styled using Bootstrap and custom CSS.

## Features

- **User Features:**
  - View available dance classes
  - View members of each class, including instructors

- **Admin Features:**
  - Create, read, update, and delete classes
  - Create, read, update, and delete instructors
  - Allocate instructors to classes

## Technologies Used

- PHP
- MySQL
- Bootstrap
- CSS

## Installation and Usage

1. **Clone the repository:**
   ```bash
   git clone https://github.com/ken-yksze/http5225-a2.git
   ```

2. **Move the project to the htdocs directory:**
   ```bash
   mv http5225-a2 /path-to-your-mamp/htdocs/
   ```

3. **Create a database:**
   - Open phpMyAdmin (usually accessible via http://localhost/phpmyadmin)
   - Create a new database called feel_dance

4. **Import the database schema:**
   - Import the database.sql file located in the project root directory into the feel_dance database

5. **Update database configuration:**
   - Create .env file from .env.example and enter your database config

6. **Run the project:**
   - Start your MAMP (or any other local server)
   - Navigate to http://localhost/http5225-a2 in your web browser

## Admin Usage

- Navigate to http://localhost/http5225-a2/admin in your web browser
- username: feel
- password: feel

## Contributors

- Nitish Sharma
- Yik Kan Sze
