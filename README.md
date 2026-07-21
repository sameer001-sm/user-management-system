# User Management System - PHP + MySQL

A simple and secure User Management System built using PHP, MySQL and Bootstrap.

## Features
1.  **User Registration & Login**
    - Password hashing using `password_hash()`
    - Session management

2.  **Admin Dashboard**
    - View all users with JOIN from `user_roles` table
    - Search users by Name or Email
    - Edit and Delete users. Admin cannot delete/edit itself

3.  **User Profile**
    - Update Name, Email and Profile Picture
    - File Validation: Only JPG, JPEG, PNG allowed
    - File Size Limit: 2MB Max

4.  **Security**
    - Prepared Statements to prevent SQL Injection
    - Role based access: Admin / User
