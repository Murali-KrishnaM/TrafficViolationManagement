# Traffic Violation Management System 🚦

A web-based application built using **PHP**, **MySQL**, and **Apache (XAMPP)** to manage traffic violations, user authentication, and fine payments.  
The system supports multiple user roles such as **civilians** and **officers**, providing dashboards and role-specific functionality.

This project was developed as part of an academic web development requirement and focuses on core backend logic, database interaction, and basic frontend design.

---

## 📌 Features

- User authentication (Signup / Login / Logout)
- Role-based dashboards (Civilian & Officer)
- Add and view traffic violations
- Fine payment processing
- Database-driven dynamic content
- Clean separation of frontend and backend logic

---

## 🛠️ Technology Stack

### Frontend
- HTML5
- CSS3

### Backend
- PHP (Procedural)
- MySQL

### Server
- Apache (via XAMPP)

---

## 📂 Project Structure

project-root/
│
├── Backend/
│ ├── add_violation.php
│ ├── db_connection.php
│ ├── get_violations.php
│ ├── logout.php
│ ├── process_login.php
│ ├── process_payment.php
│ ├── process_signup.php
│ └── view_violations.php
│
├── Frontend/
│ └── css/
│ ├── dashboardDesign.css
│ └── styles.css
│
├── add_violation.html
├── civilian_dashboard.html
├── officer_dashboard.html
├── login.html
├── signup.html
├── pay_violation.html
├── view_violations.html
├── view_violations_result.html
└── process_login.php


---

## ⚙️ Setup Instructions

### 1. Install XAMPP
Download and install XAMPP from:
https://www.apachefriends.org

### 2. Move Project to htdocs
Copy the project folder into:
xampp/htdocs/


### 3. Start Services
Open XAMPP Control Panel and start:
- Apache
- MySQL

---

## 🗄️ Database Setup

1. Open phpMyAdmin  
http://localhost/phpmyadmin

2. Create a new database:

3. Create required tables (users, violations, payments, etc.)  
*(Schema should match queries used in backend PHP files)*

4. Update database credentials in:

Backend/db_connection.php

---

🗄️ Database Schema
Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('civilian', 'officer') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

Violation Table
CREATE TABLE Violation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vehicle_id VARCHAR(50) NOT NULL,
    owner_name VARCHAR(100) NOT NULL,
    vehicle_model VARCHAR(100) NOT NULL,
    violation_type VARCHAR(100) NOT NULL,
    violation_date DATE NOT NULL,
    fine_amount DECIMAL(10,2) NOT NULL,
    payment_status ENUM('Pending', 'Paid') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

📌 Usage
Open phpMyAdmin → Select database → Paste SQL → Execute

## 🚀 Running the Project

Access the application in your browser:
http://localhost/your-project-folder/login.html


From there:
- Users can sign up and log in
- Officers can add violations
- Civilians can view and pay fines

---

## 🔐 Authentication Flow

- `process_signup.php` → Handles new user registration
- `process_login.php` → Validates credentials and sets session
- `logout.php` → Destroys session and redirects to login

---

## 💳 Payment Handling

- `pay_violation.html` → Payment UI
- `process_payment.php` → Updates payment status in database

*(Note: Payment is simulated and not integrated with real payment gateways)*

---

## 📎 Notes & Limitations

- This project focuses on **core functionality**, not production-level security
- No password hashing or advanced validation implemented
- UI is minimal and functional
- Intended for learning and academic evaluation

---

## 📄 License

This project is for educational purposes only.

---

## 👤 Author

Developed by **Murali Krishna**  
B.Tech – AI & Data Science  

