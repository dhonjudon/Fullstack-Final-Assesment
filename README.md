<div align="center">

# ☕ Patio Café Management System

A full-stack PHP web application for café menu management, ordering, and revenue tracking.

### 🌐 Live Demo

| Page                | Link                                                                                                |
| ------------------- | --------------------------------------------------------------------------------------------------- |
| **Menu**            | [View Menu](https://student.heraldcollege.edu.np/~np03cs4a240155/final-asessment/public/menu.php)   |
| **Admin Login**     | [Login Page](https://student.heraldcollege.edu.np/~np03cs4a240155/final-asessment/public/login.php) |
| **Admin Dashboard** | [Dashboard](https://student.heraldcollege.edu.np/~np03cs4a240155/final-asessment/public/index.php)  |

### 🔑 Admin Credentials

| Username     | Password    |
| ------------ | ----------- |
| `root_admin` | `123456789` |

</div>

---

## 📋 Table of Contents

- [About](#-about)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Installation](#-installation)
- [Login Credentials](#-login-credentials)
- [Project Structure](#-project-structure)
- [Screenshots](#-screenshots)
- [Known Issues](#-known-issues)
- [Author](#-author)

---

## 🎯 About

**Patio Café Management System** is a comprehensive web-based solution designed for café operations. It provides a customer-facing menu with cart functionality and a powerful admin dashboard for managing menu items, processing orders, and tracking daily revenue.

Built as a final assessment project, this system demonstrates full-stack web development skills including database design, secure authentication, responsive UI, and AJAX functionality.

---

## ✨ Features

### 🛒 Customer Features

| Feature               | Description                               |
| --------------------- | ----------------------------------------- |
| **Browse Menu**       | View all menu items organized by category |
| **Cart**              | Add items, adjust quantities, view totals |
| **Checkout**          | Place orders with customer details        |
| **Responsive Design** | Works seamlessly on desktop and mobile    |

### 🔐 Admin Features

| Feature                 | Description                                |
| ----------------------- | ------------------------------------------ |
| **Menu Management**     | Full CRUD operations for menu items        |
| **Category Management** | Organize items into categories             |
| **Order Management**    | View, process, and mark orders as complete |
| **Revenue Tracking**    | Daily sales reports and analytics          |
| **Live Search**         | AJAX-powered instant search                |
| **Reset Daily Orders**  | Clear completed orders for new day         |

### 🛡️ Security Features

- PDO prepared statements (SQL injection prevention)
- Password hashing with `password_hash()`
- XSS protection with `htmlspecialchars()`
- Session-based authentication
- Server-side validation

---

## 🛠️ Tech Stack

| Layer        | Technology              |
| ------------ | ----------------------- |
| **Frontend** | HTML5, CSS3, JavaScript |
| **Backend**  | PHP 8.0+                |
| **Database** | MySQL 5.7+              |
| **Server**   | Apache (XAMPP)          |

---

## 🚀 Installation

### Prerequisites

- [XAMPP](https://www.apachefriends.org/) (or any Apache + MySQL + PHP stack)
- Web browser

### Setup Steps

1. **Clone or download** the project to your web server root:

   ```bash
   cd C:\xampp\htdocs
   git clone <repository-url> final-asessment
   ```

2. **Import the database** using phpMyAdmin or MySQL CLI:

   ```sql
   -- Import the complete database file:
   np03cs4a240155.sql
   ```

3. **Configure database connection** in `config/db.php`:

   ```php
   $host = 'localhost';
   $db   = 'patio_db';
   $user = 'root';
   $pass = '';  // Default XAMPP password is empty
   ```

4. **Start Apache and MySQL** in XAMPP Control Panel

5. **Access the application**:
   - 🌐 **Menu:** `http://localhost/final-asessment/public/menu.php`
   - 🔐 **Admin:** `http://localhost/final-asessment/public/login.php`

---

## 🔑 Login Credentials

### Admin Access

| Field        | Value                                               |
| ------------ | --------------------------------------------------- |
| **URL**      | `http://localhost/final-asessment/public/login.php` |
| **Username** | `root_admin`                                        |
| **Password** | `123456789`                                         |

### Database Access (phpMyAdmin)

| Field        | Value       |
| ------------ | ----------- |
| **Host**     | `localhost` |
| **Database** | `patio_db`  |
| **Username** | `root`      |
| **Password** | _(empty)_   |

---

## 📁 Project Structure

```
final-asessment/
├── 📂 assets/
│   ├── 📂 css/
│   │   └── style.css          # Main stylesheet
│   ├── 📂 js/
│   │   ├── main.js            # Cart functionality
│   │   └── modal.js           # Modal dialogs
│   └── 📂 img/                # Images and favicons
│
├── 📂 config/
│   └── db.php                 # Database connection
│
├── 📂 includes/
│   ├── auth.php               # Authentication functions
│   ├── functions.php          # Helper functions
│   ├── header.php             # Page header template
│   └── footer.php             # Page footer template
│
├── 📂 public/
│   ├── index.php              # Admin dashboard
│   ├── menu.php               # Public menu page
│   ├── cart.php               # Shopping cart
│   ├── checkout.php           # Checkout page
│   ├── orders.php             # Order management
│   ├── revenue.php            # Revenue tracking
│   ├── categories.php         # Category management
│   ├── search.php             # AJAX search
│   ├── add.php                # Add menu item
│   ├── edit.php               # Edit menu item
│   ├── delete.php             # Delete menu item
│   ├── login.php              # Admin login
│   └── logout.php             # Admin logout
│
├── 📂 templates/              # Optional templates
│
├── 📄 patio_db.sql            # Database schema
├── 📄 admins.sql              # Admin users
├── 📄 categories.sql          # Categories
├── 📄 orders.sql              # Orders table
├── 📄 revenue_tracking.sql    # Revenue tracking
└── 📄 README.md               # This file
```

---

## ⚠️ Known Issues

| Issue                  | Status       | Notes                               |
| ---------------------- | ------------ | ----------------------------------- |
| No CSRF protection     | 🟡 Minor     | Can be added for production         |
| No user registration   | ℹ️ By Design | Admin accounts created via database |
| No payment integration | ℹ️ Scope     | can be added for production         |

---

## 👨‍💻 Author

**Student Project** - Final Assessment

Built with ❤️ using PHP & MySQL

---

<div align="center">

</div>
